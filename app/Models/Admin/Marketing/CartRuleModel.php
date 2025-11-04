<?php

namespace App\Models\Admin\Marketing;

use CodeIgniter\Model;

class CartRuleModel extends Model
{
    protected $table            = 'cart_rules';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'condition_json',
        'start_date',
        'end_date',
        'priority',
        'status'
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
        'name'           => 'required|min_length[3]|max_length[100]',
        'description'    => 'permit_empty|string|max_length[500]',
        'discount_type'  => 'required|in_list[percent,fixed,free_shipping,buy_x_get_y]',
        'discount_value' => 'required|decimal',
        'condition_json' => 'permit_empty',
        'start_date'     => 'permit_empty|valid_date[Y-m-d]',
        'end_date'       => 'permit_empty|valid_date[Y-m-d]',
        'priority'       => 'permit_empty|integer',
        'status'         => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'    => 'O nome da regra é obrigatório.',
            'min_length'  => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length'  => 'O nome não pode exceder 100 caracteres.',
        ],
        'discount_type' => [
            'required' => 'O tipo de desconto é obrigatório.',
            'in_list'  => 'Tipo de desconto inválido.',
        ],
        'discount_value' => [
            'required' => 'O valor do desconto é obrigatório.',
            'decimal'  => 'O valor do desconto deve ser numérico.',
        ],
        'start_date' => [
            'valid_date' => 'A data de início deve estar num formato válido (YYYY-MM-DD).',
        ],
        'end_date' => [
            'valid_date' => 'A data de fim deve estar num formato válido (YYYY-MM-DD).',
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
