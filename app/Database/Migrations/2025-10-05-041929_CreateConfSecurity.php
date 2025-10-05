<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateConfSecurity extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],

            // Configurações principais
            'password_min_length'  => ['type' => 'INT', 'constraint' => 3, 'default' => 8],
            'session_timeout'      => ['type' => 'INT', 'constraint' => 5, 'default' => 30, 'comment' => 'Minutos'],
            'login_attempts_limit' => ['type' => 'INT', 'constraint' => 3, 'default' => 5],
            'enable_2fa'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'csrf_protection'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],

            // Extras úteis para segurança avançada
            'lockout_duration'     => ['type' => 'INT', 'constraint' => 5, 'default' => 15, 'comment' => 'Minutos bloqueado após tentativas falhadas'],
            'password_expiry_days' => ['type' => 'INT', 'constraint' => 5, 'default' => 90],
            'require_uppercase'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'require_numbers'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'require_specials'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'ip_block_enabled'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'allowed_ip_ranges'    => ['type' => 'TEXT', 'null' => true, 'comment' => 'Lista de IPs ou ranges permitidos'],

            // Auditoria
            'created_at'           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'           => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('conf_security', true);
    }

    public function down()
    {
        $this->forge->dropTable('conf_security', true);
    }
}
