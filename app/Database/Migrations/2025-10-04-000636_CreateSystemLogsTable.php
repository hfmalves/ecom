<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSystemLogsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'level'      => ['type' => 'ENUM("info","warning","error","critical")', 'default' => 'info'],
            'message'    => ['type' => 'TEXT'],
            'context'    => ['type' => 'JSON', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => false],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('system_logs');
    }

    public function down()
    {
        $this->forge->dropTable('system_logs');
    }
}
