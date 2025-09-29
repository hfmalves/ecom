<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersWishlists extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT','unsigned'=>true,'auto_increment'=>true],
            'customer_id' => ['type' => 'INT','unsigned'=>true],
            'product_id'  => ['type' => 'INT','unsigned'=>true],
            'created_at'  => ['type' => 'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers_wishlists');
    }

    public function down()
    {
        $this->forge->dropTable('customers_wishlists');
    }

}
