<?php

namespace App\Models\Admin\Configurations\Languages;

use CodeIgniter\Model;

class LanguageModel extends Model
{
    protected $table            = 'conf_languages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'code', 'name', 'is_default', 'status', 'created_at', 'updated_at'
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
        'code' => 'required|alpha|min_length[2]|max_length[5]',
        'name' => 'required|min_length[2]|max_length[100]',
        'is_default' => 'required|in_list[0,1]',
        'status' => 'required|in_list[0,1]'
    ];

    protected $validationMessages = [
        'code' => ['required' => 'O código do idioma é obrigatório.'],
        'name' => ['required' => 'O nome do idioma é obrigatório.'],
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
