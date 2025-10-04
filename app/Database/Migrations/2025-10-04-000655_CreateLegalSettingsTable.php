<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLegalSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'type'        => ['type' => 'ENUM("privacy_policy","cookies_policy","terms_conditions","refund_policy")'],
            'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'content'     => ['type' => 'TEXT'],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('legal_settings');
    }

    public function down()
    {
        $this->forge->dropTable('legal_settings');
    }
}
