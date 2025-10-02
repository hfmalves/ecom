<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersReturnItemsModel extends Model
{
    protected $table            = 'orders_return_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'rma_request_id',
        'order_item_id',
        'qty_returned',
        'reason',
        'condition',
        'restocked_qty',
        'refund_amount',
        'status',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'qty_returned'  => 'integer',
        'restocked_qty' => 'integer',
        'refund_amount' => 'float',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true; // agora aproveita created_at e updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'rma_request_id' => 'required|integer',
        'order_item_id'  => 'required|integer',
        'qty_returned'   => 'required|integer|greater_than[0]',
        'reason'         => 'permit_empty|string',
        'condition'      => 'permit_empty|in_list[new,opened,damaged,defective]',
        'restocked_qty'  => 'permit_empty|integer',
        'refund_amount'  => 'permit_empty|decimal',
        'status'         => 'required|in_list[pending,approved,rejected,refunded,restocked]',
    ];

    protected $validationMessages = [
        'qty_returned' => [
            'required' => 'A quantidade devolvida é obrigatória.',
            'greater_than' => 'A quantidade devolvida deve ser maior que zero.',
        ],
        'status' => [
            'in_list' => 'O estado da devolução do item não é válido.',
        ],
        'condition' => [
            'in_list' => 'A condição do produto devolvido não é válida.',
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
