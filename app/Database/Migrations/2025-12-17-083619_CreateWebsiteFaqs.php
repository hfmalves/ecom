<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteFaqs extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'comment'    => 'Identificador lógico da FAQ',
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'context_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'global',
                'comment'    => 'global | home | page | block',
            ],

            'context_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('code');
        $this->forge->addKey(['context_type', 'context_id']);

        $this->forge->createTable('website_faqs');
    }

    public function down()
    {
        $this->forge->dropTable('website_faqs');
    }
}
