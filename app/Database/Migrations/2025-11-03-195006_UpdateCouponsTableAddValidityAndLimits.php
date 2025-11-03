<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateCouponsTableAddValidityAndLimits extends Migration
{
    public function up()
    {
        // Adiciona colunas se não existirem
        $fields = [];

        if (!$this->db->fieldExists('starts_at', 'coupons')) {
            $fields['starts_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'description'
            ];
        }

        if (!$this->db->fieldExists('expires_at', 'coupons')) {
            $fields['expires_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'starts_at'
            ];
        }

        if (!$this->db->fieldExists('max_discount_value', 'coupons')) {
            $fields['max_discount_value'] = [
                'type' => 'DECIMAL',
                'constraint' => '10,2',
                'null' => true,
                'after' => 'value'
            ];
        }

        if (!$this->db->fieldExists('email_limit', 'coupons')) {
            $fields['email_limit'] = [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'customer_id'
            ];
        }

        if (!empty($fields)) {
            $this->forge->addColumn('coupons', $fields);
        }

        // Adiciona índices se ainda não existirem
        $existingIndexes = array_column(
            $this->db->getIndexData('coupons'),
            'name'
        );

        if (!in_array('idx_code', $existingIndexes)) {
            $this->db->query('CREATE INDEX idx_code ON coupons(code)');
        }

        if (!in_array('idx_scope', $existingIndexes)) {
            $this->db->query('CREATE INDEX idx_scope ON coupons(scope)');
        }

        if (!in_array('idx_active', $existingIndexes)) {
            $this->db->query('CREATE INDEX idx_active ON coupons(is_active)');
        }
    }

    public function down()
    {
        $fields = ['starts_at', 'expires_at', 'max_discount_value', 'email_limit'];
        foreach ($fields as $field) {
            if ($this->db->fieldExists($field, 'coupons')) {
                $this->forge->dropColumn('coupons', $field);
            }
        }

        $this->db->query('DROP INDEX IF EXISTS idx_code ON coupons');
        $this->db->query('DROP INDEX IF EXISTS idx_scope ON coupons');
        $this->db->query('DROP INDEX IF EXISTS idx_active ON coupons');
    }
}
