<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIsActiveAndDeletedAtToProductAttributes extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products_attributes', [
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'null'       => false,
                'after'      => 'is_filterable'
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products_attributes', ['is_active', 'deleted_at']);
    }
}
