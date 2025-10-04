<?php

namespace App\Controllers\Admin\Configurations\System;

use App\Controllers\BaseController;

class SystemController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/system/index');
    }
}
