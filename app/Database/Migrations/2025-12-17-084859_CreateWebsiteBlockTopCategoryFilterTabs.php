<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockTopCategoryFilterTabs extends Migration
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

            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            'source_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'comment'    => 'all | top_sales | top_views | trending | manual',
            ],

            'items_limit' => [
                'type'    => 'INT',
                'default' => 10,
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

        $this->forge->createTable('website_block_top_category_filter_tabs');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_top_category_filter_tabs');
    }
}
