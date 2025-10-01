<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInvoicesTableProfessional extends Migration
{
    public function up()
    {
        $this->forge->addColumn('invoices', [
            // Identificação
            'invoice_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'unique'     => true,
                'after'      => 'order_id',
            ],
            'series' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => '2025',
                'after'      => 'invoice_number',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['invoice', 'receipt', 'credit_note', 'debit_note'],
                'default'    => 'invoice',
                'after'      => 'series',
            ],

            // Ligações por FK
            'customer_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'order_id',
            ],
            'billing_address_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'customer_id',
            ],
            'shipping_address_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'billing_address_id',
            ],
            'shipping_method_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'shipping_address_id',
            ],
            'payment_method_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'shipping_method_id',
            ],

            // Totais
            'subtotal' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'total',
            ],
            'tax_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'subtotal',
            ],
            'discount_total' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0,
                'after'      => 'tax_total',
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'default'    => 'EUR',
                'after'      => 'discount_total',
            ],

            // Pagamento
            'payment_status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'partial', 'paid', 'overdue'],
                'default'    => 'pending',
                'after'      => 'status',
            ],
            'paid_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'payment_status',
            ],
            'due_date' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'paid_at',
            ],

            // Extras
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'currency',
            ],
            'pdf_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'notes',
            ],

            // Auditoria
            'hash' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'pdf_path',
            ],
            'created_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'hash',
            ],
            'updated_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('invoices', [
            'invoice_number',
            'series',
            'type',
            'customer_id',
            'billing_address_id',
            'shipping_address_id',
            'shipping_method_id',
            'payment_method_id',
            'subtotal',
            'tax_total',
            'discount_total',
            'currency',
            'payment_status',
            'paid_at',
            'due_date',
            'notes',
            'pdf_path',
            'hash',
            'created_by',
            'updated_by',
            'updated_at',
        ]);
    }
}
