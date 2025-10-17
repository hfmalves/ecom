<?php

namespace App\Models\Admin\Catalog;

use CodeIgniter\Model;

class ProductsPackItemModel extends Model
{
    protected $table            = 'products_pack_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'product_id',
        'product_sku',
        'product_type',
        'qty',
        'cost_price',
        'base_price',
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
        'product_sku'  => 'required|string|max_length[100]',
        'qty'          => 'required|numeric|greater_than_equal_to[1]',
        'cost_price'   => 'permit_empty|decimal',
        'base_price'   => 'permit_empty|decimal',
    ];
    protected $validationMessages = [
        'product_id' => [
            'required' => 'O campo Produto é obrigatório.',
            'integer'  => 'O ID do produto deve ser um número inteiro.',
        ],
        'product_sku' => [
            'required' => 'O SKU do produto é obrigatório.',
        ],
        'qty' => [
            'required' => 'A quantidade é obrigatória.',
            'numeric'  => 'A quantidade deve ser numérica.',
            'greater_than_equal_to' => 'A quantidade deve ser pelo menos 1.',
        ],
        'cost_price' => [
            'decimal' => 'O preço de custo deve ser um valor decimal válido.',
        ],
        'base_price' => [
            'decimal' => 'O preço base deve ser um valor decimal válido.',
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
