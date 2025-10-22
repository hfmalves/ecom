<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class OrderStatusHistorySeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');
        $orders = $this->db->table('orders')->select('id,status')->get()->getResultArray();

        foreach ($orders as $order) {
            $this->db->table('orders_status_history')->insert([
                'order_id'   => $order['id'],
                'status'     => $order['status'],
                'comment'    => $faker->sentence(),
                'created_at' => $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s'),
            ]);
        }

        echo "✅ Histórico de estados gerado para orders!\n";
    }
}
