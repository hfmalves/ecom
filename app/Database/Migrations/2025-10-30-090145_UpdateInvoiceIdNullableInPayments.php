<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateInvoiceIdNullableInPayments extends Migration
{
    public function up()
    {
        // Remove a FK antiga
        $this->db->query('ALTER TABLE `payments` DROP FOREIGN KEY `payments_invoice_id_foreign`;');

        // Altera o tipo da coluna para coincidir com financial_documents.id (INT UNSIGNED NULL)
        $this->db->query('ALTER TABLE `payments` MODIFY `invoice_id` INT UNSIGNED NULL;');

        // Recria a FK com ON DELETE SET NULL
        $this->db->query('ALTER TABLE `payments` 
            ADD CONSTRAINT `payments_invoice_id_foreign`
            FOREIGN KEY (`invoice_id`) 
            REFERENCES `financial_documents`(`id`)
            ON DELETE SET NULL 
            ON UPDATE CASCADE;');
    }

    public function down()
    {
        // Reverte (volta a ser NOT NULL e ON DELETE CASCADE)
        $this->db->query('ALTER TABLE `payments` DROP FOREIGN KEY `payments_invoice_id_foreign`;');
        $this->db->query('ALTER TABLE `payments` MODIFY `invoice_id` INT UNSIGNED NOT NULL;');
        $this->db->query('ALTER TABLE `payments` 
            ADD CONSTRAINT `payments_invoice_id_foreign`
            FOREIGN KEY (`invoice_id`) 
            REFERENCES `financial_documents`(`id`)
            ON DELETE CASCADE 
            ON UPDATE CASCADE;');
    }
}
