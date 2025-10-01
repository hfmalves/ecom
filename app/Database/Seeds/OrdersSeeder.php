<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class OrdersSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        // 🔥 limpa só os items (deixa as orders quietas)
        $this->db->table('orders_items')->truncate();

        // busca todas as orders existentes
        $orders = $this->db->table('orders')->get()->getResultArray();

        foreach ($orders as $order) {
            $orderId = $order['id'];

            // 1. decide a quantidade total (random 1 a 20)
            $totalUnits = $faker->numberBetween(1, 20);

            // 2. decide quantos produtos diferentes (máx. 3)
            $numProducts = min($totalUnits, $faker->numberBetween(1, 3));

            $orderItems = [];
            $subtotal   = 0;
            $unitsLeft  = $totalUnits;

            // 3. cria os items com base no totalUnits
            for ($j = 1; $j <= $numProducts; $j++) {
                $productId = $faker->numberBetween(1, 50); // assume 50 produtos na tabela

                $product = $this->db->table('products')
                    ->select('base_price_tax')
                    ->where('id', $productId)
                    ->get()
                    ->getRowArray();

                $price = $product ? (float) $product['base_price_tax'] : 0;

                // se for o último produto, leva o resto
                if ($j === $numProducts) {
                    $qty = $unitsLeft;
                } else {
                    $qty = $faker->numberBetween(1, $unitsLeft - ($numProducts - $j));
                }

                $unitsLeft -= $qty;
                $lineTotal  = $price * $qty;

                $orderItems[] = [
                    'order_id'   => $orderId,
                    'cart_id'    => null,
                    'product_id' => $productId,
                    'variant_id' => null,
                    'qty'        => $qty,
                    'price'      => $price,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => null,
                ];

                $subtotal += $lineTotal;
            }

            // insere os items na tabela
            $this->db->table('orders_items')->insertBatch($orderItems);

            // 4. recalcula totais da order
            $tax      = $subtotal * 0.23; // IVA fixo 23%
            $discount = ($faker->boolean(20)) ? $subtotal * 0.1 : 0; // 20% chance de 10% desconto
            $grand    = $subtotal + $tax - $discount;

            // 5. atualiza a ordem
            $this->db->table('orders')
                ->where('id', $orderId)
                ->update([
                    'total_items'    => $totalUnits,
                    'total_tax'      => $tax,
                    'total_discount' => $discount,
                    'grand_total'    => $grand,
                    'updated_at'     => date('Y-m-d H:i:s'),
                ]);

            // opcional: mostrar progresso no terminal
            echo "Ordem #{$orderId} → {$totalUnits} unidades, {$numProducts} produtos, total {$grand}€\n";
        }
    }
}
