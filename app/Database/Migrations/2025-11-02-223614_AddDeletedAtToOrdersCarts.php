<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToOrdersCarts extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('deleted_at', 'orders_carts')) {
            $this->forge->addColumn('orders_carts', [
                'deleted_at' => [
                    'type'    => 'DATETIME',
                    'null'    => true,
                    'default' => null,
                    'after'   => 'updated_at', // opcional, coloca a coluna após updated_at
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('deleted_at', 'orders_carts')) {
            $this->forge->dropColumn('orders_carts', 'deleted_at');
        }
    }
}
