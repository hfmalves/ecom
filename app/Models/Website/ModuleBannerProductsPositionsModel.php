<?php

namespace App\Models\Website;

use CodeIgniter\Model;

class ModuleBannerProductsPositionsModel extends Model
{
    protected $table            = 'website_module_banner_products_positions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'title',
        'subtitle',
        'banner_image',
        'position',
        'product_ids',
        'pins',
        'sort_order'
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
        'title'        => 'required|min_length[2]|max_length[255]',
        'subtitle'     => 'permit_empty|max_length[255]',
        'banner_image' => 'permit_empty|max_length[255]',
        'position'     => 'required|in_list[left,right]',
        'product_ids'  => 'permit_empty',
        'pins'         => 'permit_empty',
        'sort_order'   => 'required|integer',
    ];

    protected $validationMessages = [
        'title' => [
            'required'   => 'O título é obrigatório.',
            'min_length' => 'O título deve ter pelo menos 2 caracteres.',
            'max_length' => 'O título não pode exceder 255 caracteres.',
        ],
        'subtitle' => [
            'max_length' => 'O subtítulo não pode exceder 255 caracteres.',
        ],
        'banner_image' => [
            'max_length' => 'O nome da imagem não pode exceder 255 caracteres.',
        ],
        'position' => [
            'required' => 'A posição é obrigatória.',
            'in_list'  => 'A posição deve ser "left" ou "right".',
        ],
        'sort_order' => [
            'required' => 'O campo de ordenação é obrigatório.',
            'integer'  => 'A ordenação deve ser um número inteiro.',
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
