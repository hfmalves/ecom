<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteHomesBlocks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'home_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'block_type' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'comment' => 'hero, faq, products_grid, etc',
            ],

            'position' => [
                'type' => 'INT',
                'default' => 0,
            ],

            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addKey(['home_id', 'block_type']);

        $this->forge->createTable('website_home_blocks');
    }

    public function down()
    {
        $this->forge->dropTable('website_home_blocks');
    }
}
