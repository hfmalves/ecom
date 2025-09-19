<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class StoresStockProducts extends Model
{
    protected $table            = 'stores_stock_products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'store_id',
        'product_id',
        'product_variant_id',
        'qty',
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
        'store_id'          => 'required|integer',
        'product_id'        => 'required|integer',
        'product_variant_id'=> 'permit_empty|integer',
        'qty'               => 'required|integer',
    ];

    protected $validationMessages = [
        'store_id' => [
            'required' => 'O campo Store ID é obrigatório.',
            'integer'  => 'O Store ID deve ser um número inteiro.',
        ],
        'product_id' => [
            'required' => 'O campo Product ID é obrigatório.',
            'integer'  => 'O Product ID deve ser um número inteiro.',
        ],
        'product_variant_id' => [
            'integer' => 'O Product Variant ID deve ser um número inteiro.',
        ],
        'qty' => [
            'required' => 'A quantidade é obrigatória.',
            'integer'  => 'A quantidade deve ser um número inteiro.',
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
