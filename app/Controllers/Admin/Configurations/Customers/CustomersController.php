<?php

namespace App\Controllers\Admin\Configurations\Customers;

use App\Controllers\BaseController;

class CustomersController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/customers/index');
    }
}
