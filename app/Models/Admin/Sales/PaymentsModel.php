<?php

namespace App\Models\Admin\Sales;

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
        'order_id',
        'amount',
        'currency',
        'exchange_rate',
        'method',
        'payment_method_id',
        'status',
        'transaction_id',
        'reference',
        'notes',
        'paid_at',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true; // agora sim aproveitas created_at e updated_at
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'invoice_id'        => 'required|integer',
        'order_id'          => 'permit_empty|integer',
        'amount'            => 'required|decimal',
        'currency'          => 'required|max_length[10]',
        'exchange_rate'     => 'permit_empty|decimal',
        'method'            => 'required|max_length[50]',
        'payment_method_id' => 'permit_empty|integer',
        'status'            => 'in_list[pending,paid,failed,refunded,partial]',
        'transaction_id'    => 'permit_empty|max_length[100]',
        'reference'         => 'permit_empty|max_length[100]',
        'notes'             => 'permit_empty|string',
        'paid_at'           => 'permit_empty|valid_date',
        'created_by'        => 'permit_empty|integer',
        'updated_by'        => 'permit_empty|integer',
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
        'currency' => [
            'required'   => 'A moeda é obrigatória.',
            'max_length' => 'A moeda não pode ter mais de 10 caracteres.',
        ],
        'method' => [
            'required'   => 'O método de pagamento é obrigatório.',
            'max_length' => 'O método não pode ter mais de 50 caracteres.',
        ],
        'status' => [
            'in_list' => 'Estado inválido. Deve ser pending, paid, failed, refunded ou partial.',
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
