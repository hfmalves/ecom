<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CustomersGroupsSeeder extends Seeder
{
    public function run()
    {
        $groups = [
            [
                'name'            => 'Padrão',
                'description'     => 'Grupo atribuído por defeito a novos clientes.',
                'discount_percent'=> 0,
                'min_order_value' => 0,
                'max_order_value' => null,
                'is_default'      => 1,
                'status'          => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'VIP',
                'description'     => 'Clientes com descontos exclusivos e vantagens.',
                'discount_percent'=> 15,
                'min_order_value' => 100,
                'max_order_value' => null,
                'is_default'      => 0,
                'status'          => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Revendedor',
                'description'     => 'Clientes empresariais ou revendedores autorizados.',
                'discount_percent'=> 25,
                'min_order_value' => 500,
                'max_order_value' => null,
                'is_default'      => 0,
                'status'          => 'active',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
            [
                'name'            => 'Bloqueado',
                'description'     => 'Clientes que perderam acesso devido a má conduta.',
                'discount_percent'=> 0,
                'min_order_value' => 0,
                'max_order_value' => null,
                'is_default'      => 0,
                'status'          => 'inactive',
                'created_at'      => date('Y-m-d H:i:s'),
                'updated_at'      => date('Y-m-d H:i:s'),
            ],
        ];

        // insere grupos
        $this->db->table('customers_groups')->insertBatch($groups);

        // pega os IDs dos grupos inseridos
        $groupIds = $this->db->table('customers_groups')->select('id')->get()->getResultArray();
        $groupIds = array_column($groupIds, 'id');

        // pega os clientes existentes
        $customers = $this->db->table('customers')->select('id')->get()->getResultArray();

        foreach ($customers as $customer) {
            $randomGroup = $groupIds[array_rand($groupIds)];

            $this->db->table('customers')
                ->where('id', $customer['id'])
                ->update(['group_id' => $randomGroup]);
        }
    }
}
