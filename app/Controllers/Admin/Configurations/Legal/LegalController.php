<?php

namespace App\Controllers\Admin\Configurations\Legal;

use App\Controllers\BaseController;

class LegalController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/legal/index');
    }
}
