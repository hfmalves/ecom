<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrderStatusHistoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'  => ['type' => 'INT', 'unsigned' => true],
            'status'    => ['type' => 'ENUM', 'constraint' => ['pending','processing','completed','canceled','refunded']],
            'comment'   => ['type' => 'TEXT', 'null' => true],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('order_status_history');
    }

    public function down()
    {
        $this->forge->dropTable('order_status_history');
    }
}
