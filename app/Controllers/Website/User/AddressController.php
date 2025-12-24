<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use App\Models\Admin\Customers\CustomerAddressModel;

class AddressController extends BaseController
{
    protected CustomerAddressModel $addresses;

    public function __construct()
    {
        $this->addresses = new CustomerAddressModel();
    }

    private function customerId(): int
    {
        return session('user.id');
    }

    public function index()
    {
        return view('website/user/account/address', [
            'addresses' => $this->addresses
                ->where('customer_id', $this->customerId())
                ->findAll(),
        ]);
    }

    public function store()
    {
        $this->addresses->insert(
            array_merge(
                $this->request->getPost(),
                ['customer_id' => $this->customerId()]
            )
        );

        return redirect()->back();
    }

    public function update($id)
    {
        $this->addresses
            ->where('id', $id)
            ->where('customer_id', $this->customerId())
            ->update($id, $this->request->getPost());

        return redirect()->back();
    }

    public function delete($id)
    {
        $this->addresses
            ->where('id', $id)
            ->where('customer_id', $this->customerId())
            ->delete();

        return redirect()->back();
    }
}
