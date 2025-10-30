<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateFinancialDocuments extends Migration
{
    public function up()
    {
        $fields = [
            'is_fiscal' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'pdf_path',
                'comment'    => '0 = interno / 1 = fiscal'
            ],
            'external_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'is_fiscal',
                'comment'    => 'ID do documento no software externo'
            ],
            'external_provider' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'external_id',
                'comment'    => 'Ex: moloni, invoicexpress, sage, etc.'
            ],
            'document_hash' => [
                'type'       => 'CHAR',
                'constraint' => 64,
                'null'       => true,
                'after'      => 'external_provider',
                'comment'    => 'Hash SHA-256 do PDF gerado'
            ],
            'approved_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
                'comment'    => 'User que aprovou o documento'
            ],
            'approved_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'approved_by',
            ],
            'canceled_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'approved_at',
                'comment'    => 'User que cancelou o documento'
            ],
            'canceled_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'canceled_by',
            ],
        ];

        $this->forge->addColumn('financial_documents', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('financial_documents', [
            'is_fiscal',
            'external_id',
            'external_provider',
            'document_hash',
            'approved_by',
            'approved_at',
            'canceled_by',
            'canceled_at'
        ]);
    }
}
