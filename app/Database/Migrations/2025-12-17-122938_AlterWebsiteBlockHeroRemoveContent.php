<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterWebsiteBlockHeroRemoveContent extends Migration
{
    public function up()
    {
        // remover colunas de conteúdo
        $this->forge->dropColumn('website_block_hero', [
            'title',
            'subtitle',
            'background_image',
            'cta_text',
            'cta_link',
        ]);
    }

    public function down()
    {
        // repor colunas caso seja preciso rollback
        $this->forge->addColumn('website_block_hero', [
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'subtitle' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'background_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'cta_text' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'cta_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);
    }
}
