<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToProductsAttributeValues extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products_attribute_values', [
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products_attribute_values', 'deleted_at');
    }
}
