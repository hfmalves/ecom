<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateInvoicesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'  => ['type' => 'INT', 'unsigned' => true],
            'status'    => ['type' => 'ENUM', 'constraint' => ['pending','paid','canceled'], 'default' => 'pending'],
            'total'     => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('invoices');
    }

    public function down()
    {
        $this->forge->dropTable('invoices');
    }
}
