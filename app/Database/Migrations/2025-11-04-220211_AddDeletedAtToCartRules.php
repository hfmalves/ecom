<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDeletedAtToCartRules extends Migration
{
    public function up()
    {
        $this->forge->addColumn('cart_rules', [
            'deleted_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'updated_at',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('cart_rules', 'deleted_at');
    }
}
