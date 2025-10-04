<?php

namespace App\Models\Admin\Configurations\Taxes;

use CodeIgniter\Model;

class TaxModel extends Model
{
    protected $table            = 'conf_taxes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'rate',
        'country_id',
        'is_active',
        'created_at',
        'updated_at'
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
        'name' => [
            'label' => 'Nome do Imposto',
            'rules' => 'required|min_length[2]|max_length[100]'
        ],
        'rate' => [
            'label' => 'Taxa (%)',
            'rules' => 'required|decimal|greater_than_equal_to[0]|less_than_equal_to[100]'
        ],
        'country_id' => [
            'label' => 'País',
            'rules' => 'required|is_natural_no_zero'
        ],
        'is_active' => [
            'label' => 'Ativo',
            'rules' => 'permit_empty|in_list[0,1]'
        ],
    ];

    protected $validationMessages = [
        'name' => [
            'required'    => 'O campo {field} é obrigatório.',
            'min_length'  => 'O {field} deve ter pelo menos 2 caracteres.',
            'max_length'  => 'O {field} não pode ter mais de 100 caracteres.',
        ],
        'rate' => [
            'required'               => 'O campo {field} é obrigatório.',
            'decimal'                => 'O {field} deve ser um número decimal.',
            'greater_than_equal_to'  => 'A {field} não pode ser negativa.',
            'less_than_equal_to'     => 'A {field} não pode ser superior a 100%.',
        ],
        'country_id' => [
            'required'            => 'O campo {field} é obrigatório.',
            'is_natural_no_zero'  => 'O {field} deve conter um ID válido de país.',
        ],
        'is_active' => [
            'in_list' => 'O campo {field} deve ser 0 (inativo) ou 1 (ativo).'
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
