<?php

namespace App\Models\Admin\Configurations\Integrations;

use CodeIgniter\Model;

class IntegrationModel extends Model
{
    protected $table            = 'conf_integrations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'type',
        'config_json',
        'status',
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
        'name' => 'required|min_length[3]|max_length[150]',
        'type' => 'required|in_list[ERP,Marketplace,Logistics,Payment,Other]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome é demasiado curto.',
        ],
        'type' => [
            'required' => 'O tipo é obrigatório.',
            'in_list' => 'Tipo inválido.',
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
