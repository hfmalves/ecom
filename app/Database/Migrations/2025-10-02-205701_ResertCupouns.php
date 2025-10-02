<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ResetCouponsAndVariants extends Migration
{
    public function up()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->query('DROP TABLE IF EXISTS coupon_categories');
        $this->db->query('DROP TABLE IF EXISTS coupon_customer_groups');
        $this->db->query('DROP TABLE IF EXISTS coupon_products');
        $this->db->query('DROP TABLE IF EXISTS coupon_usages');

        $this->db->query('DROP TABLE IF EXISTS coupons');
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        // Drop na ordem certa para evitar FK errors
        foreach ([
                     'coupon_categories',
                     'coupon_customer_groups',
                     'coupon_products',
                     'coupon_usages',
                     'coupons'
                 ] as $table) {
            $this->forge->dropTable($table, true);
        }

        /**
         * coupons
         */
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'code'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'type'        => ['type' => 'ENUM', 'constraint' => ['fixed', 'percent']],
            'value'       => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'max_uses'    => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'max_uses_per_customer' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'min_order_value'       => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'max_order_value'       => ['type' => 'DECIMAL', 'constraint' => '10,2', 'null' => true],
            'max_orders'            => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'customer_id'           => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'customer_group_id'     => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'scope'                 => ['type' => 'ENUM', 'constraint' => ['global','category','product','shipping'], 'default' => 'global'],
            'stackable'             => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_active'             => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'description'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'            => ['type' => 'DATETIME', 'null' => true],
            'updated_at'            => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'            => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('coupons');

        /**
         * coupon_usages
         */
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'coupon_id'     => ['type' => 'INT', 'unsigned' => true],
            'user_id'       => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'order_id'      => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'used_at'       => ['type' => 'DATETIME', 'null' => true],
            'discount_value'=> ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'status'        => ['type' => 'ENUM', 'constraint' => ['applied','failed','refunded'], 'default' => 'applied'],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('coupon_usages');


        /**
         * coupon_products
         */
        $this->forge->addField([
            'coupon_id'  => ['type' => 'INT', 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'unsigned' => true],
            'variant_id'  => ['type' => 'INT', 'unsigned' => true, 'null' => true], // <- ligação à tabela product_variants
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['coupon_id','product_id'], true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('coupon_products');

        /**
         * coupon_categories
         */
        $this->forge->addField([
            'coupon_id'   => ['type' => 'INT', 'unsigned' => true],
            'category_id' => ['type' => 'INT', 'unsigned' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['coupon_id','category_id'], true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('coupon_categories');

        /**
         * coupon_customer_groups
         */
        $this->forge->addField([
            'coupon_id'        => ['type' => 'INT', 'unsigned' => true],
            'customer_group_id'=> ['type' => 'INT', 'unsigned' => true],
            'created_at'       => ['type' => 'DATETIME', 'null' => true],
            'updated_at'       => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'       => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey(['coupon_id','customer_group_id'], true);
        $this->forge->addForeignKey('coupon_id', 'coupons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('coupon_customer_groups');

        // 🟢 Reativa as verificações de FK
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
    }

    public function down()
    {
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ([
                     'coupon_categories',
                     'coupon_customer_groups',
                     'coupon_products',
                     'coupon_usages',
                     'product_variants',
                     'coupons'
                 ] as $table) {
            $this->forge->dropTable($table, true);
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
