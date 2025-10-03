<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatalogRulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'    => ['type' => 'TEXT', 'null' => true],
            'discount_type'  => ['type' => 'ENUM("percent","fixed")', 'default' => 'percent'],
            'discount_value' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'start_date'     => ['type' => 'DATETIME', 'null' => true],
            'end_date'       => ['type' => 'DATETIME', 'null' => true],
            'priority'       => ['type' => 'INT', 'constraint' => 5, 'default' => 0],
            'status'         => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('catalog_rules');
    }

    public function down()
    {
        $this->forge->dropTable('catalog_rules');
    }
}
