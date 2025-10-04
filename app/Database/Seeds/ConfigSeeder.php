<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigSeeder extends Seeder
{
    public function run()
    {
        // TRUNCATE para limpar as tabelas antes de inserir
        $tables = [
            'conf_cache', 'conf_currencies', 'conf_emails', 'conf_integrations',
            'conf_languages', 'conf_legal', 'conf_notifications', 'conf_options',
            'conf_payments', 'conf_seo', 'conf_settings', 'conf_shipping',
            'conf_system_logs', 'conf_taxes', 'conf_url_rewrites'
        ];
        $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
        foreach ($tables as $table) {
            $this->db->query("TRUNCATE TABLE {$table}");
        }
        $this->db->query('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================
        // CONF_CACHE
        // ==========================
        $this->db->table('conf_cache')->insert([
            'driver'      => 'file',
            'config_json' => json_encode(['path' => WRITEPATH . 'cache']),
            'status'      => 1,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);

        // ==========================
        // CONF_CURRENCIES
        // ==========================
        $this->db->table('conf_currencies')->insertBatch([
            ['code' => 'EUR', 'symbol' => '€', 'exchange_rate' => 1.000000, 'is_default' => 1, 'status' => 1],
            ['code' => 'USD', 'symbol' => '$', 'exchange_rate' => 1.050000, 'is_default' => 0, 'status' => 1],
            ['code' => 'BRL', 'symbol' => 'R$', 'exchange_rate' => 5.400000, 'is_default' => 0, 'status' => 1],
        ]);

        // ==========================
        // CONF_EMAILS
        // ==========================
        $this->db->table('conf_emails')->insertBatch([
            ['code' => 'order_confirmed', 'subject' => 'Encomenda Confirmada', 'body_html' => '<p>A sua encomenda foi confirmada!</p>', 'status' => 1],
            ['code' => 'reset_password', 'subject' => 'Redefinição de Password', 'body_html' => '<p>Clique aqui para redefinir.</p>', 'status' => 1],
            ['code' => 'shipment_tracking', 'subject' => 'O seu envio foi expedido', 'body_html' => '<p>Veja aqui o tracking.</p>', 'status' => 1],
        ]);

        // ==========================
        // CONF_INTEGRATIONS
        // ==========================
        $this->db->table('conf_integrations')->insertBatch([
            ['name' => 'SAP ERP', 'type' => 'ERP', 'config_json' => json_encode(['host'=>'sap.local']), 'status' => 0],
            ['name' => 'Amazon Marketplace', 'type' => 'Marketplace', 'config_json' => json_encode(['seller_id'=>'demo']), 'status' => 1],
            ['name' => 'CTT Expresso API', 'type' => 'Logistics', 'config_json' => json_encode(['key'=>'demo']), 'status' => 1],
        ]);

        // ==========================
        // CONF_LANGUAGES
        // ==========================
        $this->db->table('conf_languages')->insertBatch([
            ['code'=>'pt', 'name'=>'Português', 'is_default'=>1, 'status'=>1],
            ['code'=>'en', 'name'=>'English', 'is_default'=>0, 'status'=>1],
            ['code'=>'es', 'name'=>'Español', 'is_default'=>0, 'status'=>1],
        ]);

        // ==========================
        // CONF_LEGAL
        // ==========================
        $this->db->table('conf_legal')->insertBatch([
            ['type'=>'privacy_policy', 'title'=>'Política de Privacidade', 'content'=>'Texto...', 'status'=>1],
            ['type'=>'cookies_policy', 'title'=>'Política de Cookies', 'content'=>'Texto...', 'status'=>1],
            ['type'=>'terms_conditions', 'title'=>'Termos & Condições', 'content'=>'Texto...', 'status'=>1],
        ]);

        // ==========================
        // CONF_NOTIFICATIONS
        // ==========================
        $this->db->table('conf_notifications')->insertBatch([
            ['channel'=>'email', 'provider'=>'SMTP', 'config_json'=>json_encode(['host'=>'smtp.gmail.com']), 'status'=>1],
            ['channel'=>'sms', 'provider'=>'Twilio', 'config_json'=>json_encode(['sid'=>'demo']), 'status'=>0],
            ['channel'=>'whatsapp', 'provider'=>'Meta', 'config_json'=>json_encode(['token'=>'demo']), 'status'=>0],
        ]);

        // ==========================
        // CONF_OPTIONS
        // ==========================
        $this->db->table('conf_options')->insert([
            'path' => 'general/store_name',
            'value'=> 'Minha Loja Online',
            'scope'=> 'default',
            'scope_id'=> 0
        ]);

        // ==========================
        // CONF_PAYMENTS
        // ==========================
        $this->db->table('conf_payments')->insertBatch([
            ['code'=>'mbway','name'=>'MB WAY','description'=>'Pagamento instantâneo via telemóvel','is_active'=>1,'provider'=>'SIBS','config_json'=>json_encode(['entity'=>'12345']),'is_default'=>1],
            ['code'=>'multibanco','name'=>'Referências Multibanco','description'=>'Pagamento em caixas e homebanking','is_active'=>1,'provider'=>'SIBS','config_json'=>json_encode(['entity'=>'99999','subentity'=>'123']),'is_default'=>0],
            ['code'=>'paypal','name'=>'PayPal','description'=>'Pagamentos online com PayPal','is_active'=>1,'provider'=>'PayPal','config_json'=>json_encode(['client_id'=>'demo','secret'=>'demo']),'is_default'=>0],
        ]);

        // ==========================
        // CONF_SEO
        // ==========================
        $this->db->table('conf_seo')->insert([
            'meta_title'       => 'Minha Loja Online',
            'meta_description' => 'A melhor loja para compras online.',
            'sitemap_enabled'  => 1,
            'robots_txt'       => "User-agent: *\nDisallow: /admin",
            'created_at'       => date('Y-m-d H:i:s'),
            'updated_at'       => date('Y-m-d H:i:s'),
        ]);

        // ==========================
        // CONF_SETTINGS
        // ==========================
        $this->db->table('conf_settings')->insert([
            'site_name'       => 'Minha Loja Online',
            'logo'            => '/uploads/logo.png',
            'contact_email'   => 'suporte@minhaloja.pt',
            'contact_phone'   => '+351 910000000',
            'timezone'        => 'Europe/Lisbon',
            'default_currency'=> 'EUR',
            'status'          => 1,
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s'),
        ]);

        // ==========================
        // CONF_SHIPPING
        // ==========================
        $this->db->table('conf_shipping')->insertBatch([
            ['code'=>'ctt','name'=>'CTT Expresso','description'=>'Entrega 24-48h','is_active'=>1,'provider'=>'CTT','config_json'=>json_encode(['prazo'=>'24-48h']),'free_shipping_min'=>50],
            ['code'=>'pickup','name'=>'Levantamento em Loja','description'=>'Levante na nossa loja física','is_active'=>1,'provider'=>'Interno','config_json'=>json_encode([]),'free_shipping_min'=>null],
        ]);

        // ==========================
        // CONF_SYSTEM_LOGS
        // ==========================
        $this->db->table('conf_system_logs')->insert([
            'level'      => 'info',
            'message'    => 'Sistema iniciado com seeder.',
            'context'    => json_encode([]),
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // ==========================
        // CONF_TAXES
        // ==========================
        $this->db->table('conf_taxes')->insertBatch([
            ['name'=>'IVA Portugal','rate'=>23.00,'country'=>'PT','is_active'=>1],
            ['name'=>'IVA Reduzido Portugal','rate'=>6.00,'country'=>'PT','is_active'=>1],
            ['name'=>'IVA Espanha','rate'=>21.00,'country'=>'ES','is_active'=>1],
        ]);

        // ==========================
        // CONF_URL_REWRITES
        // ==========================
        $this->db->table('conf_url_rewrites')->insert([
            'source_url'  => '/old-page',
            'target_url'  => '/new-page',
            'redirect_type' => '301',
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
        ]);
    }
}
