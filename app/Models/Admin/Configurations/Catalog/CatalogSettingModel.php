<?php

namespace App\Models\Admin\Configurations\Catalog;

use CodeIgniter\Model;

class CatalogSettingModel extends Model
{
    protected $table            = 'conf_catalog_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'name', 'key', 'value', 'type', 'options', 'status', 'created_at', 'updated_at'
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
        'name' => 'required|min_length[2]|max_length[100]',
        'key'  => 'required|min_length[2]|max_length[50]',
        'type' => 'required|in_list[text,number,boolean,select,json]',
    ];

    protected $validationMessages = [
        'name' => ['required' => 'O nome é obrigatório.'],
        'key'  => ['required' => 'A chave interna é obrigatória.'],
        'type' => ['required' => 'O tipo é obrigatório.'],
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
