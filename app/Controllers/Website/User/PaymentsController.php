<?php

namespace App\Controllers\Website\User;

use App\Controllers\BaseController;
use App\Models\Admin\Sales\OrdersModel;

class PaymentsController extends BaseController
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

    public function pay($orderId)
    {
        $this->orders
            ->where('id', $orderId)
            ->where('customer_id', $this->customerId())
            ->set('status', 'paid')
            ->update();

        return redirect()->back();
    }

    public function refund($orderId)
    {
        $this->orders
            ->where('id', $orderId)
            ->where('customer_id', $this->customerId())
            ->set('status', 'refunded')
            ->update();

        return redirect()->back();
    }
}
