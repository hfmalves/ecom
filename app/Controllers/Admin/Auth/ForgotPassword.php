<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ForgotPassword extends BaseController
{
    public function index()
    {
        return view('auth/forgot_password');
    }

    public function sendRecovery()
    {
        // envia email de recuperação
    }

    public function reset($token = null)
    {
        return view('auth/reset_password', ['token' => $token]);
    }

    public function attemptReset()
    {
        // confirma nova password
    }
}
