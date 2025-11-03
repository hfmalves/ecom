<?php

namespace App\Models\Admin\Marketing;

use CodeIgniter\Model;

class CampaignBrandModel extends Model
{
    protected $table            = 'campaigns_brands';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'campaign_id',
        'brand_id',
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
        'brand_id'    => 'required|integer'
    ];

    protected $validationMessages = [
        'campaign_id' => [
            'required' => 'O ID da campanha é obrigatório.',
            'integer'  => 'O ID da campanha deve ser numérico.',
        ],
        'brand_id' => [
            'required' => 'A marca é obrigatória.',
            'integer'  => 'O ID da marca deve ser numérico.',
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
