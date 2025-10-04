<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificationSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'channel'     => ['type' => 'ENUM("email","sms","whatsapp","push")'],
            'provider'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'config_json' => ['type' => 'JSON', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('notification_settings');
    }

    public function down()
    {
        $this->forge->dropTable('notification_settings');
    }
}
