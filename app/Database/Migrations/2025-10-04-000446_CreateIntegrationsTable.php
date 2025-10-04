<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateIntegrationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'type'        => ['type' => 'ENUM("ERP","Marketplace","Logistics","Payment","Other")'],
            'config_json' => ['type' => 'JSON', 'null' => true],
            'status'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('integrations');
    }

    public function down()
    {
        $this->forge->dropTable('integrations');
    }
}
