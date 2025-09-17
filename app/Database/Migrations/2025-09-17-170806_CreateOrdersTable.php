<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'status'        => [
                'type'       => 'ENUM',
                'constraint' => ['pending','processing','completed','canceled','refunded'],
                'default'    => 'pending',
            ],
            'total_items'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'total_tax'     => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'total_discount'=> ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'grand_total'   => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],

            // Shipping & Billing
            'billing_address_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'shipping_address_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'shipping_method_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'payment_method_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],



            // Timestamps
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('billing_address_id', 'user_addresses', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('shipping_address_id', 'user_addresses', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('shipping_method_id', 'shipping_methods', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('payment_method_id', 'payment_methods', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders');
    }

    public function down()
    {
        $this->forge->dropTable('orders');
    }
}
