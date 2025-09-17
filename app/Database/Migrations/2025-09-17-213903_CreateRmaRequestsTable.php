<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRmaRequestsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'    => ['type' => 'INT', 'unsigned' => true],
            'customer_id' => ['type' => 'INT', 'unsigned' => true],
            'reason'      => ['type' => 'TEXT', 'null' => true],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected', 'received', 'refunded'],
                'default'    => 'pending'
            ],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('customer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rma_requests');
    }

    public function down()
    {
        $this->forge->dropTable('rma_requests');
    }
}

