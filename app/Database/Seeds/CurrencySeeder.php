<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'code' => 'EUR',
                'symbol' => '€',
                'exchange_rate' => 1.0000,
                'is_default' => 1,
                'status' => 1,
            ],
            [
                'code' => 'USD',
                'symbol' => '$',
                'exchange_rate' => 1.0800,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'GBP',
                'symbol' => '£',
                'exchange_rate' => 0.8600,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'BRL',
                'symbol' => 'R$',
                'exchange_rate' => 5.8500,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'CHF',
                'symbol' => 'CHF',
                'exchange_rate' => 0.9700,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'CAD',
                'symbol' => 'C$',
                'exchange_rate' => 1.4800,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'AUD',
                'symbol' => 'A$',
                'exchange_rate' => 1.6600,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'JPY',
                'symbol' => '¥',
                'exchange_rate' => 162.0000,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'CNY',
                'symbol' => '¥',
                'exchange_rate' => 7.8500,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'INR',
                'symbol' => '₹',
                'exchange_rate' => 90.0000,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'MXN',
                'symbol' => '$',
                'exchange_rate' => 18.7000,
                'is_default' => 0,
                'status' => 1,
            ],
            [
                'code' => 'ZAR',
                'symbol' => 'R',
                'exchange_rate' => 19.8000,
                'is_default' => 0,
                'status' => 1,
            ],
        ];

        // insere em batch
        $this->db->table('conf_currencies')->insertBatch($data);
    }
}
