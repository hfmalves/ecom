<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'site_name'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'logo'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'contact_email'   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'contact_phone'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'timezone'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Europe/Lisbon'],
            'default_currency'=> ['type' => 'VARCHAR', 'constraint' => 10, 'default' => 'EUR'],
            'status'          => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('settings');
    }

    public function down()
    {
        $this->forge->dropTable('settings');
    }
}
