<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameInvoicesToFinancialDocuments extends Migration
{
    public function up()
    {
        // Renomear tabela invoices -> financial_documents
        $this->forge->renameTable('invoices', 'financial_documents');
    }

    public function down()
    {
        // Se fizer rollback, volta ao nome anterior
        $this->forge->renameTable('financial_documents', 'invoices');
    }
}
