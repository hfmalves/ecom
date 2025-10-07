<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateProductsVariantsTable extends Migration
{
    public function up()
    {
        $fields = [
            'ean' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'sku',
            ],
            'upc' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'ean',
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'upc',
            ],
            'gtin' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'isbn',
            ],
            'cost_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'gtin',
            ],
            'base_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'cost_price',
            ],
            'base_price_tax' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'base_price',
            ],
            'special_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'base_price_tax',
            ],
            'special_price_start' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'special_price',
            ],
            'special_price_end' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'special_price_start',
            ],
            'discount_type' => [
                'type'       => 'ENUM',
                'constraint' => ['percent', 'fixed'],
                'null'       => true,
                'after'      => 'special_price_end',
            ],
            'discount_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
                'after'      => 'discount_type',
            ],

            'manage_stock' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
                'after'      => 'stock_qty',
            ],
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,3',
                'null'       => true,
                'after'      => 'manage_stock',
            ],
            'width' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,3',
                'null'       => true,
                'after'      => 'weight',
            ],
            'height' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,3',
                'null'       => true,
                'after'      => 'width',
            ],
            'length' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,3',
                'null'       => true,
                'after'      => 'height',
            ],
            'tax_class_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'length',
            ],

            'status' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
                'after'      => 'is_default',
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'status',
            ],
        ];

        // Adiciona colunas novas (ou ignora se já existem)
        $this->forge->addColumn('products_variants', $fields);
    }

    public function down()
    {
        // Remove os campos (rollback)
        $this->forge->dropColumn('products_variants', [
            'product_id', 'sku', 'ean', 'upc', 'isbn', 'gtin',
            'cost_price', 'base_price', 'base_price_tax',
            'special_price', 'special_price_start', 'special_price_end',
            'discount_type', 'discount_value', 'stock_qty', 'manage_stock',
            'weight', 'width', 'height', 'length', 'tax_class_id',
            'is_default', 'status', 'created_at', 'updated_at'
        ]);
    }
}
