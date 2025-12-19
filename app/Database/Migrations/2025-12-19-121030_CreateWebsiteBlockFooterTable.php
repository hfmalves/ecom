<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockFooterTable extends Migration
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
            'show_info' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'show_social' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'show_opening_times' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],
            'show_newsletter' => [
                'type'    => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
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
        $this->forge->addKey('block_id');
        $this->forge->addForeignKey(
            'block_id',
            'website_home_blocks',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('website_block_footer');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_footer');
    }
}
