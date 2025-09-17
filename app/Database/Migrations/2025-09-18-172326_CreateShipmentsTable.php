<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShipmentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'order_id'        => ['type' => 'INT', 'unsigned' => true],
            'tracking_number' => ['type' => 'VARCHAR', 'constraint' => 100],
            'carrier'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'shipped_at'      => ['type' => 'DATETIME', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('shipments');
    }

    public function down()
    {
        $this->forge->dropTable('shipments');
    }
}
