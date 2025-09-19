<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class CouponUsages extends Model
{
    protected $table            = 'coupon_usages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'coupon_id',
        'user_id',
        'order_id',
        'used_at',
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
        'coupon_id' => 'required|integer',
        'user_id'   => 'required|integer',
        'order_id'  => 'permit_empty|integer',
        'used_at'   => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'coupon_id' => [
            'required' => 'O cupão é obrigatório.',
            'integer'  => 'O ID do cupão deve ser um número inteiro.',
        ],
        'user_id' => [
            'required' => 'O utilizador é obrigatório.',
            'integer'  => 'O ID do utilizador deve ser um número inteiro.',
        ],
        'order_id' => [
            'integer' => 'O ID da encomenda deve ser um número inteiro.',
        ],
        'used_at' => [
            'valid_date' => 'A data de utilização deve ser válida.',
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
