<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'   => ['type' => 'INT', 'unsigned' => true],
            'type'      => ['type' => 'ENUM', 'constraint' => ['billing', 'shipping'], 'default' => 'shipping'],
            'street'    => ['type' => 'VARCHAR', 'constraint' => 255],
            'city'      => ['type' => 'VARCHAR', 'constraint' => 150],
            'postcode'  => ['type' => 'VARCHAR', 'constraint' => 20],
            'country'   => ['type' => 'VARCHAR', 'constraint' => 2, 'default' => 'PT'], // ISO code
            'is_default'=> ['type' => 'BOOLEAN', 'default' => false],
            'created_at'=> ['type' => 'DATETIME', 'null' => true],
            'updated_at'=> ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_addresses');
    }

    public function down()
    {
        $this->forge->dropTable('user_addresses');
    }
}
