<?php

namespace App\Controllers\Admin\Configurations\Taxes;

use App\Controllers\BaseController;

class TaxesController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/taxes/index');
    }
}
