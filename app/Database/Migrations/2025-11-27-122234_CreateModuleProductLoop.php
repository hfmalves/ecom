<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModuleProductLoop extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'limit_products' => [
                'type' => 'INT',
                'default' => 8,
            ],

            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
            ],

            'is_active' => [
                'type' => 'TINYINT',
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
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('website_module_product_loop_link');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_product_loop_link');
    }
}
