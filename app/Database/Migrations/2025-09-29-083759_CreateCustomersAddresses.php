<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersAddresses extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT','unsigned'=>true,'auto_increment'=>true],
            'customer_id'=> ['type' => 'INT','unsigned'=>true],
            'type'       => ['type' => 'VARCHAR','constraint'=>50,'null'=>true],
            'street'     => ['type' => 'VARCHAR','constraint'=>255],
            'city'       => ['type' => 'VARCHAR','constraint'=>100],
            'postcode'   => ['type' => 'VARCHAR','constraint'=>20],
            'country'    => ['type' => 'VARCHAR','constraint'=>100],
            'is_default' => ['type' => 'TINYINT','constraint'=>1,'default'=>0],
            'created_at' => ['type' => 'DATETIME','null'=>true],
            'updated_at' => ['type' => 'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('customers_addresses');
    }

    public function down()
    {
        $this->forge->dropTable('customers_addresses');
    }

}
