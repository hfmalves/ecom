<?php

namespace App\Controllers\Admin\Reports\Payments;

use App\Controllers\BaseController;

class PaymentsController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Payments/index');
    }
}
