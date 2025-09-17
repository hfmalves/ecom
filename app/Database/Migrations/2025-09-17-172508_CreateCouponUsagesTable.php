<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCouponUsagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'coupon_id'=> ['type' => 'INT', 'unsigned' => true],
            'user_id'  => ['type' => 'INT', 'unsigned' => true],
            'order_id' => ['type' => 'INT', 'unsigned' => true],
            'used_at'  => ['type' => 'DATETIME'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('coupon_usages');
    }

    public function down()
    {
        $this->forge->dropTable('coupon_usages');
    }
}