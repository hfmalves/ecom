<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OrdersReturnsHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rma_request_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'order_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'order_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'item_in_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'item_out_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'qty_in' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
            ],
            'qty_out' => [
                'type'    => 'INT',
                'default' => 0,
                'null'    => false,
            ],
            'handled_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['rma_request_id', 'order_id']);
        $this->forge->addForeignKey('rma_request_id', 'orders_returns', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('orders_returns_history', true);
    }

    public function down()
    {
        $this->forge->dropTable('orders_returns_history', true);
    }
}
