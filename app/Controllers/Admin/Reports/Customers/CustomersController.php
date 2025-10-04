<?php

namespace App\Controllers\Admin\Reports\Customers;

use App\Controllers\BaseController;

class CustomersController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Customers/index');
    }
}
