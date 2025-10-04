<?php

namespace App\Controllers\Admin\Reports\Products;

use App\Controllers\BaseController;

class ProductsController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Products/index');
    }
}
