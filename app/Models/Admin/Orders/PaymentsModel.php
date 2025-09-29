<?php

namespace App\Models\Admin\Orders;

use CodeIgniter\Model;

class PaymentsModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'invoice_id',
        'amount',
        'method',
        'paid_at',
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
        'invoice_id' => 'required|integer',
        'amount'     => 'required|decimal',
        'method'     => 'required|max_length[50]',
        'paid_at'    => 'permit_empty|valid_date',
    ];
    protected $validationMessages = [
        'invoice_id' => [
            'required' => 'A fatura associada é obrigatória.',
            'integer'  => 'O ID da fatura deve ser um número inteiro.',
        ],
        'amount' => [
            'required' => 'O valor do pagamento é obrigatório.',
            'decimal'  => 'O valor deve ser numérico.',
        ],
        'method' => [
            'required'   => 'O método de pagamento é obrigatório.',
            'max_length' => 'O método não pode ter mais de 50 caracteres.',
        ],
        'paid_at' => [
            'valid_date' => 'A data de pagamento deve ser válida.',
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
