<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockGridBannerItems extends Migration
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

            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],

            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'text_color' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'dark',
                'comment'    => 'dark | light',
            ],

            'position' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'is_active' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey(['block_id', 'position']);

        $this->forge->createTable('website_block_grid_banner_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_grid_banner_items');
    }
}
