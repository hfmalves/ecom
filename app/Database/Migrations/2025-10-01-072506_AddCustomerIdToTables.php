<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomerIdToTables extends Migration
{
    public function up()
    {
        $tables = [
            'customers_addresses',
            'customers_reviews',
            'customers_tokens',
            'customers_wishlists',
            'orders',
            'orders_carts',
            'orders_returns',
        ];

        foreach ($tables as $table) {
            if (! $this->db->fieldExists('customer_id', $table)) {
                $this->forge->addColumn($table, [
                    'customer_id' => [
                        'type'     => 'INT',
                        'unsigned' => true,
                        'null'     => false,
                        'after'    => 'id',
                    ],
                ]);

                $this->db->query("
                    ALTER TABLE `{$table}`
                    ADD CONSTRAINT `fk_{$table}_customer_id`
                    FOREIGN KEY (`customer_id`) REFERENCES `customers`(`id`)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                ");
            }
        }
    }

    public function down()
    {
        $tables = [
            'customers_addresses',
            'customers_groups',
            'customers_reviews',
            'customers_tokens',
            'customers_wishlists',
            'orders',
            'orders_carts',
            'orders_returns',
        ];

        foreach ($tables as $table) {
            if ($this->db->fieldExists('customer_id', $table)) {
                $this->db->query("ALTER TABLE `{$table}` DROP FOREIGN KEY `fk_{$table}_customer_id`");
                $this->forge->dropColumn($table, 'customer_id');
            }
        }
    }
}
