<?php

namespace App\Models;

use CodeIgniter\Model;

class InvoicesModel extends Model
{
    protected $table            = 'invoices';
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
        'hash',
        'created_by',
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
        'type'           => 'in_list[invoice,receipt,credit_note,debit_note]',
        'status'         => 'in_list[draft,issued,canceled,refunded]',
        'payment_status' => 'in_list[pending,partial,paid,overdue]',

        'total'          => 'required|decimal',
        'subtotal'       => 'required|decimal',
        'tax_total'      => 'decimal',
        'discount_total' => 'decimal',

        'currency' => 'required|string|max_length[10]',
        'notes'    => 'permit_empty|string',
        'pdf_path' => 'permit_empty|string|max_length[255]',
        'hash'     => 'permit_empty|string|max_length[255]',

        'created_by' => 'permit_empty|integer',
        'updated_by' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'É obrigatório associar uma encomenda à fatura.',
        ],
        'invoice_number' => [
            'required' => 'O número da fatura é obrigatório.',
            'max_length' => 'O número da fatura não pode ultrapassar 50 caracteres.',
        ],
        'series' => [
            'required' => 'A série é obrigatória.',
        ],
        'total' => [
            'required' => 'O valor total da fatura é obrigatório.',
            'decimal'  => 'O total deve ser numérico com casas decimais.',
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
