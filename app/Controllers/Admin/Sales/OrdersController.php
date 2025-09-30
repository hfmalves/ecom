<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;


class OrdersController extends BaseController
{
    protected $ordersModel;
    protected $productsModel;
    protected $customerModel;
    protected $customerAddressModel;
    protected $paymentMethodsModel;
    protected $shippingMethodsModel;

    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
        $this->productsModel = new ProductsModel();
        $this->customerModel = new CustomerModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->paymentMethodsModel = new PaymentMethodsModel();
        $this->shippingMethodsModel = new ShippingMethodsModel();
    }

    public function index()
    {
        // 1. Buscar dados
        $customers   = $this->customerModel->findAll();
        $addresses   = $this->customerAddressModel->findAll();
        $shipMethods = $this->shippingMethodsModel->findAll();
        $payMethods  = $this->paymentMethodsModel->findAll();
        $maps = [
            'user_id'             => array_column($customers, null, 'id'),
            'billing_address_id'  => array_column($addresses, null, 'id'),
            'shipping_address_id' => array_column($addresses, null, 'id'),
            'shipping_method_id'  => array_column($shipMethods, null, 'id'),
            'payment_method_id'   => array_column($payMethods, null, 'id'),
        ];
        $orders = $this->ordersModel->findAll();
        foreach ($orders as &$o) {
            foreach ($maps as $field => $map) {
                $key = str_replace('_id', '', $field);
                $o[$key] = $map[$o[$field]] ?? ['name' => 'N/A'];
            }
        }
        return view('admin/sales/orders/index', ['orders' => $orders]);
    }

}
