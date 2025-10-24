<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;

class OrdersShipmentsController extends BaseController
{
    protected $ordersModel;
    protected $ordersItemsModel;
    protected $productsModel;
    protected $customerModel;
    protected $customerAddressModel;
    protected $paymentMethodsModel;
    protected $shippingMethodsModel;
    protected $ordersShipmentsModel;
    protected $ordersShipmentItemsModel;
    protected $ordersStatusHistoryModel;
    protected $productsVariantsModel;

    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
        $this->ordersItemsModel = new OrdersItemsModel();
        $this->productsModel = new ProductsModel();
        $this->productsVariantsModel = new ProductsVariantsModel();
        $this->customerModel = new CustomerModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->paymentMethodsModel = new PaymentMethodsModel();
        $this->shippingMethodsModel = new ShippingMethodsModel();
        $this->ordersShipmentsModel = new OrdersShipmentsModel();
        $this->ordersShipmentItemsModel = new OrdersShipmentItemsModel();
        $this->ordersStatusHistoryModel = new OrdersStatusHistoryModel();

    }
    public function index()
    {
        $shipments = $this->ordersShipmentsModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $orders   = $this->ordersModel->findAll();
        $customers = $this->customerModel->findAll();
        $shipMethods = $this->shippingMethodsModel->findAll();

        // Mapas rápidos
        $mapOrders = array_column($orders, null, 'id');
        $mapCustomers = array_column($customers, null, 'id');
        $mapShipMethods = array_column($shipMethods, null, 'id');

        // Enriquecer envios com info útil
        foreach ($shipments as &$s) {
            $order = $mapOrders[$s['order_id']] ?? null;
            $s['order'] = $order;
            $s['customer'] = $mapCustomers[$order['customer_id']] ?? null;

            // Obter método de envio da encomenda associada
            if (!empty($order['shipping_method_id'])) {
                $s['shipping_method'] = $mapShipMethods[$order['shipping_method_id']] ?? null;
            } else {
                $s['shipping_method'] = ['name' => $s['carrier'] ?? '—'];
            }
        }
        return view('admin/sales/shipments/index', [
            'shipments' => $shipments
        ]);
    }



}
