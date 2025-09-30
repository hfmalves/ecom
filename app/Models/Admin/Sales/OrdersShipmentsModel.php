<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class OrdersShipmentsModel extends Model
{
    protected $table            = 'orders_shipments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['order_id','tracking_number','carrier','shipped_at','created_at'];

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
        'order_id'        => 'required|integer',
        'tracking_number' => 'permit_empty|max_length[100]',
        'carrier'         => 'permit_empty|max_length[100]',
        'shipped_at'      => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'order_id' => ['required' => 'A encomenda é obrigatória.'],
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
