<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteModuleCategories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'status'        => ['type' => 'INT', 'constraint' => 11, 'default' => 1],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'category_ids'  => ['type' => 'TEXT', 'null' => true], // JSON de IDs
            'orders'        => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('website_module_categories');
    }

    public function down()
    {
        $this->forge->dropTable('website_module_categories');
    }
}
