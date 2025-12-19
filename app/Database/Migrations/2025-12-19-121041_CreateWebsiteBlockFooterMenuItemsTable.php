<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockFooterMenuItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'category_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'label' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'destination_type' => [
                'type'       => 'ENUM',
                'constraint' => ['page', 'category', 'url'],
            ],
            'page_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'category_ref_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'position' => [
                'type'    => 'INT',
                'default' => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey(
            'category_id',
            'website_block_footer_menu_categories',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('website_block_footer_menu_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_footer_menu_items');
    }
}
