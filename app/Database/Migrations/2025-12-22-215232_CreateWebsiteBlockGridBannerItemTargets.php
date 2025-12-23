<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockGridBannerItemTargets extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            // FK para o card
            'banner_item_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // O que o card aponta
            'target_type' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'product',
                    'product_variant',
                    'collection',
                    'brand',
                    'promotion',
                    'custom',
                ],
            ],

            // ID quando existir (produto, variante, coleção, marca…)
            'target_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            // Valor livre (slug, código promo, etc.)
            'target_value' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'position' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'is_active' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('banner_item_id');
        $this->forge->createTable('website_block_grid_banner_item_targets');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_grid_banner_item_targets');
    }
}
