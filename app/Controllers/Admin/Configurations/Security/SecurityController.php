<?php

namespace App\Controllers\Admin\Configurations\Security;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Security\SecurityLogModel;

class SecurityController extends BaseController
{
    protected $logs;

    public function __construct()
    {
        $this->logs = new SecurityLogModel();
    }

    public function index()
    {
        // Lista todos os logs ordenados por data decrescente
        $data['logs'] = $this->logs->orderBy('created_at', 'DESC')->findAll();
        return view('admin/configurations/security/index', $data);
    }
}
