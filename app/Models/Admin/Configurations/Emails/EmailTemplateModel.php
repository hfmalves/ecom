<?php

namespace App\Models\Admin\Configurations\Emails;

use CodeIgniter\Model;

class EmailTemplateModel extends Model
{
    protected $table            = 'conf_emails';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code', 'subject', 'body_html', 'status', 'created_at', 'updated_at'
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
        'code'    => 'required|min_length[2]|max_length[50]|is_unique[conf_emails.code,id,{id}]',
        'subject' => 'required|min_length[2]|max_length[255]',
        'body_html' => 'required',
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'O código do template é obrigatório.',
            'is_unique' => 'Já existe um template com este código.',
        ],
        'subject' => [
            'required' => 'O assunto é obrigatório.',
        ],
        'body_html' => [
            'required' => 'O corpo do email é obrigatório.',
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
