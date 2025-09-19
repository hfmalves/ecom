<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Coupons extends Model
{
    protected $table            = 'coupons';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'type',
        'value',
        'max_uses',
        'expires_at',
        'created_at',
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
        'code'       => 'required|min_length[3]|max_length[50]|is_unique[coupons.code,id,{id}]',
        'type'       => 'required|in_list[percent,fixed]',
        'value'      => 'required|decimal',
        'max_uses'   => 'permit_empty|integer',
        'expires_at' => 'permit_empty|valid_date',
    ];
    protected $validationMessages = [
        'code' => [
            'required'   => 'O código do cupão é obrigatório.',
            'min_length' => 'O código deve ter pelo menos 3 caracteres.',
            'max_length' => 'O código não pode ter mais de 50 caracteres.',
            'is_unique'  => 'Este código de cupão já existe.',
        ],
        'type' => [
            'required' => 'O tipo de cupão é obrigatório.',
            'in_list'  => 'O tipo de cupão deve ser "percent" ou "fixed".',
        ],
        'value' => [
            'required' => 'O valor do cupão é obrigatório.',
            'decimal'  => 'O valor do cupão deve ser numérico.',
        ],
        'max_uses' => [
            'integer' => 'O número máximo de utilizações deve ser inteiro.',
        ],
        'expires_at' => [
            'valid_date' => 'A data de expiração deve ser uma data válida.',
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
