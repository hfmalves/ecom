<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UpdateOrdersReturnsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('pt_PT');

        $statusesReturns = ['pending','approved','rejected','received','refunded'];
        $resolutions     = ['refund','replacement','store_credit'];
        $statusesItems   = ['pending','approved','rejected','received','resolved'];

        // ---- Atualizar orders_returns ----
        $returns = $this->db->table('orders_returns')->get()->getResultArray();
        $users   = $this->db->table('users')->select('id')->get()->getResultArray();

        foreach ($returns as $r) {
            $update = [];

            if (empty($r['rma_number'])) {
                $update['rma_number'] = 'RMA-' . strtoupper(uniqid());
            }

            if (empty($r['reason'])) {
                $update['reason'] = $faker->sentence(6);
            }

            if (empty($r['status'])) {
                $update['status'] = $faker->randomElement($statusesReturns);
            }

            if (empty($r['resolution'])) {
                $update['resolution'] = $faker->randomElement($resolutions);
            }

            if (empty($r['refund_amount'])) {
                $update['refund_amount'] = $faker->randomFloat(2, 5, 200);
            }

            if (empty($r['handled_by']) && !empty($users)) {
                $update['handled_by'] = $faker->randomElement($users)['id'];
            }

            if (empty($r['notes'])) {
                $update['notes'] = $faker->optional()->text(80);
            }

            if (!empty($update)) {
                $update['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('orders_returns')
                    ->where('id', $r['id'])
                    ->update($update);
            }
        }

        // ---- Atualizar orders_return_items ----
        $returnItems = $this->db->table('orders_return_items')->get()->getResultArray();

        foreach ($returnItems as $ri) {
            $update = [];

            if (empty($ri['qty_returned'])) {
                $update['qty_returned'] = rand(1, 3);
            }

            if (empty($ri['status'])) {
                $update['status'] = $faker->randomElement($statusesItems);
            }

            if (!empty($update)) {
                $update['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('orders_return_items')
                    ->where('id', $ri['id'])
                    ->update($update);
            }
        }

        echo "✅ Atualização concluída: orders_returns e orders_return_items foram completados com dados em falta.\n";
    }
}
