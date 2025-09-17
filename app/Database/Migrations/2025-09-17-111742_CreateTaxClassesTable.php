<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTaxClassesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'rate' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00, // ex.: 23.00 = 23%
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
                'default'    => 'PT', // código ISO do país
            ],
            'is_active' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('tax_classes');
    }

    public function down()
    {
        $this->forge->dropTable('tax_classes');
    }
}
