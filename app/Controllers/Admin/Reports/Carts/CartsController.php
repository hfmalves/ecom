<?php

namespace App\Controllers\Admin\Reports\Carts;

use App\Controllers\BaseController;

class CartsController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Carts/index');
    }
}
