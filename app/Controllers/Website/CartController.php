<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class CartController extends BaseController
{
    public function cart()
    {
        return view('website/cart/cart');
    }

    public function checkout()
    {
        return view('website/cart/checkout');
    }

    public function complete()
    {
        return view('website/cart/complete');
    }

}
