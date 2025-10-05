<?php

namespace App\Models\Admin\Configurations\General;

use CodeIgniter\Model;

class GeneralModel extends Model
{
    protected $table            = 'conf_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id',
        'site_name',
        'logo',
        'contact_email',
        'contact_phone',
        'timezone',
        'default_currency',
        'status',
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
    // Validações básicas
    protected $validationRules = [
        'site_name'        => 'required|min_length[3]|max_length[100]',
        'contact_email'    => 'permit_empty|valid_email',
        'contact_phone'    => 'permit_empty|max_length[20]',
        'timezone'         => 'required',
        'default_currency' => 'required|max_length[10]',
        'status'           => 'in_list[0,1]',
    ];

    protected $validationMessages = [
        'site_name' => [
            'required' => 'O nome do site é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
        ],
        'contact_email' => [
            'valid_email' => 'O e-mail de contacto deve ser válido.',
        ],
        'status' => [
            'in_list' => 'O estado deve ser 0 (inativo) ou 1 (ativo).',
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
