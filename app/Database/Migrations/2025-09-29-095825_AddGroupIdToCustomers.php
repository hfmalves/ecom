<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGroupIdToCustomers extends Migration
{
    public function up()
    {
        // adiciona a coluna group_id
        $this->forge->addColumn('customers', [
            'group_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id', // opcional: mete logo a seguir ao id
            ],
        ]);

        // adiciona a foreign key
        $this->db->query("
            ALTER TABLE customers 
            ADD CONSTRAINT fk_customers_group
            FOREIGN KEY (group_id) 
            REFERENCES customers_groups(id)
            ON UPDATE CASCADE 
            ON DELETE SET NULL
        ");
    }

    public function down()
    {
        // remove a FK primeiro
        $this->db->query("ALTER TABLE customers DROP FOREIGN KEY fk_customers_group");

        // depois remove a coluna
        $this->forge->dropColumn('customers', 'group_id');
    }
}
