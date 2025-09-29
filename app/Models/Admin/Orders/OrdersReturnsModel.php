<?php

namespace App\Models\Admin\Orders;

use CodeIgniter\Model;

class OrdersReturnsModel extends Model
{
    protected $table            = 'orders_returns';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = ['order_id','customer_id','reason','status','created_at','updated_at'];


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
        'order_id'   => 'required|integer',
        'customer_id'=> 'required|integer',
        'reason'     => 'permit_empty|string',
        'status'     => 'required|in_list[pending,approved,rejected,received,resolved]',
    ];

    protected $validationMessages = [
        'status' => [
            'required' => 'O estado da devolução é obrigatório.',
            'in_list'  => 'Estado inválido.'
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
