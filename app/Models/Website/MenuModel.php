<?php

namespace App\Models\Website;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table            = 'website_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'parent_id',
        'title',
        'url',
        'type',
        'image',
        'sort_order',
        'is_active',
        'block_type',
        'block_data',
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

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[2]|max_length[200]',
        'url'   => 'permit_empty|max_length[255]',
        'type'  => 'required|in_list[0,1]',
        'block_type' => 'permit_empty|in_list[0,2,3]',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'O título é obrigatório.'
        ]
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
