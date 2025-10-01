<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        // 🔹 Limpa as tabelas em ordem
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->table('orders_items')->truncate();
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

        // 🔹 Buscar IDs
        $shippingIds = array_column($this->db->table('shipping_methods')->select('id')->get()->getResultArray(), 'id');
        $paymentIds  = array_column($this->db->table('payment_methods')->select('id')->get()->getResultArray(), 'id');

        // 🔹 Dados de referência
        $customers = $this->db->table('customers')->get()->getResultArray();
        $addresses = $this->db->table('customers_addresses')->get()->getResultArray();
        $products  = $this->db->table('products')->get()->getResultArray();
        $variants  = $this->db->table('products_variants')->get()->getResultArray();

        if (empty($customers) || empty($addresses) || empty($products)) {
            echo "⚠️ Não há customers, addresses ou products suficientes.\n";
            return;
        }

        $statuses = ['pending','processing','completed','canceled','refunded'];

        // 🔹 Criar 100 orders
        for ($i = 1; $i <= 100; $i++) {
            $customer  = $faker->randomElement($customers);
            $custAddrs = array_filter($addresses, fn($a) => $a['customer_id'] == $customer['id']);
            if (empty($custAddrs)) continue;

            $billing  = $faker->randomElement($custAddrs);
            $shipping = $faker->randomElement($custAddrs);

            $orderData = [
                'customer_id'         => $customer['id'],
                'status'              => $faker->randomElement($statuses),
                'billing_address_id'  => $billing['id'],
                'shipping_address_id' => $shipping['id'],
                'shipping_method_id'  => $faker->randomElement($shippingIds),
                'payment_method_id'   => $faker->randomElement($paymentIds),
                'created_at'          => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
                'updated_at'          => null,
                'total_items'         => 0,
                'total_tax'           => 0,
                'total_discount'      => 0,
                'grand_total'         => 0,
            ];
            $this->db->table('orders')->insert($orderData);
            $orderId = $this->db->insertID();

            // totais
            $totalItems    = 0;
            $totalTax      = 0;
            $totalDiscount = 0;
            $grandTotal    = 0;

            // 🔹 Itens (1–5 por order)
            $numItems = rand(1, 5);
            for ($j = 0; $j < $numItems; $j++) {
                $product = $faker->randomElement($products);

                $prodVariants = array_filter($variants, fn($v) => $v['product_id'] == $product['id']);
                $variant      = !empty($prodVariants) ? $faker->randomElement($prodVariants) : null;

                $qty        = rand(1, 3);
                $priceTax   = $variant['price'] ?? ($product['base_price_tax'] ?? ($product['base_price'] * 1.23));
                $price      = round($priceTax / 1.23, 2);
                $discount   = $product['discount_value'] ?? 0;

                $rowTotal   = ($priceTax - $discount) * $qty;

                $this->db->table('orders_items')->insert([
                    'order_id'   => $orderId,
                    'product_id' => $product['id'],
                    'variant_id' => $variant['id'] ?? null,
                    'qty'        => $qty,
                    'price'      => $price,      // sem imposto
                    'price_tax'  => $priceTax,   // com imposto
                    'discount'   => $discount,
                    'row_total'  => $rowTotal,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => null,
                ]);

                $totalItems    += ($price * $qty);                      // sem imposto
                $totalTax      += (($priceTax - $price) * $qty);        // apenas imposto
                $totalDiscount += ($discount * $qty);
                $grandTotal    += $rowTotal;                            // com imposto
            }

            // Atualiza os totais na order
            $this->db->table('orders')
                ->where('id', $orderId)
                ->update([
                    'total_items'    => $totalItems,
                    'total_tax'      => $totalTax,
                    'total_discount' => $totalDiscount,
                    'grand_total'    => $grandTotal,
                ]);
        }

        echo "✅ Foram geradas 100 orders + items com totais corretos!\n";
    }
}
