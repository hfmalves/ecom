<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RmaSeeder extends Seeder
{
    public function run()
    {
        // Limpar tabelas
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('rma_request_items')->truncate();
        $this->db->table('rma_requests')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');


        // Status possíveis
        $statuses = ['pending', 'approved', 'rejected', 'received', 'refunded'];

        // Razões em inglês
        $reasons = [
            'Defective product',
            'Wrong size',
            'Different color than expected',
            'Not what I expected',
            'Late delivery',
            'Changed my mind',
            'Missing parts',
            'Item damaged during transport',
            'Wrong product delivered',
            'Quality did not match description',
        ];

        $rmas  = [];
        $items = [];

        for ($i = 1; $i <= 20; $i++) {
            $status = $statuses[array_rand($statuses)];
            $reason = $reasons[array_rand($reasons)];

            $rmas[] = [
                'id'          => $i,
                'order_id'    => rand(1, 50),  // assume que tens orders 1-50
                'customer_id' => rand(1, 10), // assume que tens users 1-10
                'reason'      => $reason,
                'status'      => $status,
                'created_at'  => date('Y-m-d H:i:s', strtotime("-" . rand(0, 60) . " days")),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];

            // 1 a 3 itens por cada RMA
            $numItems = rand(1, 3);
            for ($j = 0; $j < $numItems; $j++) {
                $items[] = [
                    'rma_request_id' => $i,
                    'order_item_id'  => rand(1, 200), // assume que tens order_items 1-200
                    'qty_returned'   => rand(1, 5),
                    'status'         => $status,
                    'created_at'     => date('Y-m-d H:i:s'),
                    'updated_at'     => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('rma_requests')->insertBatch($rmas);
        $this->db->table('rma_request_items')->insertBatch($items);
    }
}
