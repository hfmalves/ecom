<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameConfigTables extends Migration
{
    public function up()
    {
        // Exemplo: renomear todas para prefixo "conf_"
        $this->forge->renameTable('settings', 'conf_settings');
        $this->forge->renameTable('tax_classes', 'conf_taxes');
        $this->forge->renameTable('payment_methods', 'conf_payments');
        $this->forge->renameTable('shipping_methods', 'conf_shipping');
        $this->forge->renameTable('currencies', 'conf_currencies');
        $this->forge->renameTable('integrations', 'conf_integrations');
        $this->forge->renameTable('notification_settings', 'conf_notifications');
        $this->forge->renameTable('email_templates', 'conf_emails');
        $this->forge->renameTable('seo_settings', 'conf_seo');
        $this->forge->renameTable('url_rewrites', 'conf_url_rewrites');
        $this->forge->renameTable('languages', 'conf_languages');
        $this->forge->renameTable('cache_settings', 'conf_cache');
        $this->forge->renameTable('system_logs', 'conf_system_logs');
        $this->forge->renameTable('legal_settings', 'conf_legal');
        $this->forge->renameTable('config_options', 'conf_options');
    }

    public function down()
    {
        // Voltar ao nome antigo
        $this->forge->renameTable('conf_settings', 'settings');
        $this->forge->renameTable('conf_taxes', 'tax_classes');
        $this->forge->renameTable('conf_payments', 'payment_methods');
        $this->forge->renameTable('conf_shipping', 'shipping_methods');
        $this->forge->renameTable('conf_currencies', 'currencies');
        $this->forge->renameTable('conf_integrations', 'integrations');
        $this->forge->renameTable('conf_notifications', 'notification_settings');
        $this->forge->renameTable('conf_emails', 'email_templates');
        $this->forge->renameTable('conf_seo', 'seo_settings');
        $this->forge->renameTable('conf_url_rewrites', 'url_rewrites');
        $this->forge->renameTable('conf_languages', 'languages');
        $this->forge->renameTable('conf_cache', 'cache_settings');
        $this->forge->renameTable('conf_system_logs', 'system_logs');
        $this->forge->renameTable('conf_legal', 'legal_settings');
        $this->forge->renameTable('conf_options', 'config_options');
    }
}
