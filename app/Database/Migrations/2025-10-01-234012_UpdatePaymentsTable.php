<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdatePaymentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('payments', [
            'order_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'invoice_id',
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'EUR',
                'after'      => 'amount',
            ],
            'exchange_rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,4',
                'null'       => true,
                'after'      => 'currency',
            ],
            'payment_method_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'method',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid', 'failed', 'refunded', 'partial'],
                'default'    => 'pending',
                'after'      => 'payment_method_id',
            ],
            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'status',
            ],
            'reference' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'transaction_id',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'reference',
            ],
            'created_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'after'    => 'notes',
            ],
            'updated_by' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'after'    => 'created_by',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after'=> 'updated_by',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after'=> 'created_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('payments', [
            'order_id',
            'currency',
            'exchange_rate',
            'payment_method_id',
            'status',
            'transaction_id',
            'reference',
            'notes',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at',
        ]);
    }
}
