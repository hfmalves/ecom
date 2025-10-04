<?php

namespace App\Controllers\Admin\Reports\Coupons;

use App\Controllers\BaseController;

class CouponsController extends BaseController
{
    public function index()
    {
        return view('admin/reports/coupons/index');
    }
}
