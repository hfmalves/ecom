<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;

class DesignController extends BaseController
{
    public function index()
    {
        return view('admin/website/design/index');
    }
}
