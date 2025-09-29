<?php

namespace App\Models\Admin\Orders;

use CodeIgniter\Model;

class OrdersCartItems extends Model
{
    protected $table            = 'orders_cart_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['cart_id','product_id','variant_id','qty','price','created_at','updated_at'];

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
        'cart_id'    => 'required|integer',
        'product_id' => 'required|integer',
        'variant_id' => 'permit_empty|integer',
        'qty'        => 'required|integer',
        'price'      => 'required|decimal',
    ];

    protected $validationMessages = [
        'qty' => ['required' => 'A quantidade é obrigatória.'],
        'price' => ['required' => 'O preço é obrigatório.'],
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
