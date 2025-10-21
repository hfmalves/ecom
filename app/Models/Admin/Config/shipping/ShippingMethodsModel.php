<?php

namespace App\Models\Admin\Config\shipping;

use CodeIgniter\Model;

class ShippingMethodsModel extends Model
{
    protected $table            = 'conf_shipping';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'name',
        'description',
        'is_active',
        'created_at',
        'updated_at',
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
        'code'        => 'required|min_length[2]|max_length[50]|is_unique[shipping_methods.code,id,{id}]',
        'name'        => 'required|min_length[3]|max_length[150]',
        'description' => 'permit_empty|string',
        'is_active'   => 'required|in_list[0,1]',
    ];
    protected $validationMessages = [
        'code' => [
            'required'   => 'O código do método de envio é obrigatório.',
            'min_length' => 'O código deve ter pelo menos 2 caracteres.',
            'max_length' => 'O código não pode ter mais de 50 caracteres.',
            'is_unique'  => 'Este código já está em uso.',
        ],
        'name' => [
            'required'   => 'O nome do método de envio é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
        ],
        'is_active' => [
            'required' => 'O campo ativo/inativo é obrigatório.',
            'in_list'  => 'Valor inválido para ativo/inativo.',
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
