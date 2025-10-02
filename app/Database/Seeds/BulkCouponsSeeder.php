<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BulkCouponsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');
        $db = \Config\Database::connect();

        // Carrega dados existentes (se existirem)
        $products = $db->table('products')->get()->getResultArray() ?: [];
        $variants = $db->table('products_variants')->get()->getResultArray() ?: [];
        $customers = $db->table('customers')->get()->getResultArray() ?: [];
        $groups = $db->table('customers_groups')->get()->getResultArray() ?: [];
        $categories = $db->tableExists('products_categories') ? $db->table('products_categories')->get()->getResultArray() : [];

        // Detectar se coupon_products tem coluna variant_id (opcional)
        $couponProductsFields = [];
        if ($db->tableExists('coupon_products')) {
            foreach ($db->getFieldData('coupon_products') as $f) {
                $couponProductsFields[] = $f->name;
            }
        }

        // Garantir IDs únicos sequenciais para inserir (se já existirem, insertID usará auto)
        $now = date('Y-m-d H:i:s');

        $insertedCoupons = [];

        for ($i = 1; $i <= 100; $i++) {
            // Decide tipo e valor
            $type = $faker->randomElement(['percent', 'fixed']);
            if ($type === 'percent') {
                $value = $faker->numberBetween(5, 50); // 5% - 50%
            } else {
                $value = $faker->randomFloat(2, 5, 200); // €5 - €200
            }

            // Código único
            $code = strtoupper($faker->bothify('CPN-####-???'));

            // Dates: criado entre -1 ano e hoje; expira entre hoje e +180 dias ou null
            $createdAt = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s');
            $expires = $faker->boolean(70) ? $faker->dateTimeBetween('now', '+180 days')->format('Y-m-d H:i:s') : null;

            $scope = $faker->randomElement(['global','product','category','shipping']);
            $isActive = $faker->boolean(85) ? 1 : 0;

            $couponData = [
                'code' => $code,
                'type' => $type,
                'value' => $value,
                'max_uses' => $faker->numberBetween(10, 1000),
                'max_uses_per_customer' => $faker->numberBetween(0, 5),
                'min_order_value' => $faker->randomFloat(2, 0, 100),
                'max_order_value' => null,
                'max_orders' => $faker->numberBetween(0, 50),
                'customer_id' => $faker->randomElement($customers)['id'] ?? null,
                'customer_group_id' => $faker->randomElement($groups)['id'] ?? null,
                'scope' => $scope,
                'stackable' => $faker->boolean(30) ? 1 : 0,
                'is_active' => $isActive,
                'description' => $faker->sentence(),
                'expires_at' => $expires,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            $db->table('coupons')->insert($couponData);
            $couponId = $db->insertID();
            $insertedCoupons[] = $couponId;

            // Associar coupon a produtos/variantes/categorias/grupos conforme scope
            //  - se scope == product: liga a 1-3 produtos/variantes
            //  - se scope == category: liga a 1-2 categorias (se existirem)
            //  - se scope == global: não precisa de pivot
            $linkedVariant = null;
            if ($scope === 'product' && !empty($products)) {
                $countLink = $faker->numberBetween(1, min(3, count($products)));
                $pickedProducts = $faker->randomElements($products, $countLink);
                foreach ($pickedProducts as $p) {
                    $row = [
                        'coupon_id' => $couponId,
                        'product_id' => $p['id'],
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ];
                    // se existe variant_id na tabela pivot, escolhe uma variante desse produto (quando houver)
                    if (in_array('variant_id', $couponProductsFields) && !empty($variants)) {
                        $variantsOfProduct = array_values(array_filter($variants, function($v) use ($p) { return $v['product_id'] == $p['id']; }));
                        if (!empty($variantsOfProduct)) {
                            $pickedVariant = $faker->randomElement($variantsOfProduct);
                            $row['variant_id'] = $pickedVariant['id'];
                            $linkedVariant = $pickedVariant;
                        } else {
                            $row['variant_id'] = null;
                        }
                    }
                    $db->table('coupon_products')->insert($row);
                }
            } elseif ($scope === 'category' && !empty($categories)) {
                $countLink = $faker->numberBetween(1, min(2, count($categories)));
                $pickedCats = $faker->randomElements($categories, $countLink);
                foreach ($pickedCats as $c) {
                    $db->table('coupon_categories')->insert([
                        'coupon_id' => $couponId,
                        'category_id' => $c['id'],
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                }
            }

            // Sempre com probabilidade liga a customer groups
            if (!empty($groups) && $faker->boolean(30)) {
                $group = $faker->randomElement($groups);
                $db->table('coupon_customer_groups')->insert([
                    'coupon_id' => $couponId,
                    'customer_group_id' => $group['id'],
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }

            // Criar usos reais: 0..5 usos por cupão, com probabilidade maior para cupões activos
            $maxUsages = $faker->numberBetween(0, 5);
            for ($u = 0; $u < $maxUsages; $u++) {
                if (empty($customers)) break;
                $cust = $faker->randomElement($customers);
                $orderId = $faker->numberBetween(1000, 9999);
                // used_at entre created_at e now (se created in future, use now)
                $usedAtTimestamp = $faker->dateTimeBetween($createdAt, 'now')->format('Y-m-d H:i:s');

                // calcular discount_value:
                if ($type === 'fixed') {
                    $discountValue = $value;
                } else {
                    // percent: tenta usar linked variant price, senão pick random variant, senão approximar
                    $priceBase = null;
                    if ($linkedVariant) {
                        $priceBase = (float) ($linkedVariant['price'] ?? null);
                    } elseif (!empty($variants)) {
                        $v = $faker->randomElement($variants);
                        $priceBase = (float) ($v['price'] ?? null);
                    } elseif (!empty($products)) {
                        // fallback: small approximation
                        $priceBase = $faker->randomFloat(2, 10, 200);
                    } else {
                        $priceBase = $faker->randomFloat(2, 10, 200);
                    }
                    $discountValue = round($priceBase * ($value / 100), 2);
                }

                $db->table('coupon_usages')->insert([
                    'coupon_id' => $couponId,
                    'user_id' => $cust['id'] ?? null,
                    'order_id' => $orderId,
                    'used_at' => $usedAtTimestamp,
                    'discount_value' => $discountValue,
                    'status' => $faker->randomElement(['applied', 'applied', 'failed']), // mais 'applied'
                    'created_at' => $usedAtTimestamp,
                    'updated_at' => $usedAtTimestamp,
                ]);
            }
        }

        // Feedback
        echo PHP_EOL . "Seeded " . count($insertedCoupons) . " coupons (approx) with related data." . PHP_EOL;
    }
}
