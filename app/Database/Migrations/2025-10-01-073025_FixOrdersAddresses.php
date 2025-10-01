<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixOrdersAddresses extends Migration
{
    public function up()
    {
        // drop FK antiga para users_addresses
        $this->db->query("ALTER TABLE `orders` DROP FOREIGN KEY `orders_billing_address_id_foreign`");
        $this->db->query("ALTER TABLE `orders` DROP FOREIGN KEY `orders_shipping_address_id_foreign`");

        // agora recria FK para customers_addresses
        $this->db->query("
            ALTER TABLE `orders`
            ADD CONSTRAINT `fk_orders_billing_address`
            FOREIGN KEY (`billing_address_id`) REFERENCES `customers_addresses`(`id`)
            ON DELETE CASCADE ON UPDATE CASCADE
        ");

        $this->db->query("
            ALTER TABLE `orders`
            ADD CONSTRAINT `fk_orders_shipping_address`
            FOREIGN KEY (`shipping_address_id`) REFERENCES `customers_addresses`(`id`)
            ON DELETE CASCADE ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // se precisares de reverter (voltar a users_addresses)
        $this->db->query("ALTER TABLE `orders` DROP FOREIGN KEY `fk_orders_billing_address`");
        $this->db->query("ALTER TABLE `orders` DROP FOREIGN KEY `fk_orders_shipping_address`");

        $this->db->query("
            ALTER TABLE `orders`
            ADD CONSTRAINT `orders_billing_address_id_foreign`
            FOREIGN KEY (`billing_address_id`) REFERENCES `users_addresses`(`id`)
            ON DELETE CASCADE ON UPDATE SET NULL
        ");

        $this->db->query("
            ALTER TABLE `orders`
            ADD CONSTRAINT `orders_shipping_address_id_foreign`
            FOREIGN KEY (`shipping_address_id`) REFERENCES `users_addresses`(`id`)
            ON DELETE CASCADE ON UPDATE SET NULL
        ");
    }
}
