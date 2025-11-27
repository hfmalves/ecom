<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateHomeModules extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true,
            ],

            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],

            'sort_order' => [
                'type'       => 'INT',
                'default'    => 0,
                'null'       => false,
            ],

            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'settings' => [
                'type' => 'JSON',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        $this->forge->createTable('website_module_home');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_home');
    }
}
