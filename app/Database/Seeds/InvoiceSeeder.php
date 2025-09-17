<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class InvoiceSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');
        $orders = $this->db->table('orders')->select('id,grand_total')->get()->getResultArray();

        foreach ($orders as $order) {
            $this->db->table('invoices')->insert([
                'order_id'   => $order['id'],
                'status'     => $faker->randomElement(['pending','paid','canceled']),
                'total'      => $order['grand_total'],
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $invoiceId = $this->db->insertID();

            if ($faker->boolean(70)) {
                $this->db->table('payments')->insert([
                    'invoice_id' => $invoiceId,
                    'amount'     => $order['grand_total'],
                    'method'     => $faker->randomElement(['Multibanco','MBWay','PayPal','Visa']),
                    'paid_at'    => $faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d H:i:s'),
                ]);
            }
        }

        echo "✅ Invoices + payments criados!\n";
    }
}
