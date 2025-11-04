<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIncludeToCartRuleRelations extends Migration
{
    public function up()
    {
        $tables = [
            'cart_rule_products',
            'cart_rule_categories',
            'cart_rule_customer_groups',
            'cart_rule_coupons',
        ];

        foreach ($tables as $table) {
            if (! $this->db->fieldExists('include', $table)) {
                $this->forge->addColumn($table, [
                    'include' => [
                        'type'       => 'TINYINT',
                        'constraint' => 1,
                        'default'    => 1,
                        'null'       => false,
                        'after'      => 'id',
                        'comment'    => '1 = incluir, 0 = excluir',
                    ],
                ]);
            }
        }
    }

    public function down()
    {
        $tables = [
            'cart_rule_products',
            'cart_rule_categories',
            'cart_rule_customer_groups',
            'cart_rule_coupons',
        ];

        foreach ($tables as $table) {
            if ($this->db->fieldExists('include', $table)) {
                $this->forge->dropColumn($table, 'include');
            }
        }
    }
}
