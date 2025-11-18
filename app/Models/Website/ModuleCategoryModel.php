<?php

namespace App\Models\Website;

use CodeIgniter\Model;

class ModuleCategoryModel extends Model
{
    protected $table            = 'website_module_categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'title',
        'subtitle',
        'category_ids',
        'orders',
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
        'title' => 'required|min_length[2]|max_length[255]',
        'subtitle' => 'permit_empty|max_length[255]',
        'category_ids' => 'permit_empty',
        'orders' => 'required|integer',
        'status' => 'required|integer',
    ];

    protected $validationMessages = [
        'title' => [
            'required' => 'O título é obrigatório.',
            'min_length' => 'O título deve ter pelo menos 2 caracteres.',
            'max_length' => 'O título não pode exceder 255 caracteres.',
        ],
        'subtitle' => [
            'max_length' => 'O subtítulo não pode exceder 255 caracteres.',
        ],
        'orders' => [
            'required' => 'A ordem é obrigatória.',
            'integer' => 'A ordem deve ser um número inteiro.',
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
