<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersTokens extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT','unsigned'=>true,'auto_increment'=>true],
            'customer_id' => ['type' => 'INT','unsigned'=>true],
            'token'       => ['type' => 'VARCHAR','constraint'=>255],
            'type'        => ['type' => "ENUM('password_reset','2fa','email_verification')"],
            'expires_at'  => ['type' => 'DATETIME'],
            'created_at'  => ['type' => 'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers_tokens');
    }

    public function down()
    {
        $this->forge->dropTable('customers_tokens');
    }

}
