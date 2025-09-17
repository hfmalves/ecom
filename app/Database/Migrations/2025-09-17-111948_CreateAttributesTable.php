<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
                // ex.: 'color', 'size', 'gender'
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                // ex.: 'Cor', 'Tamanho', 'Tipo'
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['text', 'select', 'multiselect', 'boolean', 'number'],
                'default'    => 'select',
                // define o tipo de atributo (select para dropdown, boolean, etc.)
            ],
            'is_required' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'is_filterable' => [
                'type'    => 'BOOLEAN',
                'default' => false,
                // se pode ser usado em filtros de catálogo
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'default_value' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'validation' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
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

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('attributes');
    }

    public function down()
    {
        $this->forge->dropTable('attributes');
    }
}
