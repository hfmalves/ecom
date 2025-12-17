<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockProductsGrid extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'grid_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'trending',
                'comment'    => 'trending | featured | new | manual',
            ],

            'items_limit' => [
                'type'    => 'INT',
                'default' => 8,
            ],

            'cols_desktop' => [
                'type'    => 'INT',
                'default' => 4,
            ],

            'cols_tablet' => [
                'type'    => 'INT',
                'default' => 3,
            ],

            'cols_mobile' => [
                'type'    => 'INT',
                'default' => 2,
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_products_grid');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_products_grid');
    }
}
