<?php

namespace App\Models\Admin\Sales;

use CodeIgniter\Model;

class FinancialDocumentsModel extends Model
{
    protected $table            = 'financial_documents';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'order_id',
        'customer_id',
        'billing_address_id',
        'shipping_address_id',
        'shipping_method_id',
        'payment_method_id',
        'invoice_number',
        'series',
        'type',
        'status',
        'payment_status',
        'paid_at',
        'due_date',
        'total',
        'subtotal',
        'tax_total',
        'discount_total',
        'currency',
        'notes',
        'pdf_path',
        'is_fiscal',
        'external_id',
        'external_provider',
        'document_hash',
        'hash',
        'created_by',
        'approved_by',
        'approved_at',
        'canceled_by',
        'canceled_at',
        'updated_by',
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
        'order_id'           => 'required|integer',
        'customer_id'        => 'permit_empty|integer',
        'billing_address_id' => 'permit_empty|integer',
        'shipping_address_id'=> 'permit_empty|integer',
        'shipping_method_id' => 'permit_empty|integer',
        'payment_method_id'  => 'permit_empty|integer',

        'invoice_number' => 'required|string|max_length[50]',
        'series'         => 'required|string|max_length[20]',
        'type'           => 'required|in_list[invoice,receipt,credit_note,debit_note]',
        'status'         => 'required|in_list[pending,paid,canceled]',
        'payment_status' => 'required|in_list[pending,partial,paid,overdue]',

        'subtotal'       => 'required|decimal',
        'tax_total'      => 'permit_empty|decimal',
        'discount_total' => 'permit_empty|decimal',
        'total'          => 'required|decimal',
        'currency'       => 'required|string|max_length[10]',

        'notes'    => 'permit_empty|string',
        'pdf_path' => 'permit_empty|string|max_length[255]',
        'hash'     => 'permit_empty|string|max_length[255]',

        'is_fiscal'         => 'permit_empty|in_list[0,1]',
        'external_id'       => 'permit_empty|string|max_length[100]',
        'external_provider' => 'permit_empty|string|max_length[50]',
        'document_hash'     => 'permit_empty|string|max_length[64]',

        'approved_by' => 'permit_empty|integer',
        'approved_at' => 'permit_empty|valid_date',
        'canceled_by' => 'permit_empty|integer',
        'canceled_at' => 'permit_empty|valid_date',

        'created_by' => 'permit_empty|integer',
        'updated_by' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'É obrigatório associar uma encomenda ao documento.',
        ],
        'invoice_number' => [
            'required'   => 'O número do documento é obrigatório.',
            'max_length' => 'O número do documento não pode ultrapassar 50 caracteres.',
        ],
        'series' => [
            'required' => 'A série é obrigatória.',
        ],
        'total' => [
            'required' => 'O valor total é obrigatório.',
            'decimal'  => 'O total deve ser numérico com casas decimais.',
        ],
        'is_fiscal' => [
            'in_list' => 'O campo "is_fiscal" deve ser 0 (interno) ou 1 (fiscal).',
        ],
        'type' => [
            'in_list' => 'O tipo de documento deve ser invoice, receipt, credit_note ou debit_note.',
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
