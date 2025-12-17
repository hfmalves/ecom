<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockTopCategoryFilter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'slides_desktop' => [
                'type'    => 'INT',
                'default' => 5,
            ],

            'slides_tablet' => [
                'type'    => 'INT',
                'default' => 3,
            ],

            'slides_mobile' => [
                'type'    => 'INT',
                'default' => 2,
            ],

            'autoplay_delay' => [
                'type'    => 'INT',
                'default' => 5000,
            ],

            'loop' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_top_category_filter');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_top_category_filter');
    }
}
