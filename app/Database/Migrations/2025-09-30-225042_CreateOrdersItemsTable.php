<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'cart_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'product_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'variant_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'qty' => [
                'type'     => 'INT',
                'unsigned' => true,
                'default'  => 1,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
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
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
// removida a FK de variant_id
        $this->forge->createTable('orders_items');

    }

    public function down()
    {
        $this->forge->dropTable('orders_items');
    }
}
