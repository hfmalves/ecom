<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UsersWishlists extends Model
{
    protected $table            = 'user_wishlists';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'product_id',
        'created_at',
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
        'user_id'    => 'required|integer',
        'product_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'O campo User ID é obrigatório.',
            'integer'  => 'O User ID deve ser um número inteiro.',
        ],
        'product_id' => [
            'required' => 'O campo Product ID é obrigatório.',
            'integer'  => 'O Product ID deve ser um número inteiro.',
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
