<?php

namespace App\Controllers\Admin\Configurations\Currencies;

use App\Controllers\BaseController;

class CurrenciesController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/currencies/index');
    }
}
