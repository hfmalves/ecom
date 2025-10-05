<?php

namespace App\Models\Admin\Configurations\Currencies;

use CodeIgniter\Model;

class CurrencyModel extends Model
{
    protected $table            = 'conf_currencies';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code',
        'symbol',
        'exchange_rate',
        'is_default',
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
    protected $validationRules = [
        'code' => 'required|min_length[2]|max_length[10]',
        'symbol' => 'required|max_length[10]',
        'exchange_rate' => 'required|decimal',
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'O código é obrigatório.',
        ],
        'symbol' => [
            'required' => 'O símbolo é obrigatório.',
        ],
        'exchange_rate' => [
            'required' => 'A taxa de câmbio é obrigatória.',
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
