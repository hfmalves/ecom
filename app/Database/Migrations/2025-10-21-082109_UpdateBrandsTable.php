<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateBrandsTable extends Migration
{
    public function up()
    {
        // Novos campos para a tabela brands
        $fields = [
            'supplier_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ],
            'website' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'logo',
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'website',
            ],
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'country',
            ],
            'meta_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'meta_title',
            ],
            'banner' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'meta_description',
            ],
            'sort_order' => [
                'type'       => 'INT',
                'default'    => 0,
                'after'      => 'banner',
            ],
            'featured' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'sort_order',
            ],
            'created_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'featured',
            ],
            'updated_by' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'updated_at',
            ],
        ];

        // Adiciona colunas
        $this->forge->addColumn('brands', $fields);

        // Cria foreign key supplier_id → suppliers.id (se existir tabela suppliers)
        $this->db->query("
            ALTER TABLE brands
            ADD CONSTRAINT fk_brands_suppliers
            FOREIGN KEY (supplier_id)
            REFERENCES suppliers(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ");
    }

    public function down()
    {
        // Remove FK primeiro
        $this->db->query("ALTER TABLE brands DROP FOREIGN KEY fk_brands_suppliers");

        // Remove colunas adicionadas
        $this->forge->dropColumn('brands', [
            'supplier_id',
            'website',
            'country',
            'meta_title',
            'meta_description',
            'banner',
            'sort_order',
            'featured',
            'created_by',
            'updated_by',
            'deleted_at',
        ]);
    }
}
