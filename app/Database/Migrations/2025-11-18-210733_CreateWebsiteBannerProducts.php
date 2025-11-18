<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteBannerProducts extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],

            // Nome do bloco
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            // Imagem principal do banner
            'banner_image'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            // posição do layout: left ou right
            'position'      => ['type' => 'ENUM("left","right")', 'default' => 'right'],

            // lista de produtos em JSON
            'product_ids'   => ['type' => 'TEXT', 'null' => true],

            // pins em JSON (opcional)
            'pins'          => ['type' => 'TEXT', 'null' => true],

            // ordenação na página
            'sort_order'    => ['type' => 'INT', 'default' => 0],

            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('website_module_banner_products_positions');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_banner_products_positions');
    }
}
