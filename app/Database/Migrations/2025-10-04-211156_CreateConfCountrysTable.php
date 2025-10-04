<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfCountrysTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'code'        => ['type' => 'VARCHAR', 'constraint' => 2, 'null' => false], // ISO2 ex: PT
            'iso3'        => ['type' => 'VARCHAR', 'constraint' => 3, 'null' => true], // ISO3 ex: PRT
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => false],
            'currency'    => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'phone_code'  => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'is_active'   => ['type' => 'BOOLEAN', 'default' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('conf_countries');
    }

    public function down()
    {
        $this->forge->dropTable('conf_countries');
    }
}
