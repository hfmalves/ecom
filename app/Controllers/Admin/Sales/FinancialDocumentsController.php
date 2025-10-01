<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Sales\FinancialDocumentsModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;
use App\Models\Admin\Sales\PaymentsModel;
use CodeIgniter\HTTP\ResponseInterface;

class FinancialDocumentsController extends BaseController
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
    protected $paymentsModel;
    protected $invoicesModel;

    public function __construct()
    {
        $this->ordersModel             = new OrdersModel();
        $this->ordersItemsModel        = new OrdersItemsModel();
        $this->productsModel           = new ProductsModel();
        $this->productsVariantsModel   = new ProductsVariantsModel();
        $this->customerModel           = new CustomerModel();
        $this->customerAddressModel    = new CustomerAddressModel();
        $this->paymentMethodsModel     = new PaymentMethodsModel();
        $this->shippingMethodsModel    = new ShippingMethodsModel();
        $this->ordersShipmentsModel    = new OrdersShipmentsModel();
        $this->ordersShipmentItemsModel= new OrdersShipmentItemsModel();
        $this->ordersStatusHistoryModel= new OrdersStatusHistoryModel();
        $this->paymentsModel           = new PaymentsModel();
        $this->invoicesModel           = new FinancialDocumentsModel();
    }

    public function index()
    {
        $payments  = $this->paymentsModel->findAll();
        $invoices  = $this->invoicesModel->findAll();
        $orders    = $this->ordersModel->findAll();
        $customers = $this->customerModel->findAll();
        $mapInvoices  = array_column($invoices, null, 'id');
        $mapOrders    = array_column($orders, null, 'id');
        $mapCustomers = array_column($customers, null, 'id');
        foreach ($payments as &$p) {
            $invoice = $mapInvoices[$p['invoice_id']] ?? null;
            $p['invoice'] = $invoice;

            if ($invoice) {
                $order = $mapOrders[$invoice['order_id']] ?? null;
                $p['order'] = $order;

                if ($order) {
                    $p['customer'] = $mapCustomers[$order['customer_id']] ?? ['name'=>'N/A','email'=>''];
                }
            }
        }
        return view('admin/sales/invoices/index', [
            'payments' => $payments
        ]);
    }
}
