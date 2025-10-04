<?php

namespace App\Controllers\Admin\Configurations\Cache;

use App\Controllers\BaseController;

class CacheController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/cache/index');
    }
}
