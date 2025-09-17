<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShipmentItemsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'shipment_id' => ['type' => 'INT', 'unsigned' => true],
            'order_item_id'=> ['type' => 'INT', 'unsigned' => true],
            'qty'         => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('shipment_id', 'shipments', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_item_id', 'order_items', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('shipment_items');
    }

    public function down()
    {
        $this->forge->dropTable('shipment_items');
    }
}
