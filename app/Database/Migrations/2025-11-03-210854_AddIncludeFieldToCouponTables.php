<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIncludeFieldToCouponTables extends Migration
{
    public function up()
    {
        // coupon_products
        if (!$this->db->fieldExists('include', 'coupon_products')) {
            $this->forge->addColumn('coupon_products', [
                'include' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                    'null'       => false,
                    'after'      => 'product_id',
                ],
            ]);
        }

        // coupon_categories
        if (!$this->db->fieldExists('include', 'coupon_categories')) {
            $this->forge->addColumn('coupon_categories', [
                'include' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                    'null'       => false,
                    'after'      => 'category_id',
                ],
            ]);
        }

        // coupon_customer_groups
        if (!$this->db->fieldExists('include', 'coupon_customer_groups')) {
            $this->forge->addColumn('coupon_customer_groups', [
                'include' => [
                    'type'       => 'TINYINT',
                    'constraint' => 1,
                    'default'    => 1,
                    'null'       => false,
                    'after'      => 'customer_group_id',
                ],
            ]);
        }
    }

    public function down()
    {
        // Remove o campo caso seja feito rollback
        if ($this->db->fieldExists('include', 'coupon_products')) {
            $this->forge->dropColumn('coupon_products', 'include');
        }

        if ($this->db->fieldExists('include', 'coupon_categories')) {
            $this->forge->dropColumn('coupon_categories', 'include');
        }

        if ($this->db->fieldExists('include', 'coupon_customer_groups')) {
            $this->forge->dropColumn('coupon_customer_groups', 'include');
        }
    }
}
