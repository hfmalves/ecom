<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Register extends BaseController
{
    public function index()
    {
        return view('auth/register');
    }

    public function attemptRegister()
    {
        // lógica para criar utilizador
    }
}
