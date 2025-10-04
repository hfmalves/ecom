<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSeoSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'meta_title'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'meta_description'=> ['type' => 'TEXT', 'null' => true],
            'sitemap_enabled' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'robots_txt'      => ['type' => 'TEXT', 'null' => true],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('seo_settings');
    }

    public function down()
    {
        $this->forge->dropTable('seo_settings');
    }
}
