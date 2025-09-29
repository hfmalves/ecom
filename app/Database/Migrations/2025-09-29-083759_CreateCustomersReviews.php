<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersReviews extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT','unsigned'=>true,'auto_increment'=>true],
            'customer_id' => ['type' => 'INT','unsigned'=>true],
            'product_id'  => ['type' => 'INT','unsigned'=>true],
            'rating'      => ['type' => 'INT','constraint'=>1],
            'comment'     => ['type' => 'TEXT','null'=>true],
            'created_at'  => ['type' => 'DATETIME','null'=>true],
            'updated_at'  => ['type' => 'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers_reviews');
    }

    public function down()
    {
        $this->forge->dropTable('customers_reviews');
    }

}
