<?php

namespace App\Controllers\Admin\Configurations\Shipping;

use App\Controllers\BaseController;

class ShippingController extends BaseController
{
    public function index()
    {
        return view('admin/configurations/shipping/index');
    }
}
