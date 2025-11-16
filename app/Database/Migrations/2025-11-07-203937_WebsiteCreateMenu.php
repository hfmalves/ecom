<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class WebsiteCreateMenu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            // Para criar MENU > SUBMENU > SUB-SUBMENU
            'parent_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
            ],

            // Nome do item no menu
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],

            // Link (pode ser página, produto, categoria, etc.)
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // 0 = menu normal / 1 = mega menu
            'type' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],

            // Para banners tipo "HOMEM" / "MULHER"
            'image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // Ordenação do item no menu
            'sort_order' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            // Ativo / Inativo
            'is_active' => [
                'type'    => 'TINYINT',
                'default' => 1,
            ],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('parent_id', 'website_menu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('website_menu', true);
    }

    public function down()
    {
        $this->forge->dropTable('website_menu', true);
    }
}
