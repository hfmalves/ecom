<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Suppliers extends Model
{
    protected $table            = 'suppliers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name',
        'contact_person',
        'legal_number',
        'vat',
        'email',
        'phone',
        'website',
        'address',
        'country',
        'password',
        'iban',
        'payment_terms',
        'currency',
        'image',
        'api_key',
        'api_url',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
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
        'name'           => 'required|min_length[3]|max_length[255]',
        'contact_person' => 'permit_empty|max_length[150]',
        'legal_number'   => 'required|max_length[20]',
        'vat'            => 'permit_empty|max_length[50]',
        'email' => 'required|valid_email|max_length[255]|is_unique[suppliers.email]',
        'phone'          => 'permit_empty|max_length[50]',
        'website'        => 'permit_empty|max_length[255]',
        'address'        => 'permit_empty|string',
        'country'        => 'permit_empty|max_length[100]',
        'password'       => 'permit_empty|min_length[6]|max_length[255]',
        'iban'           => 'permit_empty|max_length[255]',
        'payment_terms'  => 'permit_empty|max_length[100]',
        'currency'       => 'permit_empty|max_length[10]',
        'image'          => 'permit_empty|max_length[255]',
        'api_key'        => 'permit_empty|max_length[255]',
        'api_url'        => 'permit_empty|valid_url_strict|max_length[255]',
        'status'         => 'required|in_list[active,inactive]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'O nome do fornecedor é obrigatório.',
            'min_length' => 'O nome deve ter pelo menos 3 caracteres.',
            'max_length' => 'O nome não pode ter mais de 255 caracteres.',
        ],
        'legal_number' => [
            'required'   => 'O nif do fornecedor é obrigatório.',
            'max_length' => 'O nif não pode ter mais de 20 caracteres.',
        ],
        'email' => [
            'required'   => 'O email é obrigatório.',
            'valid_email'=> 'O email fornecido não é válido.',
            'is_unique'  => 'Já existe um fornecedor com este email.',
        ],
        'website' => [
            'valid_url_strict' => 'O website deve ser um URL válido.',
        ],
        'api_url' => [
            'valid_url_strict' => 'A API URL deve ser um URL válido.',
        ],
        'status' => [
            'required' => 'O estado é obrigatório.',
            'in_list'  => 'O estado deve ser "active" ou "inactive".',
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
