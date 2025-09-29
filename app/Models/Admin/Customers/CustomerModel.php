<?php

namespace App\Models\Admin\Customers;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table            = 'customers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'group_id',
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
        'group_id' => 'required|integer',
        'name'     => 'required|min_length[3]|max_length[100]',
        'email'    => 'required|valid_email|is_unique[customers.email,id,{id}]',
        'password' => 'permit_empty|min_length[6]',
        'phone'    => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'group_id' => [
            'required' => 'O grupo do cliente é obrigatório.',
            'integer'  => 'O grupo do cliente deve ser um valor numérico válido.',
        ],
        'name' => [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
        ],
        'email' => [
            'required'    => 'O email é obrigatório.',
            'valid_email' => 'O email não é válido.',
            'is_unique'   => 'Este email já está em uso.',
        ],
        'password' => [
            'min_length' => 'A password deve ter pelo menos 6 caracteres.',
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
