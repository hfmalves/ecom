<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartsAndCartItems extends Migration
{
    public function up()
    {
        // orders_cart
        $this->forge->addColumn('orders_carts', [
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active','abandoned','converted'],
                'default'    => 'active',
                'after'      => 'session_id',
            ],
            'total_items' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'status',
            ],
            'total_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'total_items',
            ],
            'abandoned_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after'=> 'total_value',
            ],
            'converted_order_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'abandoned_at',
            ],
        ]);

        // orders_cart_items
        $this->forge->addColumn('orders_cart_items', [
            'removed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after'=> 'updated_at',
            ],
            'discount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'removed_at',
            ],
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'discount',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('orders_cart', [
            'status','total_items','total_value','abandoned_at','converted_order_id'
        ]);

        $this->forge->dropColumn('orders_cart_items', [
            'removed_at','discount','subtotal'
        ]);
    }
}
