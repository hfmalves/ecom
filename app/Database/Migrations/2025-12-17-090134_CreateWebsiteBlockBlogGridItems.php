<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockBlogGridItems extends Migration
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

            // ligação opcional ao sistema de blog
            'post_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'ID do post real (se existir)',
            ],

            // fallback / override manual
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'author' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'published_at' => [
                'type' => 'DATE',
                'null' => true,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'excerpt' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'position' => [
                'type'    => 'INT',
                'default' => 0,
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
        $this->forge->addKey(['block_id', 'position']);
        $this->forge->addKey('post_id');

        $this->forge->createTable('website_block_blog_grid_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_blog_grid_items');
    }
}
