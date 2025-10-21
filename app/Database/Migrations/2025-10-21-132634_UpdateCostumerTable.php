<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExtraFieldsToCustomers extends Migration
{
    public function up()
    {
        $fields = [
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
                'after'      => 'email',
            ],
            'date_of_birth' => [
                'type' => 'DATE',
                'null' => true,
                'after' => 'phone',
            ],
            'gender' => [
                'type' => 'ENUM',
                'constraint' => ['M', 'F', 'O'],
                'null' => true,
                'after' => 'date_of_birth',
            ],
            'newsletter_optin' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'after' => 'is_verified',
            ],
            'last_login_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'login_2step',
            ],
            'last_ip' => [
                'type' => 'VARCHAR',
                'constraint' => 45,
                'null' => true,
                'after' => 'last_login_at',
            ],
            'referral_code' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'last_ip',
            ],
            'loyalty_points' => [
                'type' => 'INT',
                'unsigned' => true,
                'default' => 0,
                'after' => 'referral_code',
            ],
            'preferred_language' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'after' => 'loyalty_points',
            ],
            'preferred_currency' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
                'after' => 'preferred_language',
            ],
            'password_reset_token' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'preferred_currency',
            ],
            'password_reset_expires' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'password_reset_token',
            ],
            'login_attempts' => [
                'type' => 'TINYINT',
                'constraint' => 3,
                'default' => 0,
                'after' => 'password_reset_expires',
            ],
            'last_failed_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'login_attempts',
            ],
            'created_by' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
                'after' => 'deleted_at',
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'created_by',
            ],
            'source' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
                'after' => 'notes',
            ],
        ];

        $this->forge->addColumn('customers', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('customers', [
            'username',
            'date_of_birth',
            'gender',
            'newsletter_optin',
            'last_login_at',
            'last_ip',
            'referral_code',
            'loyalty_points',
            'preferred_language',
            'preferred_currency',
            'password_reset_token',
            'password_reset_expires',
            'login_attempts',
            'last_failed_login',
            'created_by',
            'notes',
            'source',
        ]);
    }
}
