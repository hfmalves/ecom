<?php

namespace App\Controllers\Admin\Auth;

use App\Controllers\BaseController;
use App\Models\Admin\Users;
use App\Models\Admin\UserTokens;
use CodeIgniter\HTTP\ResponseInterface;

class ForgotPasswordController extends BaseController
{
    protected $users;
    protected $userTokens;

    public function __construct()
    {
        $this->users = new Users();
        $this->usersTokens = new UserTokens();
    }
    public function index()
    {
        return view('admin/auth/recovery');
    }

    public function sendRecovery()
    {
        $data = $this->request->getJSON(true);
        $email   = $data['email'] ?? null;
        $recoveryRules = [
            'email' => 'required|valid_email',
        ];
        $recoveryMessages = [
            'email' => [
                'required'    => 'O email é obrigatório.',
                'valid_email' => 'O email não é válido.',
            ],
        ];
        if (! $this->validate($recoveryRules, $recoveryMessages)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->validator->getErrors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $user = $this->users->where('email', $email)->first();
        if (! $user) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Email não encontrado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->usersTokens
            ->where('user_id', $user['id'])
            ->where('type', 'password_reset')
            ->delete();
        $token = bin2hex(random_bytes(16));
        $this->usersTokens->insert([
            'user_id'    => $user['id'],
            'token'      => $token,
            'type'       => 'password_reset',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+1 minutes')),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        $data = [
            'user'        => ['name' => $user['name']],
            'recoveryUrl' => base_url("auth/reset/$token"),
        ];
        sendEmail(
            $email,
            'Recuperação de Conta',
            'emails/admin/auth/account_recovery',
            $data
        );
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Enviámos um link de recuperação para o seu email.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function reset($token = null)
    {
        // renderiza view com formulário
        return view('admin/auth/reset_password', [
            'token' => $token,
            'csrf'  => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function attemptReset()
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
        $token = $this->request->getVar('token');
        // procurar token válido
        $row = $this->usersTokens
            ->where('token', $token)
            ->where('type', 'password_reset')
            ->first();
        if (! $row || strtotime($row['expires_at']) < time()) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Token inválido ou expirado.',
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $this->users->update($row['user_id'], [
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
        ]);
        $this->usersTokens
            ->where('user_id', $row['user_id'])
            ->where('type', 'password_reset')
            ->delete();

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Password alterada com sucesso. Pode fazer login.',
            'redirect' => base_url('auth/login'),
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

}
