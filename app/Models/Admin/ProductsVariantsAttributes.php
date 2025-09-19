<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProductsVariantsAttributes extends Model
{
    protected $table            = 'product_variant_attributes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'variant_id',
        'attribute_value_id'
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
        'variant_id'        => 'required|integer',
        'attribute_value_id'=> 'required|integer',
    ];
    protected $validationMessages = [
        'variant_id' => [
            'required' => 'O campo Variant ID é obrigatório.',
            'integer'  => 'O Variant ID deve ser um número inteiro.',
        ],
        'attribute_value_id' => [
            'required' => 'O campo Attribute Value ID é obrigatório.',
            'integer'  => 'O Attribute Value ID deve ser um número inteiro.',
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
