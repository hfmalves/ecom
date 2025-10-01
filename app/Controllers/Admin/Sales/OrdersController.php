<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;

use App\Models\Admin\Catalog\ProductsModel;

use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;

use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;

use App\Models\Admin\Catalog\ProductsVariantsModel;





class OrdersController extends BaseController
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
        $customers   = $this->customerModel->findAll();
        $addresses   = $this->customerAddressModel->findAll();
        $shipMethods = $this->shippingMethodsModel->findAll();
        $payMethods  = $this->paymentMethodsModel->findAll();
        $maps = [
            'customer_id'         => array_column($customers, null, 'id'),
            'billing_address_id'  => array_column($addresses, null, 'id'),
            'shipping_address_id' => array_column($addresses, null, 'id'),
            'shipping_method_id'  => array_column($shipMethods, null, 'id'),
            'payment_method_id'   => array_column($payMethods, null, 'id'),
        ];
        $orders = $this->ordersModel->findAll();
        $shipments      = $this->ordersShipmentsModel->findAll();
        $shipmentItems  = $this->ordersShipmentItemsModel->findAll();
        $statusHistory  = $this->ordersStatusHistoryModel->findAll();
        $mapShipments = [];
        foreach ($shipments as $s) {
            $mapShipments[$s['order_id']][] = $s;
        }
        $mapStatusHistory = [];
        foreach ($statusHistory as $h) {
            $mapStatusHistory[$h['order_id']][] = $h;
        }
        $mapShipmentItems = [];
        foreach ($shipmentItems as $si) {
            $mapShipmentItems[$si['shipment_id']][] = $si;
        }
        foreach ($orders as &$o) {
            foreach ($maps as $field => $map) {
                if ($field === 'customer_id') {
                    $o['user'] = $map[$o['customer_id']] ?? ['name' => 'N/A', 'email' => ''];
                } else {
                    $key = str_replace('_id', '', $field);
                    $o[$key] = $map[$o[$field]] ?? ['name' => 'N/A'];
                }
            }

            $o['shipments']      = $mapShipments[$o['id']] ?? [];
            $o['status_history'] = $mapStatusHistory[$o['id']] ?? [];

            foreach ($o['shipments'] as &$s) {
                $s['items'] = $mapShipmentItems[$s['id']] ?? [];
            }
        }

        return view('admin/sales/orders/index', [
            'orders' => $orders
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Encomenda não encontrada');
        }
        $order = $this->ordersModel->find($id);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Encomenda #$id não encontrada");
        }
        $order['user']             = $this->customerModel->find($order['customer_id']);
        $order['billing_address']  = $this->customerAddressModel->find($order['billing_address_id']);
        $order['shipping_address'] = $this->customerAddressModel->find($order['shipping_address_id']);
        $order['payment_method']   = $this->paymentMethodsModel->find($order['payment_method_id']);
        $order['shipping_method']  = $this->shippingMethodsModel->find($order['shipping_method_id']);
        $items = $this->ordersItemsModel
            ->where('order_id', $id)
            ->findAll();
        foreach ($items as &$item) {
            $product = $this->productsModel->find($item['product_id']);
            $item['product_name'] = $product['name'] ?? 'Produto #'.$item['product_id'];

            if (!empty($item['variant_id'])) {
                $variant = $this->productsVariantsModel->find($item['variant_id']);
                $item['variant_name'] = $variant['sku'] ?? 'Variante #'.$item['variant_id'];
            } else {
                $item['variant_name'] = '-';
            }
        }
        $order['items'] = $items;
        $shipments = $this->ordersShipmentsModel->where('order_id', $id)->findAll();
        foreach ($shipments as &$s) {
            $s['items'] = $this->ordersShipmentItemsModel
                ->where('shipment_id', $s['id'])
                ->findAll();
        }
        $order['shipments'] = $shipments;
        $order['status_history'] = $this->ordersStatusHistoryModel
            ->where('order_id', $id)
            ->orderBy('created_at', 'asc')
            ->findAll();
        return view('admin/sales/orders/edit', [
            'order' => $order,
        ]);
    }



}
