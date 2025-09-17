<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'   => ['type' => 'INT', 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'variant_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],

            'name'       => ['type' => 'VARCHAR', 'constraint' => 255], // snapshot do produto
            'sku'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'qty'        => ['type' => 'INT', 'default' => 1],

            'price'      => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00], // preço unitário sem imposto
            'price_tax'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00], // preço unitário com imposto
            'discount'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'row_total'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variants', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
    }
}
