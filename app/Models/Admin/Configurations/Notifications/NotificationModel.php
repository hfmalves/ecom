<?php

namespace App\Models\Admin\Configurations\Notifications;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table            = 'conf_notifications';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields = [
        'channel',
        'provider',
        'config_json',
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
        'channel' => 'required|in_list[Email,SMS,Push]',
        'provider' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'channel' => [
            'required' => 'O canal é obrigatório.',
            'in_list' => 'Canal inválido.',
        ],
        'provider' => [
            'required' => 'O provider é obrigatório.',
            'min_length' => 'O provider é demasiado curto.',
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
