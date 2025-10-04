<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameConfigTables extends Migration
{
    public function up()
    {
        $tables = [
            'settings'              => 'conf_settings',
            'tax_classes'           => 'conf_taxes',
            'payment_methods'       => 'conf_payments',
            'shipping_methods'      => 'conf_shipping',
            'currencies'            => 'conf_currencies',
            'integrations'          => 'conf_integrations',
            'notification_settings' => 'conf_notifications',
            'email_templates'       => 'conf_emails',
            'seo_settings'          => 'conf_seo',
            'url_rewrites'          => 'conf_url_rewrites',
            'languages'             => 'conf_languages',
            'cache_settings'        => 'conf_cache',
            'system_logs'           => 'conf_system_logs',
            'legal_settings'        => 'conf_legal',
            'config_options'        => 'conf_options',
        ];

        foreach ($tables as $old => $new) {
            if ($this->db->tableExists($old) && ! $this->db->tableExists($new)) {
                $this->forge->renameTable($old, $new);
            }
        }
    }

    public function down()
    {
        $tables = [
            'conf_settings'    => 'settings',
            'conf_taxes'       => 'tax_classes',
            'conf_payments'    => 'payment_methods',
            'conf_shipping'    => 'shipping_methods',
            'conf_currencies'  => 'currencies',
            'conf_integrations'=> 'integrations',
            'conf_notifications'=> 'notification_settings',
            'conf_emails'      => 'email_templates',
            'conf_seo'         => 'seo_settings',
            'conf_url_rewrites'=> 'url_rewrites',
            'conf_languages'   => 'languages',
            'conf_cache'       => 'cache_settings',
            'conf_system_logs' => 'system_logs',
            'conf_legal'       => 'legal_settings',
            'conf_options'     => 'config_options',
        ];

        foreach ($tables as $old => $new) {
            if ($this->db->tableExists($old) && ! $this->db->tableExists($new)) {
                $this->forge->renameTable($old, $new);
            }
        }
    }
}
