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
        'status'       => 'required|in_list[requested,approved,rejected,refunded,completed,pending,received]',
        'notes'        => 'required|string|max_length[1000]',
        'notify_client'=> 'permit_empty|in_list[0,1,true,false]',
        'resolution'   => 'required|in_list[refund,replacement,store_credit]',

        'refund_amount'=> 'permit_empty|decimal',
        'handled_by'   => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'status' => [
            'required' => 'O estado da devolução é obrigatório.',
            'in_list'  => 'Estado inválido.',
        ],
        'resolution' => [
            'required' => 'A resolução é obrigatória.',
            'in_list'  => 'Resolução inválida. Valores possíveis: refund, replacement, store_credit.',
        ],
        'notes' => [
            'required' => 'As notas internas são obrigatórias.',
            'string'   => 'O campo notas deve ser texto.',
            'max_length' => 'As notas não podem ultrapassar 1000 caracteres.',
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

