<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatalogSettings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'key' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'type' => [
                'type' => "ENUM('text','number','boolean','select','json')",
                'default' => 'text',
            ],
            'options' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('conf_catalog_settings', true);
    }

    public function down()
    {
        $this->forge->dropTable('conf_catalog_settings', true);
    }
}
