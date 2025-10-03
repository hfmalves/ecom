<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartRuleCouponsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'rule_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'code'=>['type'=>'VARCHAR','constraint'=>100],
            'uses_per_coupon'=>['type'=>'INT','constraint'=>11,'default'=>0], // 0 = ilimitado
            'uses_per_customer'=>['type'=>'INT','constraint'=>11,'default'=>0],
            'times_used'=>['type'=>'INT','constraint'=>11,'default'=>0],
            'created_at'=>['type'=>'DATETIME','null'=>true],
            'updated_at'=>['type'=>'DATETIME','null'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('rule_id','cart_rules','id','CASCADE','CASCADE');
        $this->forge->createTable('cart_rule_coupons');
    }

    public function down()
    {
        $this->forge->dropTable('cart_rule_coupons');
    }
}
