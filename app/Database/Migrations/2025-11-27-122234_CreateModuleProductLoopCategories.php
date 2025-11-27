<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModuleProductLoopCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
            ],

            'category_id' => [
                'type' => 'INT',
                'null' => true,
                'unsigned' => true,
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

        // fk opcional se quiseres, se não quiseres tira
        // $this->forge->addForeignKey('category_id', 'categories', 'id', 'SET NULL', 'CASCADE');

        $this->forge->createTable('website_module_product_loop_categories');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_product_loop_categories');
    }
}
