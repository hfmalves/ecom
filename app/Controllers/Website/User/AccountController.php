<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use App\Models\Admin\Customers\CustomerModel;

class AccountController extends BaseController
{
    protected CustomerModel $customers;

    public function __construct()
    {
        $this->customers = new CustomerModel();
    }

    private function customerId(): int
    {
        return session('user.id');
    }

    public function dashboard()
    {
        return view('website/user/account/dashboard', [
            'customer' => $this->customers->find($this->customerId())
        ]);
    }

    public function edit()
    {
        return view('website/user/account/edit', [
            'customer' => $this->customers->find($this->customerId())
        ]);
    }
}
