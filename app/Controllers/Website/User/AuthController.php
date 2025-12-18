<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    public function login()
    {
        return view('website/user/auth/login');
    }

    public function register()
    {
        return view('website/user/auth/register');
    }

    public function recovery()
    {
        return view('website/user/auth/recovery');
    }

    public function logout()
    {
        // session()->destroy();
        return redirect()->to('/');
    }
}
