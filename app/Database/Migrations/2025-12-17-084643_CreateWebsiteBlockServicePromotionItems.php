<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockServicePromotionItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'comment'    => 'icon_shipping, icon_headphone, etc',
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'subtitle' => [
                'type' => 'TEXT',
            ],

            'position' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['block_id', 'position']);

        $this->forge->createTable('website_block_service_promotion_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_service_promotion_items');
    }
}
