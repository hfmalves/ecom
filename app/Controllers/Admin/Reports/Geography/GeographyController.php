<?php

namespace App\Controllers\Admin\Reports\Geography;

use App\Controllers\BaseController;

class GeographyController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Geography/index');
    }
}
