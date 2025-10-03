<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCampaignsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'discount_type' => ['type' => 'ENUM("percent","fixed")', 'default' => 'percent'],
            'discount_value'=> ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'start_date'    => ['type' => 'DATETIME'],
            'end_date'      => ['type' => 'DATETIME'],
            'status'        => ['type' => 'ENUM("active","inactive")', 'default' => 'inactive'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('campaigns');
    }

    public function down()
    {
        $this->forge->dropTable('campaigns');
    }
}
