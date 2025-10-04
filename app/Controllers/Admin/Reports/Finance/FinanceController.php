<?php

namespace App\Controllers\Admin\Reports\Finance;

use App\Controllers\BaseController;

class FinanceController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Finance/index');
    }
}
