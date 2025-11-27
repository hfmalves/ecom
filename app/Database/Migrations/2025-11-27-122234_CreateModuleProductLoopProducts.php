<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateModuleProductLoopProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'module_category_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'product_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('module_category_id', 'website_module_product_loop_categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('website_module_product_loop_products');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_product_loop_products');
    }
}
