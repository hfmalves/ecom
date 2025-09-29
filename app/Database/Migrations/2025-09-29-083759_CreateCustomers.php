<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT','unsigned'=>true,'auto_increment'=>true],
            'name'        => ['type' => 'VARCHAR','constraint'=>150],
            'email'       => ['type' => 'VARCHAR','constraint'=>150],
            'password'    => ['type' => 'VARCHAR','constraint'=>255],
            'phone'       => ['type' => 'VARCHAR','constraint'=>20,'null'=>true],
            'is_active'   => ['type' => 'TINYINT','constraint'=>1,'default'=>1],
            'is_verified' => ['type' => 'TINYINT','constraint'=>1,'default'=>0],
            'login_2step' => ['type' => 'TINYINT','constraint'=>1,'default'=>0],
            'created_at'  => ['type' => 'DATETIME','null'=>true],
            'updated_at'  => ['type' => 'DATETIME','null'=>true],
            'deleted_at'  => ['type' => 'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers');
    }

    public function down()
    {
        $this->forge->dropTable('customers');
    }

}
