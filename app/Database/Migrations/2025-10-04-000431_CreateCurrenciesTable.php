<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCurrenciesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'          => ['type' => 'VARCHAR', 'constraint' => 10], // EUR, USD
            'symbol'        => ['type' => 'VARCHAR', 'constraint' => 10],
            'exchange_rate' => ['type' => 'DECIMAL', 'constraint' => '12,6', 'default' => 1.000000],
            'is_default'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'status'        => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('code');
        $this->forge->createTable('currencies');
    }

    public function down()
    {
        $this->forge->dropTable('currencies');
    }
}
