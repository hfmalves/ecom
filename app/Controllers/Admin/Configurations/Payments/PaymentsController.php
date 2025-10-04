<?php

namespace App\Controllers\Admin\Configurations\Payments;

use App\Controllers\BaseController;

class PaymentsController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/payments/index');
    }
}
