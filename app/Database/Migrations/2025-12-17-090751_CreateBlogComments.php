<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogComments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'post_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'author_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'author_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'content' => [
                'type' => 'TEXT',
            ],

            'is_approved' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('post_id');

        $this->forge->createTable('website_blog_comments');
    }

    public function down()
    {
        $this->forge->dropTable('website_blog_comments');
    }
}
