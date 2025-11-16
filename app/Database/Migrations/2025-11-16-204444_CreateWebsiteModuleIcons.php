<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteModuleIcons extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'icon'       => ['type' => 'VARCHAR', 'constraint' => 100],   // ex: icon-package
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'text'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'sort_order' => ['type' => 'INT', 'default' => 0],
            'is_active'  => ['type' => 'TINYINT', 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('website_module_icons');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_icons');
    }
}
