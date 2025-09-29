<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class InvoicesController extends BaseController
{
    public function index()
    {
        $data = [

        ];
        return view('admin/sales/payments/index', $data);
    }
}
