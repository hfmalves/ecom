<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Categories extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'parent_id',
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'position',
        'meta_title',
        'meta_description',
        'meta_keywords',
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
        'parent_id'       => 'permit_empty|integer',
        'name'            => 'required|min_length[2]|max_length[150]',
        'slug' => 'required|min_length[2]|max_length[150]|is_unique[categories.slug]',
        'description'     => 'permit_empty|string',
        'image'           => 'permit_empty|max_length[255]',
        'is_active'       => 'required|in_list[0,1]',
        'position'        => 'permit_empty|integer',
        'meta_title'      => 'permit_empty|max_length[255]',
        'meta_description'=> 'permit_empty|max_length[500]',
        'meta_keywords'   => 'permit_empty|max_length[255]',
    ];
    protected $validationMessages = [

        'name' => [
            'required'   => 'O nome da categoria é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
        ],
        'slug' => [
            'required'   => 'O slug é obrigatório.',
            'min_length' => 'O slug deve ter pelo menos 2 caracteres.',
            'max_length' => 'O slug não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe uma categoria com este slug.',
        ],
        'description' => [
            'string' => 'A descrição deve ser um texto válido.',
        ],
        'image' => [
            'max_length' => 'O caminho da imagem não pode ter mais de 255 caracteres.',
        ],
        'is_active' => [
            'required' => 'O campo "Ativo" é obrigatório.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
        ],
        'position' => [
            'integer' => 'A posição deve ser um número inteiro.',
        ],
        'meta_title' => [
            'max_length' => 'O meta título não pode ter mais de 255 caracteres.',
        ],
        'meta_description' => [
            'max_length' => 'A meta descrição não pode ter mais de 500 caracteres.',
        ],
        'meta_keywords' => [
            'max_length' => 'As meta keywords não podem ter mais de 255 caracteres.',
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
