<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'       => ['type' => 'VARCHAR', 'constraint' => 10], // pt_PT, en_US
            'name'       => ['type' => 'VARCHAR', 'constraint' => 50], // Português
            'is_default' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('languages');
    }

    public function down()
    {
        $this->forge->dropTable('languages');
    }
}
