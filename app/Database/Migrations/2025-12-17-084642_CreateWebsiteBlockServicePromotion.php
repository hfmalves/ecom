<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockServicePromotion extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'layout' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'horizontal',
                'comment'    => 'horizontal | vertical',
            ],

            'items_limit' => [
                'type'    => 'INT',
                'default' => 3,
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_service_promotion');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_service_promotion');
    }
}
