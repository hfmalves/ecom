<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        // 🔹 Limpa as tabelas em ordem (cuidando das FK)
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->table('order_items')->truncate();
        $this->db->table('orders')->truncate();
        $this->db->table('shipping_methods')->truncate();
        $this->db->table('payment_methods')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');

        // 🔹 Shipping Methods
        $shippingMethods = [
            ['code' => 'ctt', 'name' => 'CTT Expresso', 'created_at' => date('Y-m-d H:i:s')],
            ['code' => 'ups', 'name' => 'UPS',          'created_at' => date('Y-m-d H:i:s')],
            ['code' => 'dhl', 'name' => 'DHL',          'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('shipping_methods')->insertBatch($shippingMethods);

        // 🔹 Payment Methods
        $paymentMethods = [
            ['code' => 'multibanco', 'name' => 'Multibanco', 'created_at' => date('Y-m-d H:i:s')],
            ['code' => 'mbway',      'name' => 'MBWay',      'created_at' => date('Y-m-d H:i:s')],
            ['code' => 'paypal',     'name' => 'PayPal',     'created_at' => date('Y-m-d H:i:s')],
            ['code' => 'visa',       'name' => 'Visa',       'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('payment_methods')->insertBatch($paymentMethods);

        // 🔹 Buscar IDs reais
        $shippingIds = array_column(
            $this->db->table('shipping_methods')->select('id')->get()->getResultArray(),
            'id'
        );
        $paymentIds = array_column(
            $this->db->table('payment_methods')->select('id')->get()->getResultArray(),
            'id'
        );

        // 🔹 Dados de referência
        $users     = $this->db->table('users')->get()->getResultArray();
        $addresses = $this->db->table('user_addresses')->get()->getResultArray();
        $products  = $this->db->table('products')->get()->getResultArray();
        $variants  = $this->db->table('product_variants')->get()->getResultArray();

        if (empty($users) || empty($addresses) || empty($products)) {
            echo "⚠️ Não há users, addresses ou products suficientes para gerar orders.\n";
            return;
        }

        $statuses = ['pending','processing','completed','canceled','refunded'];

        // 🔹 Criar 100 orders
        for ($i = 1; $i <= 100; $i++) {
            $user      = $faker->randomElement($users);
            $userAddrs = array_filter($addresses, fn($a) => $a['user_id'] == $user['id']);
            if (empty($userAddrs)) continue;

            $billing  = $faker->randomElement($userAddrs);
            $shipping = $faker->randomElement($userAddrs);

            $totalItems    = 0;
            $totalTax      = 0;
            $totalDiscount = 0;
            $grandTotal    = 0;

            $orderData = [
                'user_id'             => $user['id'],
                'status'              => $faker->randomElement($statuses),
                'billing_address_id'  => $billing['id'],
                'shipping_address_id' => $shipping['id'],
                'shipping_method_id'  => $faker->randomElement($shippingIds),
                'payment_method_id'   => $faker->randomElement($paymentIds),
                'created_at'          => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
            ];
            $this->db->table('orders')->insert($orderData);
            $orderId = $this->db->insertID();

            // 🔹 Gerar entre 1–5 itens por order
            $numItems = rand(1, 5);
            for ($j = 0; $j < $numItems; $j++) {
                $product = $faker->randomElement($products);

                $prodVariants = array_filter($variants, fn($v) => $v['product_id'] == $product['id']);
                $variant = !empty($prodVariants) ? $faker->randomElement($prodVariants) : null;

                $qty      = rand(1, 3);
                $price    = $product['base_price'];
                $priceTax = $product['base_price_tax'] ?? ($price * 1.23);
                $discount = $product['discount_value'] ?? 0;
                $rowTotal = ($priceTax - $discount) * $qty;

                $this->db->table('order_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $product['id'],
                    'variant_id' => $variant['id'] ?? null,
                    'name'       => $product['name'],
                    'sku'        => $product['sku'],
                    'qty'        => $qty,
                    'price'      => $price,
                    'price_tax'  => $priceTax,
                    'discount'   => $discount,
                    'row_total'  => $rowTotal,
                    'created_at' => date('Y-m-d H:i:s'),
                ]);

                $totalItems    += ($price * $qty);
                $totalTax      += (($priceTax - $price) * $qty);
                $totalDiscount += ($discount * $qty);
                $grandTotal    += $rowTotal;
            }

            // 🔹 Atualiza totais na order
            $this->db->table('orders')
                ->where('id', $orderId)
                ->update([
                    'total_items'    => $totalItems,
                    'total_tax'      => $totalTax,
                    'total_discount' => $totalDiscount,
                    'grand_total'    => $grandTotal,
                ]);
        }

        echo "✅ Foram geradas 100 orders com itens + shipping_methods + payment_methods!\n";
    }
}
