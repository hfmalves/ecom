<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProductsImages extends Model
{
    protected $table            = 'images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'owner_type',
        'owner_id',
        'path',
        'position',
        'alt_text',
        'created_at',
        'updated_at',
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
        'owner_type' => 'required|in_list[product,variant]',
        'owner_id'   => 'required|integer',
        'path'       => 'required|max_length[255]',
        'position'   => 'permit_empty|integer',
        'alt_text'   => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'owner_type' => [
            'required' => 'O tipo de dono é obrigatório.',
            'in_list'  => 'O tipo de dono deve ser "product" ou "variant".',
        ],
        'owner_id' => [
            'required' => 'O campo Owner ID é obrigatório.',
            'integer'  => 'O Owner ID deve ser um número inteiro.',
        ],
        'path' => [
            'required'   => 'O caminho da imagem é obrigatório.',
            'max_length' => 'O caminho não pode ter mais de 255 caracteres.',
        ],
        'position' => [
            'integer' => 'A posição deve ser um número inteiro.',
        ],
        'alt_text' => [
            'max_length' => 'O texto alternativo não pode ter mais de 255 caracteres.',
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
