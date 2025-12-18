<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class OrdersController extends BaseController
{
    public function index()
    {
        return view('website/user/account/orders/index');
    }

    public function show(int $id)
    {
        return view('website/user/account/orders/show', [
            'orderId' => $id
        ]);
    }
}
