<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBlockGridBanner extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'block_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'columns_desktop' => [
                'type'    => 'INT',
                'default' => 4,
                'comment' => 'Número de colunas no desktop',
            ],

            'columns_tablet' => [
                'type'    => 'INT',
                'default' => 2,
            ],

            'columns_mobile' => [
                'type'    => 'INT',
                'default' => 1,
            ],

            'image_size' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'large',
                'comment'    => 'small | medium | large',
            ],
        ]);

        $this->forge->addKey('block_id', true);
        $this->forge->createTable('website_block_grid_banner');
    }

    public function down()
    {
        $this->forge->dropTable('website_block_grid_banner');
    }
}
