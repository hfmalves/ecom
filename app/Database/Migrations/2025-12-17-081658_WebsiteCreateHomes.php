<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WebsiteCreateHomes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'store_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'home_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'comment'    => 'Identificador lógico da home (ex: default, natal, black_friday)',
            ],

            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'comment'  => 'Bloco de conteúdo (banner, vitrine, carrossel, etc)',
            ],

            'position' => [
                'type'    => 'INT',
                'default' => 0,
                'comment' => 'Ordem do bloco na home',
            ],

            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addKey(['store_id', 'home_code']);
        $this->forge->addKey('block_id');

        $this->forge->createTable('website_homes');
    }

    public function down()
    {
        $this->forge->dropTable('website_homes');
    }
}
