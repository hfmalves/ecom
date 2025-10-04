<?php

namespace App\Controllers\Admin\Configurations\Security;

use App\Controllers\BaseController;

class SecurityController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/security/index');
    }
}
