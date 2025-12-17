<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockHeroSlides extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'background_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'button_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'button_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'position' => [
                'type'    => 'INT',
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
        $this->forge->addKey('block_id');

        $this->forge->createTable('website_block_hero_slides');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_hero_slides');
    }
}
