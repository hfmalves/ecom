<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteNewsletter extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['subscribed', 'unsubscribed'],
                'default'    => 'subscribed',
            ],

            'source' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],

            'ip_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 45,
                'null'       => true,
            ],

            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'confirmed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'unsubscribed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => false,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addKey('status');
        $this->forge->addKey('created_at');

        $this->forge->createTable('website_newsletter', true);
    }

    public function down()
    {
        $this->forge->dropTable('website_newsletter', true);
    }
}
