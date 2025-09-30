<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'user_id', 'status', 'total_items', 'total_tax', 'total_discount',
        'grand_total', 'billing_address_id', 'shipping_address_id',
        'shipping_method_id', 'payment_method_id', 'created_at', 'updated_at', 'deleted_at'
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
        'user_id'            => 'required|integer',
        'status'             => 'required|in_list[pending,processing,completed,canceled]',
        'total_items'        => 'required|decimal',
        'total_tax'          => 'permit_empty|decimal',
        'total_discount'     => 'permit_empty|decimal',
        'grand_total'        => 'required|decimal',
        'billing_address_id' => 'permit_empty|integer',
        'shipping_address_id'=> 'permit_empty|integer',
        'shipping_method_id' => 'permit_empty|integer',
        'payment_method_id'  => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'status' => [
            'required' => 'O estado da encomenda é obrigatório.',
            'in_list'  => 'Estado inválido.',
        ],
        'grand_total' => [
            'required' => 'O total da encomenda é obrigatório.',
            'decimal'  => 'O total deve ser numérico.',
        ]
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
