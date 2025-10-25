<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToOrdersShipments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders_shipments', [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders_shipments', ['created_at', 'updated_at', 'deleted_at']);
    }
}
