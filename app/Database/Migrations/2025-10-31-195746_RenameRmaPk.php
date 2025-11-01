<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameRmaPk extends Migration
{
    public function up()
    {
        // 🔹 Remover a foreign key antiga (ligada a users)
        $this->db->query('
            ALTER TABLE `orders_returns`
            DROP FOREIGN KEY `rma_requests_customer_id_foreign`;
        ');

        // 🔹 Garantir que existe o índice necessário
        $this->db->query('
            ALTER TABLE `orders_returns`
            ADD INDEX (`customer_id`);
        ');

        // 🔹 Criar nova FK para customers(id)
        $this->db->query('
            ALTER TABLE `orders_returns`
            ADD CONSTRAINT `rma_requests_customer_id_foreign`
            FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`)
            ON DELETE CASCADE ON UPDATE CASCADE;
        ');
    }

    public function down()
    {
        // Reverter: voltar a apontar para users.id
        $this->db->query('
            ALTER TABLE `orders_returns`
            DROP FOREIGN KEY `rma_requests_customer_id_foreign`;
        ');

        $this->db->query('
            ALTER TABLE `orders_returns`
            ADD CONSTRAINT `rma_requests_customer_id_foreign`
            FOREIGN KEY (`customer_id`) REFERENCES `users`(`id`)
            ON DELETE CASCADE ON UPDATE CASCADE;
        ');
    }
}
