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
        // === KPIs ===
        $kpi = [
            'total'        => $this->invoicesModel->countAllResults(),
            'paid'         => $this->invoicesModel->where('status', 'paid')->countAllResults(true),
            'canceled'     => $this->invoicesModel->where('status', 'canceled')->countAllResults(true),
            'refunded'     => $this->invoicesModel->where('status', 'refunded')->countAllResults(true),
            'draft'        => $this->invoicesModel->where('status', 'draft')->countAllResults(true),
            'issued'       => $this->invoicesModel->where('status', 'issued')->countAllResults(true),
            'last_30_days' => $this->invoicesModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'avg_total'    => number_format(
                $this->invoicesModel->selectAvg('total', 'avg')->first()['avg'] ?? 0,
                2, ',', ' '
            ),
        ];
        $invoices  = $this->invoicesModel->orderBy('created_at', 'DESC')->findAll();
        $payments  = $this->paymentsModel->findAll();
        $orders    = $this->ordersModel->findAll();
        $customers = $this->customerModel->findAll();
        $mapPayments  = array_column($payments, null, 'invoice_id');
        $mapOrders    = array_column($orders, null, 'id');
        $mapCustomers = array_column($customers, null, 'id');
        foreach ($invoices as &$inv) {
            $inv['payment']  = $mapPayments[$inv['id']] ?? null;
            $inv['order']    = $mapOrders[$inv['order_id']] ?? null;
            $inv['customer'] = $mapCustomers[$inv['order']['customer_id'] ?? 0] ?? null;
        }

        return view('admin/sales/invoices/index', [
            'invoices' => $invoices,
            'kpi'      => $kpi,
        ]);
    }
    public function edit($id)
    {
        $invoice = $this->invoicesModel->find($id);
        if (!$invoice) {
            return redirect()->to(base_url('admin/sales/invoices'))
                ->with('error', 'Documento não encontrado.');
        }
        $order = $this->ordersModel->find($invoice['order_id']);
        if ($order) {
            // Itens da encomenda
            $order['items'] = $this->ordersItemsModel
                ->where('order_id', $order['id'])
                ->findAll();
            $invoice['order'] = $order;
        }
        if (!empty($order['customer_id'])) {
            $invoice['customer'] = $this->customerModel->find($order['customer_id']);
        }
        $invoice['payment'] = $this->paymentsModel
            ->where('invoice_id', $invoice['id'])
            ->first();
        $shipment = $this->ordersShipmentsModel
            ->where('order_id', $invoice['order_id'])
            ->first();
        if ($shipment) {
            $invoice['shipment'] = $shipment;
        }
        return view('admin/sales/invoices/edit', [
            'invoice' => $invoice,
        ]);
    }


}
