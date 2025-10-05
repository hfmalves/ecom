<?php

namespace App\Controllers\Admin\Configurations\System;

use App\Controllers\BaseController;
use App\Models\Admin\Configurations\Security\SecurityModel;
class SystemController extends BaseController
{
    public function __construct()
    {
        $this->logs = new SecurityModel();
    }

    public function index()
    {
        $data['logs'] = $this->logs->orderBy('created_at', 'DESC')->findAll();
        return view('admin/configurations/system/index', $data);
    }
}
