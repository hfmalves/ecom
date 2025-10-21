<?php

namespace App\Models\Admin\Catalog;

use CodeIgniter\Model;

class BrandsModel  extends Model
{
    protected $table            = 'brands';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = [
        'supplier_id',
        'name',
        'slug',
        'description',
        'logo',
        'website',
        'country',
        'meta_title',
        'meta_description',
        'banner',
        'sort_order',
        'featured',
        'is_active',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
        'deleted_at',
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
        'supplier_id'      => 'permit_empty|is_natural_no_zero|exists[suppliers.id]',
        'name'             => 'required|min_length[2]|max_length[150]|is_unique[brands.name]',
        'slug'             => 'required|min_length[2]|max_length[150]|is_unique[brands.slug]',
        'description'      => 'permit_empty|string',
        'logo'             => 'permit_empty|max_length[255]',
        'website'          => 'permit_empty|valid_url|max_length[255]',
        'country'          => 'permit_empty|max_length[100]',
        'meta_title'       => 'permit_empty|max_length[255]',
        'meta_description' => 'permit_empty|max_length[255]',
        'banner'           => 'permit_empty|max_length[255]',
        'sort_order'       => 'permit_empty|integer',
        'featured'         => 'permit_empty|in_list[0,1]',
        'is_active'        => 'required|in_list[0,1]',
        'created_by'       => 'permit_empty|integer',
        'updated_by'       => 'permit_empty|integer',
    ];
    protected $validationMessages = [
        'name' => [
            'required'   => 'O nome da marca é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe uma marca com este nome.',
        ],
        'slug' => [
            'required'   => 'O slug é obrigatório.',
            'min_length' => 'O slug deve ter pelo menos 2 caracteres.',
            'max_length' => 'O slug não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe uma marca com este slug.',
        ],
        'website' => [
            'valid_url'  => 'O campo Website deve conter um URL válido.',
            'max_length' => 'O Website não pode ter mais de 255 caracteres.',
        ],
        'country' => [
            'max_length' => 'O nome do país não pode ter mais de 100 caracteres.',
        ],
        'is_active' => [
            'required' => 'O campo "Ativo" é obrigatório.',
            'in_list'  => 'O campo "Ativo" deve ser 0 (Inativo) ou 1 (Ativo).',
        ],
        'featured' => [
            'in_list'  => 'O campo "Destaque" deve ser 0 (Não) ou 1 (Sim).',
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
