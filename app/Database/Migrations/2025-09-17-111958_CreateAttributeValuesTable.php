<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttributeValuesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'attribute_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],
            'value' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                // ex.: 'Preto', 'Branco', '44', 'Homem'
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
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
        $this->forge->addForeignKey('attribute_id', 'attributes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attribute_values');
    }

    public function down()
    {
        $this->forge->dropTable('attribute_values');
    }
}
