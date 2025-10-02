<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersReturnsModel extends Model
{
    protected $table            = 'orders_returns';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'order_id',
        'customer_id',
        'rma_number',
        'reason',
        'status',
        'resolution',
        'refund_amount',
        'handled_by',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'refund_amount' => 'float',
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true; // usa timestamps automáticos
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'order_id'     => 'required|integer',
        'customer_id'  => 'required|integer',
        'rma_number'   => 'permit_empty|string|max_length[50]',
        'reason'       => 'permit_empty|string',
        'status'       => 'required|in_list[requested,approved,rejected,refunded,completed]',
        'resolution'   => 'permit_empty|in_list[refund,replacement,store_credit]',
        'refund_amount'=> 'permit_empty|decimal',
        'handled_by'   => 'permit_empty|integer',
        'notes'        => 'permit_empty|string',
    ];

    protected $validationMessages = [
        'status' => [
            'required' => 'O estado da devolução é obrigatório.',
            'in_list'  => 'Estado inválido. Valores possíveis: requested, approved, rejected, refunded, completed.',
        ],
        'resolution' => [
            'in_list' => 'Resolução inválida. Valores possíveis: refund, replacement, store_credit.',
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

