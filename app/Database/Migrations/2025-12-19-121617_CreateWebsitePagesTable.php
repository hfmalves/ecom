<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsitePagesTable extends Migration
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

            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],

            // Tipo de link
            'link_type' => [
                'type'       => 'ENUM',
                'constraint' => ['internal', 'external'],
                'default'    => 'internal',
            ],

            'external_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // SEO
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],

            // Organização / visibilidade
            'position' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'show_in_footer' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            'show_in_header' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            // Controlo
            'template' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'default'    => 'default',
            ],

            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],

            'published_at' => [
                'type' => 'DATETIME',
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
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['store_id', 'slug']);

        $this->forge->createTable('website_pages');
    }

    public function down()
    {
        $this->forge->dropTable('website_pages');
    }
}
