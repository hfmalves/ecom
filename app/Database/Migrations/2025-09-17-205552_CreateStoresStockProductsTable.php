<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoresStockProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'store_id'           => ['type' => 'INT', 'unsigned' => true],
            'product_id'         => ['type' => 'INT', 'unsigned' => true],
            'product_variant_id' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'qty'                => ['type' => 'INT', 'default' => 0],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('store_id');
        $this->forge->addKey('product_id');
        $this->forge->createTable('stores_stock_products');
    }

    public function down()
    {
        $this->forge->dropTable('stores_stock_products');
    }
}
