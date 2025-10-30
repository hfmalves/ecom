<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Addgatwaytopayments extends Migration
{
    public function up()
    {
        $this->forge->addColumn('conf_payments', [
            'use_gateway' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'comment'    => '0 = no, 1 = yes'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('conf_payments', 'use_gateway');
    }
}
