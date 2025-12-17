<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBlogPostCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'post_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'category_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
        ]);

        $this->forge->addKey(['post_id', 'category_id'], true);

        $this->forge->createTable('website_blog_post_categories');
    }

    public function down()
    {
        $this->forge->dropTable('website_blog_post_categories');
    }
}
