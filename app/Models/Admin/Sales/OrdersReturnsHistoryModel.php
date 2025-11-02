<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersReturnsHistoryModel extends Model
{
    protected $table            = 'orders_returns_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'rma_request_id',
        'order_id',
        'status',
        'order_status',
        'reason',
        'notes',
        'item_in_id',
        'item_out_id',
        'qty_in',
        'qty_out',
        'handled_by',
        'created_at'
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
        'rma_request_id' => 'required|integer',
        'order_id'       => 'required|integer',
        'status'         => 'required|string|max_length[50]',
        'order_status'   => 'permit_empty|string|max_length[50]',
        'reason'         => 'permit_empty|string',
        'notes'          => 'permit_empty|string',
        'item_in_id'     => 'permit_empty|integer',
        'item_out_id'    => 'permit_empty|integer',
        'qty_in'         => 'permit_empty|integer',
        'qty_out'        => 'permit_empty|integer',
        'handled_by'     => 'permit_empty|integer',
        'created_at'     => 'required|valid_date[Y-m-d H:i:s]',
    ];

    protected $validationMessages = [
        'rma_request_id' => [
            'required' => 'O ID da devolução é obrigatório.',
        ],
        'order_id' => [
            'required' => 'O ID da encomenda é obrigatório.',
        ],
        'status' => [
            'required'   => 'O estado da devolução é obrigatório.',
            'max_length' => 'O estado não pode exceder 50 caracteres.',
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
