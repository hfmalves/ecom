<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Sales\OrdersCartsModel;
use App\Models\Admin\Customers\CustomerModel;

class OrdersCartController extends BaseController
{
    protected $cartsModel;
    protected $customerModel;

    public function __construct()
    {
        $this->cartsModel    = new OrdersCartsModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $carts     = $this->cartsModel->findAll();
        $customers = $this->customerModel->findAll();
        $mapCustomers = array_column($customers, null, 'id');

        // associa cliente
        foreach ($carts as &$c) {
            $c['customer'] = $mapCustomers[$c['customer_id']] ?? null;
        }

        return view('admin/sales/cart/index', [
            'carts' => $carts
        ]);
    }
}
