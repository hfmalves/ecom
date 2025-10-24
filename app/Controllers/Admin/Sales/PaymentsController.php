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
use App\Models\Admin\Sales\PaymentsModel;
use App\Models\Admin\Sales\FinancialDocumentsModel;

class PaymentsController extends BaseController
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
        // === KPIs ===
        $kpi = [
            'total'        => $this->paymentsModel->countAllResults(),
            'paid'         => $this->paymentsModel->where('status', 'paid')->countAllResults(true),
            'partial'      => $this->paymentsModel->where('status', 'partial')->countAllResults(true),
            'failed'       => $this->paymentsModel->where('status', 'failed')->countAllResults(true),
            'refunded'     => $this->paymentsModel->where('status', 'refunded')->countAllResults(true),
            'pending'      => $this->paymentsModel->where('status', 'pending')->countAllResults(true),
            'last_30_days' => $this->paymentsModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'avg_value'    => number_format(
                $this->paymentsModel->selectAvg('amount', 'avg')->first()['avg'] ?? 0,
                2,
                ',',
                ' '
            ),
        ];

        // === Dados principais ===
        $payments  = $this->paymentsModel->orderBy('created_at', 'DESC')->findAll();
        $invoices  = $this->invoicesModel->findAll();
        $orders    = $this->ordersModel->findAll();
        $customers = $this->customerModel->findAll();

        // Mapas para acesso rápido
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

        return view('admin/sales/payments/index', [
            'payments' => $payments,
            'kpi'      => $kpi,
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Transação não encontrada');
        }
        $payment = $this->paymentsModel->find($id);
        if (!$payment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Transação #$id não encontrada");
        }
        $invoice  = $this->invoicesModel->find($payment['invoice_id'] ?? 0);
        $order    = $invoice ? $this->ordersModel->find($invoice['order_id']) : null;
        $customer = $order ? $this->customerModel->find($order['customer_id']) : null;
        $items = [];
        if (!empty($order)) {
            $items = $this->ordersItemsModel
                ->where('order_id', $order['id'])
                ->findAll();
            foreach ($items as &$item) {
                $product = $this->productsModel->find($item['product_id']);
                $item['product_name'] = $product['name'] ?? 'Produto #' . $item['product_id'];

                if (!empty($item['variant_id'])) {
                    $variant = $this->productsVariantsModel->find($item['variant_id']);
                    $item['variant_name'] = $variant['sku'] ?? 'Variante #' . $item['variant_id'];
                } else {
                    $item['variant_name'] = '-';
                }
            }
            $order['items'] = $items;
        }
        if (!empty($order['payment_method_id'])) {
            $pm = $this->paymentMethodsModel->find($order['payment_method_id']);
            $order['payment_method_name'] = $pm['name'] ?? '-';
        }
        if (!empty($order['shipping_method_id'])) {
            $sm = $this->shippingMethodsModel->find($order['shipping_method_id']);
            $order['shipping_method_name'] = $sm['name'] ?? '-';
        }
        $payment['invoice']  = $invoice;
        $payment['order']    = $order;
        $payment['customer'] = $customer;
        $methods = $this->paymentMethodsModel->findAll();
        return view('admin/sales/payments/edit', [
            'payment' => $payment,
            'methods' => $methods,
        ]);
    }



}
