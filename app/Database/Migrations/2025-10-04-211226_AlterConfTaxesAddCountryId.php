<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterConfTaxesAddCountryId extends Migration
{
    public function up()
    {
        $this->forge->addColumn('conf_taxes', [
            'country_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'rate'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('conf_taxes', 'country_id');
    }
}
