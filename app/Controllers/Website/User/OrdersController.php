<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use App\Models\Admin\Sales\OrdersModel;

class OrdersController extends BaseController
{
    protected OrdersModel $orders;

    public function __construct()
    {
        $this->orders = new OrdersModel();
    }

    private function customerId(): int
    {
        return session('user.id');
    }

    public function index()
    {
        return view('website/user/account/orders', [
            'orders' => $this->orders
                ->where('customer_id', $this->customerId())
                ->findAll(),
        ]);
    }

    public function show($id)
    {
        return view('website/user/account/order_detail', [
            'order' => $this->orders
                ->where('id', $id)
                ->where('customer_id', $this->customerId())
                ->first(),
        ]);
    }

    public function cancel($id)
    {
        $this->orders
            ->where('id', $id)
            ->where('customer_id', $this->customerId())
            ->set('status', 'cancelled')
            ->update();

        return redirect()->back();
    }
}
