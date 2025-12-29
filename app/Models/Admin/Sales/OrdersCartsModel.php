<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersCartsModel extends Model
{
    protected $table            = 'orders_carts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'customer_id',
        'user_id',
        'session_id',
        'subtotal',
        'status',
        'total_items',
        'total_value',
        'abandoned_at',
        'converted_order_id',
        'created_at',
        'updated_at'
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
        'customer_id'        => 'permit_empty|integer',
        'user_id'            => 'permit_empty|integer',
        'session_id'         => 'required|max_length[100]',
        'status'             => 'required|in_list[active,abandoned,converted]',
        'total_items'        => 'numeric',
        'total_value'        => 'numeric',
        'converted_order_id' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'session_id' => [
            'required' => 'A sessão é obrigatória.',
        ],
        'status' => [
            'in_list' => 'O estado deve ser active, abandoned ou converted.',
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
