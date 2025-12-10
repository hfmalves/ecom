<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;

class ModulesController extends BaseController
{
    public function index()
    {
        return view('admin/website/modules/index');
    }
}
