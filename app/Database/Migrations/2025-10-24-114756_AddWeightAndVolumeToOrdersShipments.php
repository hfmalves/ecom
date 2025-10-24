<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWeightAndVolumeToOrdersShipments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('orders_shipments', [
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'default'    => 0.000,
                'after'      => 'returned_at',
            ],
            'volume' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,3',
                'default'    => 0.000,
                'after'      => 'weight',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders_shipments', ['weight', 'volume']);
    }
}
