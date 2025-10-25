<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersShipmentHistoryModel extends Model
{
    protected $table            = 'orders_shipments_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'shipment_id',
        'status',
        'carrier',
        'tracking',
        'comment',
        'created_at',
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
        'shipment_id' => 'required|integer',
        'status'      => 'required|in_list[pending,processing,shipped,delivered,returned,canceled]',
        'carrier'     => 'permit_empty|max_length[100]',
        'tracking'    => 'permit_empty|max_length[100]',
        'comment'     => 'permit_empty|string',
    ];

    protected $validationMessages = [
        'shipment_id' => [
            'required' => 'O ID do envio é obrigatório.',
            'integer'  => 'O ID do envio deve ser numérico.',
        ],
        'status' => [
            'required' => 'O estado é obrigatório.',
            'in_list'  => 'Estado inválido. Valores possíveis: pending, processing, shipped, delivered, returned, canceled.',
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
