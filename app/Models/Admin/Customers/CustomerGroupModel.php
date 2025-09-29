<?php

namespace App\Models\Admin\Customers;

use CodeIgniter\Model;

class CustomerGroupModel extends Model
{
    protected $table            = 'customers_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'description',
        'discount_percent',
        'min_order_value',
        'max_order_value',
        'is_default',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
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
        'id'               => 'permit_empty|is_natural_no_zero',
        'name'             => 'required|min_length[3]|max_length[100]|is_unique[customers_groups.name,id,{id}]',
        'description'      => 'permit_empty|max_length[255]',
        'discount_percent' => 'permit_empty|decimal|greater_than_equal_to[0]|less_than_equal_to[100]',
        'min_order_value'  => 'permit_empty|decimal|greater_than_equal_to[0]',
        'max_order_value'  => 'permit_empty|decimal|greater_than_equal_to[0]',
        'is_default'       => 'required|in_list[0,1]',
        'status'           => 'required|in_list[active,inactive]',
    ];
    protected $validationMessages = [

        'name' => [
            'required'   => 'O nome do grupo é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode ultrapassar 100 caracteres.',
            'is_unique'  => 'Já existe um grupo de cliente com esse nome.',
        ],
        'description' => [
            'max_length' => 'A descrição não pode ultrapassar 255 caracteres.',
        ],
        'discount_percent' => [
            'decimal'               => 'O desconto deve ser um número válido.',
            'greater_than_equal_to' => 'O desconto não pode ser inferior a 0%.',
            'less_than_equal_to'    => 'O desconto não pode ser superior a 100%.',
        ],
        'min_order_value' => [
            'decimal'               => 'O valor mínimo deve ser numérico.',
            'greater_than_equal_to' => 'O valor mínimo não pode ser negativo.',
        ],
        'max_order_value' => [
            'decimal'               => 'O valor máximo deve ser numérico.',
            'greater_than_equal_to' => 'O valor máximo não pode ser negativo.',
        ],
        'is_default' => [
            'required' => 'É obrigatório indicar se o grupo é padrão.',
            'in_list'  => 'O campo padrão só pode ser Sim (1) ou Não (0).',
        ],
        'status' => [
            'required' => 'O status é obrigatório.',
            'in_list'  => 'O status deve ser "active" ou "inactive".',
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
