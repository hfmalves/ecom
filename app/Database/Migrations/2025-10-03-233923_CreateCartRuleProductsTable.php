<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCartRuleProductsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'rule_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'product_id'=>['type'=>'INT','constraint'=>11,'unsigned'=>true],
        ]);
        $this->forge->addKey('id',true);
        $this->forge->addForeignKey('rule_id','cart_rules','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('product_id','products','id','CASCADE','CASCADE');
        $this->forge->createTable('cart_rule_products');
    }

    public function down()
    {
        $this->forge->dropTable('cart_rule_products');
    }
}
