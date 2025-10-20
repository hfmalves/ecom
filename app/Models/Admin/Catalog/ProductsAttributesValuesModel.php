<?php

namespace App\Models\Admin\Catalog;

use CodeIgniter\Model;

class ProductsAttributesValuesModel extends Model
{
    protected $table            = 'products_attribute_values';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'attribute_id',
        'value',
        'sort_order',
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
        'attribute_id'   => 'required|integer',
        'value'        => 'required|string',
        'sort_order'    => 'required|integer',
    ];

    protected $validationMessages = [
        'attribute_id' => [
            'required' => 'O campo Attribute ID é obrigatório.',
            'integer'  => 'O Attribute ID deve ser um número inteiro.',
        ],
        'value' => [
            'required' => 'O campo naome é obrigatório.',
            'string' => 'O valor deve ser um texto válido.',
        ],
        'sort_order' => [
            'required' => 'A ordenação é obrigatório.',
            'integer'  => 'A ordenação deve ser um número inteiro.',
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
