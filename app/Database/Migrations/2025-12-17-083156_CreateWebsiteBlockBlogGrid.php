<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockBlogGrid extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'section_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'default'    => 'Our Blog',
            ],

            'items_limit' => [
                'type'    => 'INT',
                'default' => 3,
                'comment' => 'Quantos posts mostrar',
            ],

            'slides_desktop' => [
                'type'    => 'INT',
                'default' => 3,
            ],

            'slides_tablet' => [
                'type'    => 'INT',
                'default' => 2,
            ],

            'slides_mobile' => [
                'type'    => 'INT',
                'default' => 1,
            ],

            'autoplay_delay' => [
                'type'    => 'INT',
                'default' => 5000,
            ],
            'loop' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_blog_grid');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_blog_grid');
    }
}
