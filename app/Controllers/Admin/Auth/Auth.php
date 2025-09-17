<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Users;

class Auth extends BaseController
{
    protected $users;

    public function __construct()
    {
        $this->users = new Users();
    }
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $data = $this->request->getJSON(true);
        if (! $this->users->validate($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->users->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $email    = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $user = $this->users->where('email', $email)->first();
        if (! $user || ! password_verify($password, $user['password'])) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => ['login' => 'Credenciais inválidas.'],
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        //TODO MAKE 2 STEPS
        $this->session->set('user', [
            'name'       => $user['name'],
            'email'      => $user['email'],
            'phone'      => $user['phone'],
            'is_active'  => $user['is_active'],
            'is_verified'=> $user['is_verified'],
            'login_2step'=> $user['login_2step'],
        ]);
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Login efetuado com sucesso!',
            'redirect' => site_url('/dashboard'),
            'csrf'     => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }



    public function twoStep()
    {
        return view('auth/two_step');
    }

    public function verifyTwoStep()
    {
        // lógica de validação do código 2FA
    }

    public function logout()
    {
        // destrói sessão e redireciona
    }
}
