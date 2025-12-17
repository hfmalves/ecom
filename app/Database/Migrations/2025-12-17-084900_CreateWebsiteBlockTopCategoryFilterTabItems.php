<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockTopCategoryFilterTabItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'tab_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'product_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            'product_variant_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
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
        $this->forge->addKey(['tab_id', 'position']);

        $this->forge->createTable('website_block_top_category_filter_tab_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_top_category_filter_tab_items');
    }
}
