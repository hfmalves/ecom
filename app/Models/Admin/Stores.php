<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Stores extends Model
{
    protected $table            = 'stores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'code',
        'address',
        'city',
        'country',
        'postal_code',
        'latitude',
        'longitude',
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
        'name'       => 'required|min_length[2]|max_length[150]|is_unique[locations.name,id,{id}]',
        'code'       => 'required|min_length[2]|max_length[50]|is_unique[locations.code,id,{id}]',
        'address'    => 'required|min_length[5]|max_length[255]',
        'city'       => 'required|min_length[2]|max_length[100]',
        'country'    => 'required|min_length[2]|max_length[100]',
        'postal_code'=> 'required|min_length[2]|max_length[20]',
        'latitude'   => 'permit_empty|decimal',
        'longitude'  => 'permit_empty|decimal',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'O nome é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length' => 'O nome não pode ter mais de 150 caracteres.',
            'is_unique'  => 'Já existe um registo com este nome.',
        ],
        'code' => [
            'required'   => 'O código é obrigatório.',
            'min_length' => 'O código deve ter pelo menos 2 caracteres.',
            'max_length' => 'O código não pode ter mais de 50 caracteres.',
            'is_unique'  => 'Já existe um registo com este código.',
        ],
        'address' => [
            'required'   => 'O endereço é obrigatório.',
            'min_length' => 'O endereço deve ter pelo menos 5 caracteres.',
            'max_length' => 'O endereço não pode ter mais de 255 caracteres.',
        ],
        'city' => [
            'required'   => 'A cidade é obrigatória.',
            'min_length' => 'A cidade deve ter pelo menos 2 caracteres.',
            'max_length' => 'A cidade não pode ter mais de 100 caracteres.',
        ],
        'country' => [
            'required'   => 'O país é obrigatório.',
            'min_length' => 'O país deve ter pelo menos 2 caracteres.',
            'max_length' => 'O país não pode ter mais de 100 caracteres.',
        ],
        'postal_code' => [
            'required'   => 'O código postal é obrigatório.',
            'min_length' => 'O código postal deve ter pelo menos 2 caracteres.',
            'max_length' => 'O código postal não pode ter mais de 20 caracteres.',
        ],
        'latitude' => [
            'decimal' => 'A latitude deve estar em formato decimal válido.',
        ],
        'longitude' => [
            'decimal' => 'A longitude deve estar em formato decimal válido.',
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
