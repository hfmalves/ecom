<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockHero extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],

            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'subtitle' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],

            'background_image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],

            'cta_text' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],

            'cta_link' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_hero');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_hero');
    }
}
