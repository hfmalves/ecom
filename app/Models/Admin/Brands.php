<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Brands  extends Model
{
    protected $table            = 'brands';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'slug',
        'description',
        'logo',
        'is_active',
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
        'name'        => 'required|min_length[2]|max_length[150]|is_unique[brands.name,id,{id}]',
        'slug'        => 'required|min_length[2]|max_length[150]|is_unique[brands.slug,id,{id}]',
        'description' => 'permit_empty|string',
        'logo'        => 'permit_empty|max_length[255]',
        'is_active'   => 'required|in_list[0,1]',
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
        'description' => [
            'string' => 'A descrição deve ser um texto válido.',
        ],
        'logo' => [
            'max_length' => 'O caminho do logo não pode ter mais de 255 caracteres.',
        ],
        'is_active' => [
            'required' => 'O campo "Ativo" é obrigatório.',
            'in_list'  => 'O campo "Ativo" deve ser 0 (não) ou 1 (sim).',
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
