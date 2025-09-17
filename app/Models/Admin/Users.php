<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'phone',
        'is_active',
        'is_verified',
        'login_2step',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    protected $validationRules = [
        'username'       => 'required|min_length[3]|max_length[100]',
        'email'      => 'required|valid_email|is_unique[users.email,id,{id}]',
        'password'   => 'min_length[6]',
        'phone'      => 'permit_empty|min_length[9]|max_length[20]',
        'is_active'  => 'in_list[0,1]',
        'is_verified'=> 'in_list[0,1]',
        'login_2step'=> 'in_list[0,1]',
    ];
    protected $validationMessages = [
        'username' => [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode ultrapassar 100 caracteres.',
        ],
        'email' => [
            'required'    => 'O email é obrigatório.',
            'valid_email' => 'O email não é válido.',
            'is_unique'   => 'Este email já está registado.',
        ],
        'password' => [
            'min_length'  => 'A password deve ter pelo menos 6 caracteres.',
        ],
        'phone' => [
            'min_length'  => 'O número de telefone deve ter pelo menos 9 dígitos.',
            'max_length'  => 'O número de telefone não pode ultrapassar 20 dígitos.',
        ],
        'is_active' => [
            'in_list'     => 'O campo ativo deve ser 0 ou 1.',
        ],
        'is_verified' => [
            'in_list'     => 'O campo verificado deve ser 0 ou 1.',
        ],
        'login_2step' => [
            'in_list'     => 'O campo 2FA deve ser 0 ou 1.',
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
