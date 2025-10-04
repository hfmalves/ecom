<?php

namespace App\Controllers\Admin\Configurations\General;

use App\Controllers\BaseController;

class GeneralController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/general/index');
    }
}
