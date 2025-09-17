<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ShipmentSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');
        $orders = $this->db->table('orders')->select('id')->get()->getResultArray();

        foreach ($orders as $order) {
            if ($faker->boolean(50)) { // 50% dos pedidos têm envio
                $this->db->table('shipments')->insert([
                    'order_id'        => $order['id'],
                    'tracking_number' => strtoupper($faker->bothify('TRK####??')),
                    'carrier'         => $faker->randomElement(['CTT', 'UPS', 'DHL']),
                    'shipped_at'      => $faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d H:i:s'),
                    'created_at'      => date('Y-m-d H:i:s'),
                ]);
                $shipmentId = $this->db->insertID();

                $items = $this->db->table('order_items')->where('order_id', $order['id'])->get()->getResultArray();
                foreach ($items as $item) {
                    $this->db->table('shipment_items')->insert([
                        'shipment_id'  => $shipmentId,
                        'order_item_id'=> $item['id'],
                        'qty'          => rand(1, $item['qty']),
                    ]);
                }
            }
        }

        echo "✅ Shipments + shipment items criados!\n";
    }
}
