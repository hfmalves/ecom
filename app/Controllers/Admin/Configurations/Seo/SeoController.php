<?php

namespace App\Controllers\Admin\Configurations\Seo;

use App\Controllers\BaseController;

class SeoController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/seo/index');
    }
}
