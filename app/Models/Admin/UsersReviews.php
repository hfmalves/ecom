<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class UsersReviews extends Model
{
    protected $table            = 'users_reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'created_at',
        'updated_at',
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
        'user_id'    => 'required|integer',
        'product_id' => 'required|integer',
        'rating'     => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'comment'    => 'permit_empty|string',
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
        'rating' => [
            'required'              => 'A classificação é obrigatória.',
            'integer'               => 'A classificação deve ser um número inteiro.',
            'greater_than_equal_to' => 'A classificação mínima é 1.',
            'less_than_equal_to'    => 'A classificação máxima é 5.',
        ],
        'comment' => [
            'string' => 'O comentário deve ser um texto válido.',
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
