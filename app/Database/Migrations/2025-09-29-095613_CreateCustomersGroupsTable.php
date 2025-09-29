<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCustomersGroupsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'            => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'description'     => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'discount_percent'=> [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],
            'min_order_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => 0.00,
            ],
            'max_order_value' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'is_default'      => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '1 = grupo atribuído por defeito a novos clientes',
            ],
            'status'          => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'inactive'],
                'default'    => 'active',
            ],
            'created_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'deleted_at'      => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('name');

        $this->forge->createTable('customers_groups');
    }

    public function down()
    {
        $this->forge->dropTable('customers_groups');
    }
}
