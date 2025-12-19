<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AccountController extends BaseController
{
    public function dashboard()
    {
        return view('website/user/account/dashboard');
    }

    public function edit()
    {
        return view('website/user/account/edit');
    }

    public function address()
    {
        return view('website/user/account/address');
    }

    public function wishlist()
    {
        return view('website/user/account/wishlist');
    }
}
