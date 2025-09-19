<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class ProductsAttributes extends Model
{
    protected $table            = 'attributes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'name',
        'type',
        'is_required',
        'is_filterable',
        'sort_order',
        'default_value',
        'validation',
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
        'code'         => 'required|min_length[2]|max_length[100]|is_unique[attributes.code,id,{id}]',
        'name'         => 'required|min_length[2]|max_length[150]|is_unique[attributes.name,id,{id}]',
        'type'         => 'required|in_list[text,select,multiselect,boolean,number]',
        'is_required'  => 'required|in_list[0,1]',
        'is_filterable'=> 'required|in_list[0,1]',
        'sort_order'   => 'permit_empty|integer',
        'default_value'=> 'permit_empty|max_length[255]',
        'validation'   => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'code' => [
            'required'   => 'O código é obrigatório.',
            'min_length' => 'O código deve ter pelo menos 2 caracteres.',
            'max_length' => 'O código não pode ter mais de 100 caracteres.',
            'is_unique'  => 'Já existe um atributo com este código.',
        ],
        'name' => [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe um atributo com este nome.',
        ],
        'type' => [
            'required' => 'O tipo é obrigatório.',
            'in_list'  => 'O tipo deve ser: text, select, multiselect, boolean ou number.',
        ],
        'is_required' => [
            'required' => 'O campo "Obrigatório" deve ser definido.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
        ],
        'is_filterable' => [
            'required' => 'O campo "Filtrável" deve ser definido.',
            'in_list'  => 'O valor deve ser 0 (não) ou 1 (sim).',
        ],
        'sort_order' => [
            'integer' => 'A ordem deve ser um número inteiro.',
        ],
        'default_value' => [
            'max_length' => 'O valor por defeito não pode ter mais de 255 caracteres.',
        ],
        'validation' => [
            'max_length' => 'A validação não pode ter mais de 255 caracteres.',
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
