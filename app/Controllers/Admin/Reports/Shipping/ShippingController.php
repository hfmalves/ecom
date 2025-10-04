<?php

namespace App\Controllers\Admin\Reports\Shipping;

use App\Controllers\BaseController;

class ShippingController extends BaseController
{
    public function index()
    {
        return view('admin/reports/Shipping/index');
    }
}
