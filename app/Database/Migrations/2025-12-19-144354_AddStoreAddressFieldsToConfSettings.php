<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStoreAddressFieldsToConfSettings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('conf_settings', [

            'store_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'site_name',
            ],

            'address_street' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'store_name',
            ],

            'address_postcode' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'address_street',
            ],

            'address_city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'address_postcode',
            ],

            'address_country' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'address_city',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('conf_settings', [
            'store_name',
            'address_street',
            'address_postcode',
            'address_city',
            'address_country',
        ]);
    }
}
