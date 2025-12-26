<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateWebsiteHomesAddFields extends Migration
{
    public function up()
    {
        $this->forge->addColumn('website_homes', [
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => false,
            ],
            'is_default' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],
            'active_start' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'active_end' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('website_homes', [
            'name',
            'is_default',
            'active_start',
            'active_end',
        ]);
    }
}
