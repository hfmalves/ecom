<?php

namespace App\Models\Admin\Configurations\Seo;

use CodeIgniter\Model;

class SeoSettingModel extends Model
{
    protected $table            = 'conf_seo';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'meta_title', 'meta_description', 'sitemap_enabled', 'robots_txt', 'created_at', 'updated_at'
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
        'meta_title'       => 'required|min_length[2]|max_length[255]',
        'meta_description' => 'required|min_length[2]',
        'sitemap_enabled'  => 'required|in_list[0,1]',
        'robots_txt'       => 'required',
    ];

    protected $validationMessages = [
        'meta_title' => [
            'required' => 'O título meta é obrigatório.',
        ],
        'meta_description' => [
            'required' => 'A descrição meta é obrigatória.',
        ],
        'sitemap_enabled' => [
            'required' => 'Defina se o sitemap está ativo.',
        ],
        'robots_txt' => [
            'required' => 'O arquivo robots.txt é obrigatório.',
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
