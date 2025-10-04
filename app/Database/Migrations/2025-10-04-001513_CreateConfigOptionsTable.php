<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfigOptionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'path'       => ['type' => 'VARCHAR', 'constraint' => 255], // ex: general/site_name
            'value'      => ['type' => 'TEXT', 'null' => true],
            'scope'      => ['type' => 'ENUM("default","website","store")', 'default' => 'default'],
            'scope_id'   => ['type' => 'INT', 'unsigned' => true, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['path', 'scope', 'scope_id']);
        $this->forge->createTable('conf_options');
    }

    public function down()
    {
        $this->forge->dropTable('conf_options');
    }
}
