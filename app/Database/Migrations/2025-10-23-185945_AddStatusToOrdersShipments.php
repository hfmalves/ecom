<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExtraFieldsToOrdersShipments extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('orders_shipments')) {
            $this->forge->addColumn('orders_shipments', [
                'tracking_url' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'tracking_number',
                ],
                'shipping_label_url' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'after'      => 'tracking_url',
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['pending', 'processing', 'shipped', 'delivered', 'returned', 'canceled'],
                    'default'    => 'pending',
                    'null'       => false,
                    'after'      => 'carrier',
                ],
                'delivered_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                    'after'      => 'shipped_at',
                ],
                'returned_at' => [
                    'type'       => 'DATETIME',
                    'null'       => true,
                    'after'      => 'delivered_at',
                ],
                'comments' => [
                    'type'       => 'TEXT',
                    'null'       => true,
                    'after'      => 'returned_at',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->tableExists('orders_shipments')) {
            $fields = [
                'tracking_url',
                'shipping_label_url',
                'status',
                'delivered_at',
                'returned_at',
                'comments',
            ];
            foreach ($fields as $field) {
                if ($this->db->fieldExists($field, 'orders_shipments')) {
                    $this->forge->dropColumn('orders_shipments', $field);
                }
            }
        }
    }
}
