<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'        => ['type' => 'VARCHAR', 'constraint' => 50, 'unique' => true],
            'type'        => ['type' => 'ENUM', 'constraint' => ['percent','fixed']],
            'value'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'max_uses'    => ['type' => 'INT', 'unsigned' => true, 'default' => 1],
            'expires_at'  => ['type' => 'DATETIME', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('coupons');
    }

    public function down()
    {
        $this->forge->dropTable('coupons');
    }
}