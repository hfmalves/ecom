<?php

namespace App\Models\Admin\Orders;

use CodeIgniter\Model;

class OrdersReturnItemsModel extends Model
{
    protected $table            = 'ordersreturnitems';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['rma_request_id','order_item_id','qty_returned','status','created_at','updated_at'];

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
        'order_item_id'  => 'required|integer',
        'qty_returned'   => 'required|integer',
        'status'         => 'required|in_list[pending,approved,rejected,received,resolved]',
    ];

    protected $validationMessages = [
        'qty_returned' => ['required' => 'A quantidade devolvida é obrigatória.'],
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
