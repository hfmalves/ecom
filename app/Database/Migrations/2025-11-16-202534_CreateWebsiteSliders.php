<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWebsiteSliders extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'auto_increment' => true],
            'title'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'subtitle'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'price_old'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'price_new'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'cta_text'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'cta_url'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'image'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'sort_order'    => ['type' => 'INT', 'default' => 0],
            'is_active'     => ['type' => 'TINYINT', 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('website_sliders');
    }

    public function down()
    {
        $this->forge->dropTable('website_sliders');
    }
}
