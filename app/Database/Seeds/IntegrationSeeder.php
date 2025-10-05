<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class IntegrationSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 💼 ERP
            [
                'name' => 'Moloni ERP',
                'type' => 'ERP',
                'config_json' => json_encode([
                    'api_key' => '',
                    'api_secret' => '',
                    'company_id' => '',
                    'sandbox' => false,
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'Tiflux ERP',
                'type' => 'ERP',
                'config_json' => json_encode([
                    'api_key' => '',
                    'endpoint' => 'https://api.tiflux.pt/',
                    'sandbox' => false,
                ], JSON_PRETTY_PRINT),
                'status' => 0,
            ],

            // 🛒 Marketplaces
            [
                'name' => 'Amazon Marketplace',
                'type' => 'Marketplace',
                'config_json' => json_encode([
                    'seller_id' => '',
                    'access_key' => '',
                    'secret_key' => '',
                    'region' => 'EU',
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'eBay Marketplace',
                'type' => 'Marketplace',
                'config_json' => json_encode([
                    'app_id' => '',
                    'cert_id' => '',
                    'redirect_uri' => '',
                    'sandbox' => false,
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],

            // 🚚 Logística
            [
                'name' => 'CTT Expresso',
                'type' => 'Logistics',
                'config_json' => json_encode([
                    'client_id' => '',
                    'client_secret' => '',
                    'account' => '',
                    'sandbox' => true,
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'DPD Portugal',
                'type' => 'Logistics',
                'config_json' => json_encode([
                    'username' => '',
                    'password' => '',
                    'api_url' => 'https://api.dpd.pt/',
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'GLS',
                'type' => 'Logistics',
                'config_json' => json_encode([
                    'username' => '',
                    'password' => '',
                    'api_url' => 'https://api.gls-group.eu/',
                ], JSON_PRETTY_PRINT),
                'status' => 0,
            ],

            // 💳 Pagamentos
            [
                'name' => 'Ifthenpay',
                'type' => 'Payment',
                'config_json' => json_encode([
                    'entity' => '',
                    'subentity' => '',
                    'key' => '',
                    'methods' => ['multibanco', 'mbway', 'payshop'],
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'EuPago',
                'type' => 'Payment',
                'config_json' => json_encode([
                    'key' => '',
                    'sandbox' => false,
                    'methods' => ['mbway', 'multibanco'],
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],

            // ⚙️ Outros
            [
                'name' => 'Google Analytics',
                'type' => 'Other',
                'config_json' => json_encode([
                    'tracking_id' => '',
                    'measurement_id' => '',
                    'active' => true,
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
            [
                'name' => 'Facebook Pixel',
                'type' => 'Other',
                'config_json' => json_encode([
                    'pixel_id' => '',
                    'access_token' => '',
                    'active' => true,
                ], JSON_PRETTY_PRINT),
                'status' => 1,
            ],
        ];

        $this->db->table('conf_integrations')->insertBatch($data);
    }
}
