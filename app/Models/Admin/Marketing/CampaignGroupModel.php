<?php

namespace App\Models\Admin\Marketing;

use CodeIgniter\Model;

class CampaignGroupModel extends Model
{
    protected $table            = 'campaigns_groups';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'campaign_id',
        'group_id',
        'created_at',
        'updated_at',
        'deleted_at'
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
        'campaign_id' => 'required|integer',
        'group_id'    => 'required|integer'
    ];

    protected $validationMessages = [
        'campaign_id' => [
            'required' => 'O ID da campanha é obrigatório.',
            'integer'  => 'O ID da campanha deve ser numérico.',
        ],
        'group_id' => [
            'required' => 'O grupo é obrigatório.',
            'integer'  => 'O ID do grupo deve ser numérico.',
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
