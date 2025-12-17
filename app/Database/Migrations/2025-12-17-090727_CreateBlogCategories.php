<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'unique'     => true,
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

        // apenas PK
        $this->forge->addKey('id', true);

        $this->forge->createTable('website_blog_categories');
    }

    public function down()
    {
        $this->forge->dropTable('website_blog_categories');
    }
}
