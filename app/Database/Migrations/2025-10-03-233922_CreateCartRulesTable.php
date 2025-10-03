<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartRulesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name'           => ['type'=>'VARCHAR','constraint'=>255],
            'description'    => ['type'=>'TEXT','null'=>true],
            'discount_type'  => ['type'=>'ENUM("percent","fixed","free_shipping","buy_x_get_y")','default'=>'percent'],
            'discount_value' => ['type'=>'DECIMAL','constraint'=>'10,2','default'=>0.00],
            'condition_json' => ['type'=>'JSON','null'=>true], // subtotal_min, qty_min, etc.
            'start_date'     => ['type'=>'DATETIME','null'=>true],
            'end_date'       => ['type'=>'DATETIME','null'=>true],
            'priority'       => ['type'=>'INT','constraint'=>5,'default'=>0],
            'status'         => ['type'=>'TINYINT','constraint'=>1,'default'=>1],
            'created_at'     => ['type'=>'DATETIME','null'=>true],
            'updated_at'     => ['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->createTable('cart_rules');
    }

    public function down()
    {
        $this->forge->dropTable('cart_rules');
    }
}
