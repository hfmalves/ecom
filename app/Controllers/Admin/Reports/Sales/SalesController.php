<?php
namespace App\Controllers\Admin\Reports\Sales;

use App\Controllers\BaseController;

class SalesController extends BaseController
{
    public function index()
    {
        return view('admin/reports/sales/index');
    }
}
