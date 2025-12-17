<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogPosts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],

            'excerpt' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'content' => [
                'type' => 'LONGTEXT',
            ],

            'featured_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            'author_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['draft', 'published'],
                'default'    => 'draft',
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

        // PK apenas
        $this->forge->addKey('id', true);
        $this->forge->createTable('website_blog_posts');
    }

    public function down()
    {
        $this->forge->dropTable('website_blog_posts');
    }
}
