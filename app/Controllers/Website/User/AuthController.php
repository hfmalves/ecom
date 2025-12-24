<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerGroupModel;
use App\Models\Admin\Customers\CustomerTokenModel;
use App\Models\Admin\Customers\CustomerWishlistModel;

class AuthController extends BaseController
{
    protected $CustomerModel;
    protected $CustomerAddressModel;
    protected $CustomerGroupModel;
    protected $CustomerTokenModel;
    protected $CustomerWishlistModel;


    public function __construct()
    {
        $this->CustomerModel = new CustomerModel();
        $this->CustomerAddressModel = new CustomerAddressModel();
        $this->CustomerGroupModel = new CustomerGroupModel();
        $this->CustomerTokenModel = new CustomerTokenModel();
        $this->CustomerWishlistModel = new CustomerWishlistModel();
    }

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
    /* ======================
    * LOGIN
    * ====================== */
    public function makelogin()
    {
        if ($this->request->getMethod() === 'post') {

            $data = $this->request->getPost(['email', 'password']);

            if (! $this->validate([
                'email'    => 'required|valid_email',
                'password' => 'required',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $user = $this->CustomerModel
                ->where('email', $data['email'])
                ->where('deleted_at', null)
                ->first();

            if (
                ! $user ||
                ! password_verify($data['password'], $user['password']) ||
                ! $user['is_active']
            ) {
                return redirect()->back()->with('error', 'Credenciais inválidas.');
            }

            // Atualiza login
            $this->CustomerModel->update($user['id'], [
                'last_login_at' => date('Y-m-d H:i:s'),
                'last_ip'       => $this->request->getIPAddress(),
                'login_attempts'=> 0,
            ]);

            session()->set('user', [
                'id'         => $user['id'],
                'email'      => $user['email'],
                'name'       => $user['name'],
                'isLoggedIn' => true,
            ]);

            return redirect()->to('/user/account');
        }

        return view('website/user/auth/login');
    }

    /* ======================
     * REGISTER
     * ====================== */
    public function makeRegister()
    {
        if ($this->request->getMethod() === 'post') {

            $data = $this->request->getPost([
                'name',
                'email',
                'password',
                'password_confirm',
            ]);

            if (! $this->validate([
                'name'             => 'required|min_length[2]',
                'email'            => 'required|valid_email|is_unique[customers.email]',
                'password'         => 'required|min_length[6]',
                'password_confirm' => 'required|matches[password]',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $this->CustomerModel->insert([
                'name'        => $data['name'],
                'email'       => $data['email'],
                'password'    => password_hash($data['password'], PASSWORD_DEFAULT),
                'is_active'   => 1,
                'is_verified' => 0,
                'source'      => 'website',
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/user/auth/login')
                ->with('success', 'Conta criada com sucesso.');
        }

        return view('website/user/auth/register');
    }

    /* ======================
     * RECOVERY
     * ====================== */
    public function makeRecovery()
    {
        if ($this->request->getMethod() === 'post') {

            $email = trim((string) $this->request->getPost('email'));

            if (! $this->validate([
                'email' => 'required|valid_email',
            ])) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Busca customer
            $customer = $this->CustomerModel
                ->where('email', $email)
                ->where('deleted_at', null)
                ->first();

            // Resposta neutra SEMPRE (segurança)
            $okMessage = 'Se o email existir, receberá instruções.';

            if (! $customer) {
                return redirect()->back()->with('success', $okMessage);
            }

            // (Opcional mas recomendado) invalidar tokens anteriores password_reset ainda válidos
            $this->CustomerTokenModel
                ->where('customer_id', $customer['id'])
                ->where('type', 'password_reset')
                ->delete(); // se o model for soft delete, ajusta conforme

            // Gerar token
            $token   = bin2hex(random_bytes(32)); // 64 chars
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 hora

            $this->CustomerTokenModel->insert([
                'customer_id' => (int) $customer['id'],
                'token'       => $token,
                'type'        => 'password_reset', // ENUM correto
                'expires_at'  => $expires,
                'created_at'  => date('Y-m-d H:i:s'),
            ]);

            // Aqui entra o envio de email com link (depois)
            // Ex: /user/auth/reset?token=...

            return redirect()->back()->with('success', $okMessage);
        }

        return view('website/user/auth/recovery');
    }
    /* ======================
     * LOGOUT
     * ====================== */
    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/');
    }
}
