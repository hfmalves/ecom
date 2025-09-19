<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSupplierIdTo extends Migration
{
    public function up()
    {
        $this->forge->addColumn('products', [
            'supplier_id' => [
                'type'       => 'INT',
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('products', 'supplier_id');
    }
}
