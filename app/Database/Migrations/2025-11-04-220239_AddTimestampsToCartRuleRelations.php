<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToCartRuleRelations extends Migration
{
    public function up()
    {
        $tables = [
            'cart_rule_products',
            'cart_rule_customer_groups',
            'cart_rule_categories',
        ];

        foreach ($tables as $table) {
            $this->forge->addColumn($table, [
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'include',
                ],
                'updated_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'created_at',
                ],
                'deleted_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                    'after' => 'updated_at',
                ],
            ]);
        }
    }

    public function down()
    {
        $tables = [
            'cart_rule_products',
            'cart_rule_customer_groups',
            'cart_rule_categories',
        ];

        foreach ($tables as $table) {
            $this->forge->dropColumn($table, ['created_at', 'updated_at', 'deleted_at']);
        }
    }
}
