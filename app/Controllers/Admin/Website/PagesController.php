<?php

namespace App\Controllers\Admin\Website;

use App\Controllers\BaseController;

class PagesController extends BaseController
{
    public function index()
    {
        return view('admin/website/pages/index');
    }
}
