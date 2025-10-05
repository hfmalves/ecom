<?php

namespace App\Models\Admin\Configurations\Security;

use CodeIgniter\Model;

class SecurityModel extends Model
{
    protected $table            = 'conf_security';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'password_min_length',
        'session_timeout',
        'login_attempts_limit',
        'enable_2fa',
        'csrf_protection',
        'lockout_duration',
        'password_expiry_days',
        'require_uppercase',
        'require_numbers',
        'require_specials',
        'ip_block_enabled',
        'allowed_ip_ranges',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'password_min_length'  => 'required|integer|greater_than_equal_to[4]',
        'session_timeout'      => 'required|integer|greater_than[0]',
        'login_attempts_limit' => 'required|integer|greater_than[0]',
        'enable_2fa'           => 'in_list[0,1]',
        'csrf_protection'      => 'in_list[0,1]',
        'lockout_duration'     => 'integer',
        'password_expiry_days' => 'integer',
        'require_uppercase'    => 'in_list[0,1]',
        'require_numbers'      => 'in_list[0,1]',
        'require_specials'     => 'in_list[0,1]',
        'ip_block_enabled'     => 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'password_min_length' => [
            'greater_than_equal_to' => 'A password deve ter pelo menos {param} caracteres.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
