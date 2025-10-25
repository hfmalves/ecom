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
    protected $allowedFields = [
        'order_id',
        'tracking_number',
        'tracking_url',
        'shipping_label_url',
        'carrier',
        'status',
        'shipped_at',
        'delivered_at',
        'returned_at',
        'weight',
        'volume',
        'shipping_method_id',
        'comments',
        'created_at',
        'updated_at',
        'deleted_at',
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
        'order_id'           => 'required|integer',
        'tracking_number'    => 'permit_empty|max_length[100]',
        'tracking_url'       => 'permit_empty|valid_url_strict|max_length[255]',
        'shipping_label_url' => 'permit_empty|valid_url_strict|max_length[255]',
        'carrier'            => 'permit_empty|max_length[100]',
        'status'             => 'required|in_list[pending,processing,shipped,delivered,returned,canceled]',
        'shipped_at'         => 'permit_empty|valid_date',
        'delivered_at'       => 'permit_empty|valid_date',
        'returned_at'        => 'permit_empty|valid_date',
        'weight'             => 'permit_empty|decimal',
        'volume'             => 'permit_empty|decimal',
        'shipping_method_id' => 'permit_empty|integer',
        'comments'           => 'permit_empty|string',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'A encomenda é obrigatória.',
            'integer'  => 'O ID da encomenda deve ser numérico.',
        ],
        'status' => [
            'required' => 'O estado do envio é obrigatório.',
            'in_list'  => 'Estado inválido. Use: pending, processing, shipped, delivered, returned ou canceled.',
        ],
        'tracking_url' => [
            'valid_url_strict' => 'O URL de tracking não é válido.',
        ],
        'shipping_label_url' => [
            'valid_url_strict' => 'O URL da etiqueta de envio não é válido.',
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
