<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersItemsModel extends Model
{
    protected $table            = 'orders_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'order_id',
        'cart_id',
        'product_id',
        'variant_id',
        'qty',
        'price',       // sem imposto
        'price_tax',   // com imposto
        'discount',
        'subtotal',
        'row_total',   // valor final do item (qty * (price_tax - discount))
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'qty'        => 'integer',
        'price'      => 'float',
        'price_tax'  => 'float',
        'discount'   => 'float',
        'subtotal'   => 'float',
        'row_total'  => 'float',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'order_id'   => 'required|integer',
        'product_id' => 'required|integer',
        'qty'        => 'required|integer|greater_than[0]',
        'price'      => 'required|decimal',
        'price_tax'  => 'permit_empty|decimal',
        'discount'   => 'permit_empty|decimal',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'A ordem é obrigatória',
            'integer'  => 'O ID da ordem deve ser um número',
        ],
        'product_id' => [
            'required' => 'O produto é obrigatório',
            'integer'  => 'O ID do produto deve ser um número',
        ],
        'qty' => [
            'required'     => 'A quantidade é obrigatória',
            'integer'      => 'A quantidade tem de ser um número',
            'greater_than' => 'A quantidade tem de ser pelo menos 1',
        ],
        'price' => [
            'required' => 'O preço é obrigatório',
            'decimal'  => 'O preço tem de ser um número decimal válido',
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
