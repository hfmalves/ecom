<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProductsAttributesValues extends Model
{
    protected $table            = 'attribute_values';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'product_id',
        'attribute_id',
        'value',
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
        'product_id'   => 'required|integer',
        'attribute_id' => 'required|integer',
        'value'        => 'permit_empty|string',
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'O campo Product ID é obrigatório.',
            'integer'  => 'O Product ID deve ser um número inteiro.',
        ],
        'attribute_id' => [
            'required' => 'O campo Attribute ID é obrigatório.',
            'integer'  => 'O Attribute ID deve ser um número inteiro.',
        ],
        'value' => [
            'string' => 'O valor deve ser um texto válido.',
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
