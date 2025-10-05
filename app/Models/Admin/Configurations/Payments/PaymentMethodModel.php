<?php

namespace App\Models\Admin\Configurations\Payments;

use CodeIgniter\Model;

class PaymentMethodModel extends Model
{
    protected $table            = 'conf_payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'parent_id',
        'provider',
        'code',
        'name',
        'description',
        'config_json',
        'is_active',
        'is_default',
        'sort_order',
        'created_at',
        'updated_at'
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
        'code' => 'required|min_length[2]|max_length[100]',
        'name' => 'required|min_length[2]|max_length[150]',
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'O código é obrigatório.',
            'min_length' => 'O código é demasiado curto.',
        ],
        'name' => [
            'required' => 'O nome é obrigatório.',
            'min_length' => 'O nome é demasiado curto.',
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
