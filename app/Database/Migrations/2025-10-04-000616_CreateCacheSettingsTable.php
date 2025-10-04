<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCacheSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'driver'      => ['type' => 'ENUM("file","redis","memcached")', 'default' => 'file'],
            'config_json' => ['type' => 'JSON', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('cache_settings');
    }

    public function down()
    {
        $this->forge->dropTable('cache_settings');
    }
}
