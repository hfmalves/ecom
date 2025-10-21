<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateSuppliersTable extends Migration
{
    public function up()
    {
        $fields = [
            'code' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'unique'     => true,
                'after'      => 'id',
            ],
            'swift' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'iban',
            ],
            'risk_level' => [
                'type'       => "ENUM('low','medium','high')",
                'default'    => 'low',
                'after'      => 'status',
            ],
            'type' => [
                'type'       => "ENUM('manufacturer','distributor','service','other')",
                'default'    => 'manufacturer',
                'after'      => 'risk_level',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'api_url',
            ],
            'logo' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'api_url',
            ],
        ];

        $this->forge->addColumn('suppliers', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('suppliers', ['code', 'swift', 'risk_level', 'type', 'notes', 'logo']);
    }
}
