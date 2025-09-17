<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStoresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'        => ['type' => 'VARCHAR', 'constraint' => 150],
            'code'        => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'address'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'city'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'country'     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'postal_code' => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'latitude'    => ['type' => 'DECIMAL', 'constraint' => '10,8', 'null' => true],
            'longitude'   => ['type' => 'DECIMAL', 'constraint' => '11,8', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('stores');
    }

    public function down()
    {
        $this->forge->dropTable('stores');
    }
}
