<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUrlRewritesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'source_url'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'target_url'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'redirect_type'=> ['type' => 'ENUM("301","302")', 'default' => '301'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('url_rewrites');
    }

    public function down()
    {
        $this->forge->dropTable('url_rewrites');
    }
}
