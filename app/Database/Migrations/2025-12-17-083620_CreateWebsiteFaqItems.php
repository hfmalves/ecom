<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteFaqItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'faq_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'question' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],

            'answer' => [
                'type' => 'TEXT',
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
        $this->forge->addKey(['faq_id', 'position']);

        $this->forge->createTable('website_faq_items');
    }

    public function down()
    {
        $this->forge->dropTable('website_faq_items');
    }
}
