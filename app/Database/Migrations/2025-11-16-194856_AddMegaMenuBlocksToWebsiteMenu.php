<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMegaMenuBlocksToWebsiteMenu extends Migration
{
    public function up()
    {
        $this->forge->addColumn('website_menu', [

            // 0 = normal link
            // 1 = mega-menu category group
            // 2 = bloco de produtos recentes
            // 3 = bloco imagem + CTA (Shop Now)
            'block_type' => [
                'type'    => 'TINYINT',
                'default' => 0,
                'null'    => false,
            ],

            // JSON com os dados que cada bloco usa
            'block_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],

        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('website_menu', 'block_type');
        $this->forge->dropColumn('website_menu', 'block_data');
    }
}
