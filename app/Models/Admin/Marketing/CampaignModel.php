<?php

namespace App\Models\Admin\Marketing;

use CodeIgniter\Model;

class CampaignModel extends Model
{
    protected $table            = 'campaigns';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'description',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'status',
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
        'name'           => 'required|min_length[3]|max_length[255]',
        'discount_type'  => 'required|in_list[percent,fixed]',
        'discount_value' => 'required|decimal',
        'start_date'     => 'required|valid_date',
        'end_date'       => 'required|valid_date',
        'status'         => 'required|in_list[active,inactive]',
    ];
    protected $validationMessages = [
        'name' => [
            'required'    => 'O nome da campanha é obrigatório.',
            'min_length'  => 'O nome deve ter pelo menos 3 caracteres.',
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
            'required'    => 'A data de início é obrigatória.',
            'valid_date'  => 'A data de início é inválida.',
        ],
        'end_date' => [
            'required'    => 'A data de fim é obrigatória.',
            'valid_date'  => 'A data de fim é inválida.',
        ],
        'status' => [
            'required' => 'O estado da campanha é obrigatório.',
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
