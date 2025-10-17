<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProductsPackItems extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
                'comment'    => 'ID do produto principal (tipo pack)',
            ],
            'product_sku' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => false,
                'comment'    => 'SKU do produto ou variante incluído no pack',
            ],
            'product_type' => [
                'type'       => 'ENUM',
                'constraint' => ['product', 'variant'],
                'default'    => 'product',
                'comment'    => 'Identifica se é produto simples ou variante',
            ],
            'qty' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 1.00,
                'comment'    => 'Quantidade incluída no pack',
            ],
            'cost_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'comment'    => 'Custo unitário do item',
            ],
            'base_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
                'comment'    => 'Preço unitário do item',
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

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('products_pack_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('products_pack_items', true);
    }
}
