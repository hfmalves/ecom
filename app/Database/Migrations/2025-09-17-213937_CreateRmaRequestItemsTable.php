<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRmaRequestItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'rma_request_id' => ['type' => 'INT', 'unsigned' => true],
            'order_item_id'  => ['type' => 'INT', 'unsigned' => true],
            'qty_returned'   => ['type' => 'INT', 'default' => 1],
            'status'         => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected', 'received', 'refunded'],
                'default'    => 'pending'
            ],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rma_request_id', 'rma_requests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_item_id', 'order_items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rma_request_items');
    }

    public function down()
    {
        $this->forge->dropTable('rma_request_items');
    }
}
