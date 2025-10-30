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
        $payments  = $this->paymentsModel->orderBy('created_at', 'DESC')->findAll();
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
        $eligibleOrders = $this->ordersModel
            ->whereNotIn('status', ['completed', 'processing', 'refunded'])
            ->findAll();
        $paidPayments = $this->paymentsModel
            ->where('status', 'paid')
            ->findAll();
        $paidOrderIds = array_unique(array_column($paidPayments, 'order_id'));
        $ordersForManualPayment = array_filter($eligibleOrders, function ($order) use ($paidOrderIds) {
            return !in_array($order['id'], $paidOrderIds);
        });
        // === Enviar tudo para a view ===
        return view('admin/sales/payments/index', [
            'payments' => $payments,
            'kpi'      => $kpi,
            'orders'   => $ordersForManualPayment,
            'payments_methods' => $this->paymentMethodsModel->findAll(),
        ]);
    }
    public function store()
    {
        if (!$this->request->is('post')) {
            return redirect()->back()->with('error', 'Método inválido');
        }

        $data = $this->request->getJSON(true);

        if (empty($data['order_id']) || empty($data['method']) || empty($data['amount'])) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Campos obrigatórios em falta.'
            ]);
        }

        // Buscar método de pagamento
        $method = $this->paymentMethodsModel
            ->where('name', $data['method'])
            ->first();

        $useGateway = $method['use_gateway'] ?? 0;

        // === 🔹 GERAÇÃO AUTOMÁTICA DE transaction_id E reference (quando manual) ===
        $transactionId = $data['transaction_id'] ?? null;
        $reference = $data['reference'] ?? null;

        if ($useGateway == 0) {
            $micro = str_replace('.', '', microtime(true));
            if (empty($transactionId)) {
                $transactionId = 'TRM-' . $micro;
            }
            if (empty($reference)) {
                $reference = 'TRM-' . substr($micro, -8) . '-' . random_int(100, 999);
            }
        }
        $paymentData = [
            'invoice_id'         => null, // opcional
            'order_id'           => (int) $data['order_id'],
            'payment_method_id'  => (int) ($data['payment_method_id'] ?? 0),
            'amount'             => (float) $data['amount'],
            'currency'           => $data['currency'] ?? 'EUR',
            'method'             => $data['method'],
            'transaction_id'     => $transactionId,
            'reference'          => $reference,
            'status'             => $data['status'],
            'notes'              => $data['comment'] ?? null,
            'gateway'            => $useGateway,
            'created_at'         => date('Y-m-d H:i:s'),
            'created_by'         => session('user.id') ?? null,
        ];
        if (!$this->paymentsModel->insert($paymentData)) {
            log_message('error', 'Erro ao inserir pagamento: ' . print_r($this->paymentsModel->errors(), true));
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 'error',
                'message' => 'Erro ao criar pagamento.',
                'errors' => $this->paymentsModel->errors()
            ]);
        }
        $paymentId = $this->paymentsModel->getInsertID();
        if ($data['status'] === 'paid') {
            $this->ordersModel
                ->where('id', $data['order_id'])
                ->set(['status' => 'processing'])
                ->update();
        }

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Transação criada com sucesso.',
            'payment_id' => $paymentId,
            'transaction_id' => $transactionId,
            'reference' => $reference
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
