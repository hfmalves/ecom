<?php

namespace App\Models\Admin\Marketing;

use CodeIgniter\Model;

class Coupons extends Model
{
    protected $table            = 'coupons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'type',
        'value',
        'max_discount_value',
        'max_uses',
        'max_uses_per_customer',
        'min_order_value',
        'max_order_value',
        'max_orders',
        'customer_id',
        'customer_group_id',
        'email_limit',
        'scope',
        'stackable',
        'is_active',
        'description',
        'starts_at',
        'expires_at',
        'created_at',
        'updated_at',
        'deleted_at',
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
        'code'               => 'required|min_length[3]|max_length[50]|is_unique[coupons.code,id,{id}]',
        'type'               => 'required|in_list[percent,fixed]',
        'value'              => 'required|decimal',
        'max_discount_value' => 'permit_empty|decimal',
        'max_uses'           => 'permit_empty|integer',
        'max_uses_per_customer' => 'permit_empty|integer',
        'min_order_value'    => 'permit_empty|decimal',
        'max_order_value'    => 'permit_empty|decimal',
        'max_orders'         => 'permit_empty|integer',
        'email_limit'        => 'permit_empty|valid_email',
        'starts_at'          => 'permit_empty|valid_date',
        'expires_at'         => 'permit_empty|valid_date',
    ];
    protected $validationMessages = [
        'code' => [
            'required'   => 'O código do cupão é obrigatório.',
            'min_length' => 'O código deve ter pelo menos 3 caracteres.',
            'max_length' => 'O código não pode ter mais de 50 caracteres.',
            'is_unique'  => 'Este código de cupão já existe.',
        ],
        'type' => [
            'required' => 'O tipo de cupão é obrigatório.',
            'in_list'  => 'O tipo de cupão deve ser "percent" ou "fixed".',
        ],
        'value' => [
            'required' => 'O valor do cupão é obrigatório.',
            'decimal'  => 'O valor do cupão deve ser numérico.',
        ],
        'max_discount_value' => [
            'decimal' => 'O valor máximo de desconto deve ser numérico.',
        ],
        'max_uses' => [
            'integer' => 'O número máximo de utilizações deve ser inteiro.',
        ],
        'max_uses_per_customer' => [
            'integer' => 'O número máximo de utilizações por cliente deve ser inteiro.',
        ],
        'min_order_value' => [
            'decimal' => 'O valor mínimo da encomenda deve ser numérico.',
        ],
        'max_order_value' => [
            'decimal' => 'O valor máximo da encomenda deve ser numérico.',
        ],
        'max_orders' => [
            'integer' => 'O limite de encomendas deve ser inteiro.',
        ],
        'email_limit' => [
            'valid_email' => 'O e-mail associado ao cupão deve ser válido.',
        ],
        'starts_at' => [
            'valid_date' => 'A data de início deve ser uma data válida.',
        ],
        'expires_at' => [
            'valid_date' => 'A data de expiração deve ser uma data válida.',
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
