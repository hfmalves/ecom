<?php

namespace App\Models\Admin\Config\taxes;

use CodeIgniter\Model;

class TaxClassesModel  extends Model
{
    protected $table            = 'tax_classes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'rate',
        'country',
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
        'name'     => 'required|min_length[2]|max_length[150]|is_unique[currencies.name,id,{id}]',
        'rate'     => 'required|decimal',
        'country'  => 'required|exact_length[2]',
        'is_active'=> 'required|in_list[0,1]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'O nome da moeda é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe uma moeda com este nome.',
        ],
        'rate' => [
            'required' => 'A taxa é obrigatória.',
            'decimal'  => 'A taxa deve ser numérica (exemplo: 1.00).',
        ],
        'country' => [
            'required'    => 'O código do país é obrigatório.',
            'exact_length'=> 'O código do país deve ter exatamente 2 caracteres (ISO).',
        ],
        'is_active' => [
            'required' => 'O campo "Ativo" é obrigatório.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
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
