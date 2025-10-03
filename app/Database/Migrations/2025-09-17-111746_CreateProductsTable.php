<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            // Identificadores
            'sku' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'ean' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'upc' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'isbn' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'gtin' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            // Infos básicas
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'short_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'brand_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],
            'category_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            // === Preços ===
            'cost_price' => [ // preço de custo (interno, nunca mostrado ao cliente)
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'base_price' => [ // preço de venda definido pela loja (sem impostos, antes de descontos)
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'base_price_tax' => [ // preço de venda base + impostos (sem descontos)
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'special_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'special_price_start' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'special_price_end' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'discount_type' => [
                'type'       => 'ENUM',
                'constraint' => ['percent', 'fixed'],
                'null'       => true,
            ],
            'discount_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            // === Stock ===
            'stock_qty' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'manage_stock' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
            ],

            // === Tipo & Visibilidade ===
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['simple', 'configurable', 'virtual', 'pack'],
                'default'    => 'simple',
            ],
            'visibility' => [
                'type'       => 'ENUM',
                'constraint' => ['catalog', 'search', 'both', 'none'],
                'default'    => 'both',
            ],

            // === Peso & Dimensões ===
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
            ],
            'width' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
            ],
            'height' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
            ],
            'length' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
            ],

            // === SEO ===
            'meta_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'meta_description' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
            ],
            'meta_keywords' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],

            // === Flags ===
            'is_featured' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'is_new' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],

            // === Taxas ===
            'tax_class_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
            ],

            // === Estado & timestamps ===
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive', 'draft', 'archived'],
                'default'    => 'active',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->addKey('ean');
        $this->forge->addKey('upc');
        $this->forge->addKey('isbn');
        $this->forge->addKey('gtin');
        $this->forge->addForeignKey('brand_id', 'brands', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tax_class_id', 'tax_classes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products');
    }

    public function down()
    {
        $this->forge->dropTable('products');
    }
}
