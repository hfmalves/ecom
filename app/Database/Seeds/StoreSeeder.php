<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Loja Lisboa',
                'code' => 'lisboa',
                'address' => 'Rua Augusta 100',
                'city' => 'Lisboa',
                'country' => 'Portugal',
                'postal_code' => '1100-053',
                'latitude' => 38.7169,
                'longitude' => -9.139,
            ],
            [
                'name' => 'Loja Porto',
                'code' => 'porto',
                'address' => 'Av. dos Aliados 200',
                'city' => 'Porto',
                'country' => 'Portugal',
                'postal_code' => '4000-064',
                'latitude' => 41.1496,
                'longitude' => -8.6109,
            ],
        ];

        $this->db->table('stores')->insertBatch($data);
    }
}
