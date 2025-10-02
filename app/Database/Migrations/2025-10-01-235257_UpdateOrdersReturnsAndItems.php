<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOrdersReturnsAndItems extends Migration
{
    public function up()
    {
        /**
         * 🔹 Atualizar tabela orders_returns
         */
        $this->forge->addColumn('orders_returns', [
            'rma_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'unique'     => true,
                'after'      => 'customer_id',
            ],
            'resolution' => [
                'type'       => 'ENUM',
                'constraint' => ['refund', 'replacement', 'store_credit'],
                'null'       => true,
                'after'      => 'status',
            ],
            'refund_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'resolution',
            ],
            'handled_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'refund_amount',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'handled_by',
            ],
        ]);

        /**
         * 🔹 Atualizar tabela orders_return_items
         */
        $this->forge->addColumn('orders_return_items', [
            'reason' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'qty_returned',
            ],
            'condition' => [
                'type'       => 'ENUM',
                'constraint' => ['new', 'opened', 'damaged', 'defective'],
                'default'    => 'new',
                'after'      => 'reason',
            ],
            'restocked_qty' => [
                'type'       => 'INT',
                'default'    => 0,
                'after'      => 'condition',
            ],
            'refund_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'restocked_qty',
            ],
        ]);
    }

    public function down()
    {
        // Reverter orders_returns
        $this->forge->dropColumn('orders_returns', [
            'rma_number',
            'resolution',
            'refund_amount',
            'handled_by',
            'notes',
        ]);

        // Reverter orders_return_items
        $this->forge->dropColumn('orders_return_items', [
            'reason',
            'condition',
            'restocked_qty',
            'refund_amount',
        ]);
    }
}
