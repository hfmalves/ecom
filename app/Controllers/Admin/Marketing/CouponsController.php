<?php

namespace App\Controllers\Admin\Marketing;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CouponsController extends BaseController
{
    public function index()
    {
        $data = [

        ];
        return view('admin/marketing/coupons/index', $data);
    }
}
