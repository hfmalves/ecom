<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Users;
use App\Models\Admin\UserTokens;
class Auth extends BaseController
{
    protected $users;
    protected $userTokens;

    public function __construct()
    {
        $this->users = new Users();
        $this->usersTokens = new UserTokens();
    }
    public function login()
    {
        return view('auth/login');
    }

    public function attemptLogin()
    {
        $data = $this->request->getJSON(true);

        // Regras específicas de LOGIN (não usar as do model)
        $loginRules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];

        $loginMessages = [
            'email' => [
                'required'    => 'O email é obrigatório.',
                'valid_email' => 'O email não é válido.',
            ],
            'password' => [
                'required' => 'A password é obrigatória.',
            ],
        ];

        if (! $this->validateData($data, $loginRules, $loginMessages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
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
        log_message('error', 'Valor de login_2step: ' . $user['login_2step']);
        if (!empty($user['login_2step']) && $user['login_2step'] == 1) {
            log_message('error', 'Valor de login_2step entrou: ' . $user['login_2step']);
            $code = random_int(1000, 9999);

            $ok = $this->usersTokens->insert([
                'user_id'    => $user['id'],
                'token'      => $code,
                'type'       => '2fa',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+1 minutes')),
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            if (! $ok) {
                log_message('error', 'Erro no insert: ' . json_encode($this->usersTokens->errors()));
            } else {
                log_message('debug', 'Query do insert: ' . $this->usersTokens->getLastQuery());
            }
            sendEmail(
                $user['email'],
                'O seu código de login',
                'emails/admin/auth/account_2fa_code',
                [
                    'user' => $user,
                    'code' => $code,
                ]
            );
            return $this->response->setJSON([
                'status'   => '2fa_required',
                'message'  => 'Foi enviado um código de validação para o seu email.',
                'csrf'     => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
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

    public function verify2FA()
    {
        $data = $this->request->getJSON(true);
        $email = $data['email'] ?? null;
        $code  = $data['code'] ?? null;
        $user = $this->users->where('email', $email)->first();
        if (!$user) {
            return $this->response->setJSON([
                'status' => 'error',
                'message'=> 'Utilizador não encontrado.',
            ]);
        }
        $token = $this->usersTokens
            ->where('user_id', $user['id'])
            ->where('type', '2fa')
            ->where('token', $code)
            ->where('expires_at >=', date('Y-m-d H:i:s'))
            ->orderBy('id', 'DESC')
            ->first();
        if (!$token) {
            return $this->response->setJSON([
                'status' => 'error',
                'message'=> 'Código inválido ou expirado.',
            ]);
        }
        $this->usersTokens->delete($token['id']);
        $this->session->set('user', [
            'id'         => $user['id'],
            'name'       => $user['name'],
            'email'      => $user['email'],
            'phone'      => $user['phone'],
            'is_active'  => $user['is_active'],
            'is_verified'=> $user['is_verified'],
            'login_2step'=> $user['login_2step'],
        ]);
        return $this->response->setJSON([
            'status'   => 'success',
            'message'  => 'Login concluído!',
            'redirect' => site_url('/dashboard'),
        ]);
    }

    public function logout()
    {
        // destrói sessão e redireciona
    }
}
