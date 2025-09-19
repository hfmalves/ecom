<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UsersAddress extends Model
{
    protected $table            = 'users_addresses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'type',
        'street',
        'city',
        'postcode',
        'country',
        'is_default',
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

    // Validation
    protected $validationRules = [
        'user_id'   => 'required|integer',
        'type'      => 'required|string|max_length[50]',
        'street'    => 'required|string|max_length[255]',
        'city'      => 'required|string|max_length[150]',
        'postcode'  => 'required|string|max_length[20]',
        'country'   => 'required|string|max_length[100]',
        'is_default'=> 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'O campo User ID é obrigatório.',
            'integer'  => 'O User ID deve ser um número inteiro.',
        ],
        'type' => [
            'required'   => 'O tipo de endereço é obrigatório.',
            'string'     => 'O tipo deve ser um texto.',
            'max_length' => 'O tipo não pode ter mais de 50 caracteres.',
        ],
        'street' => [
            'required'   => 'A rua é obrigatória.',
            'string'     => 'A rua deve ser um texto válido.',
            'max_length' => 'A rua não pode ter mais de 255 caracteres.',
        ],
        'city' => [
            'required'   => 'A cidade é obrigatória.',
            'string'     => 'A cidade deve ser um texto válido.',
            'max_length' => 'A cidade não pode ter mais de 150 caracteres.',
        ],
        'postcode' => [
            'required'   => 'O código postal é obrigatório.',
            'string'     => 'O código postal deve ser texto válido.',
            'max_length' => 'O código postal não pode ter mais de 20 caracteres.',
        ],
        'country' => [
            'required'   => 'O país é obrigatório.',
            'string'     => 'O país deve ser texto válido.',
            'max_length' => 'O país não pode ter mais de 100 caracteres.',
        ],
        'is_default' => [
            'required' => 'É necessário indicar se é endereço padrão.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
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
