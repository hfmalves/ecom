<?php

namespace App\Models\Admin\Configurations\Countries;

use CodeIgniter\Model;

class CountriesModel extends Model
{
    protected $table            = 'conf_countries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields = ['code', 'iso3', 'name', 'currency', 'phone_code', 'is_active', 'created_at', 'updated_at'];


    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = TRUE;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // Validation
    protected $validationRules = [
        'code'       => 'required|alpha|min_length[2]|max_length[2]',
        'iso3'       => 'permit_empty|alpha|min_length[3]|max_length[3]',
        'name'       => 'required|string|min_length[2]|max_length[100]',
        'currency'   => 'permit_empty|alpha_numeric_punct|max_length[10]',
        'phone_code' => 'permit_empty|string|max_length[10]',
        'is_active'  => 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'code' => [
            'required'    => 'O código ISO2 é obrigatório.',
            'alpha'       => 'O código deve conter apenas letras.',
            'min_length'  => 'O código ISO2 deve ter 2 caracteres.',
            'max_length'  => 'O código ISO2 deve ter 2 caracteres.',
        ],
        'name' => [
            'required'    => 'O nome do país é obrigatório.',
            'min_length'  => 'O nome deve ter pelo menos 2 caracteres.',
            'max_length'  => 'O nome não pode exceder 100 caracteres.',
        ],
        'is_active' => [
            'in_list'     => 'O estado deve ser 0 (inativo) ou 1 (ativo).',
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
