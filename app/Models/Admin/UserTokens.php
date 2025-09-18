<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UserTokens extends Model
{
    protected $table            = 'user_tokens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'token',
        'type',
        'expires_at',
        'created_at'
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
        'user_id'   => 'required|is_natural_no_zero',
        'token'     => 'required|min_length[4]|max_length[255]',
        'type'      => 'required|in_list[password_reset,2fa,email_verification]',
        'expires_at'=> 'required|valid_date[Y-m-d H:i:s]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'O campo user_id é obrigatório.',
            'is_natural_no_zero' => 'O user_id tem de ser um número válido.',
        ],
        'token' => [
            'required' => 'O token é obrigatório.',
            'min_length' => 'O token deve ter pelo menos 10 caracteres.',
            'max_length' => 'O token não pode ultrapassar 255 caracteres.',
        ],
        'type' => [
            'required' => 'O tipo de token é obrigatório.',
            'in_list' => 'O tipo tem de ser: password_reset, 2fa ou email_verification.',
        ],
        'expires_at' => [
            'required' => 'A data de expiração é obrigatória.',
            'valid_date' => 'A data de expiração não tem um formato válido (Y-m-d H:i:s).',
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
