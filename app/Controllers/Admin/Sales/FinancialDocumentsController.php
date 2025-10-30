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
use App\Services\FinancialDocumentService;

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
    protected $financialDocumentsModel;

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
        $this->financialDocumentsModel           = new FinancialDocumentsModel();
    }

    public function index()
    {
        $kpi = [
            'total'        => $this->financialDocumentsModel->countAllResults(),
            'paid'         => $this->financialDocumentsModel->where('status', 'paid')->countAllResults(true),
            'canceled'     => $this->financialDocumentsModel->where('status', 'canceled')->countAllResults(true),
            'refunded'     => $this->financialDocumentsModel->where('status', 'refunded')->countAllResults(true),
            'draft'        => $this->financialDocumentsModel->where('status', 'draft')->countAllResults(true),
            'issued'       => $this->financialDocumentsModel->where('status', 'issued')->countAllResults(true),
            'last_30_days' => $this->financialDocumentsModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'avg_total'    => number_format(
                $this->financialDocumentsModel->selectAvg('total', 'avg')->first()['avg'] ?? 0,
                2, ',', ' '
            ),
        ];
        $invoices  = $this->financialDocumentsModel->orderBy('created_at', 'DESC')->findAll();
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
    public function store()
    {

        $data = $this->request->getJSON(true);

        $orderId = $data['order_id'] ?? null;
        $type    = $data['type'] ?? null;
        $order = $this->ordersModel->find($orderId);
        if (!$order) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Encomenda inválida.'
            ]);
        }
        if (!in_array($type, ['invoice', 'receipt', 'credit_note', 'debit_note'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Tipo de documento inválido.'
            ]);
        }
        $eligibility = $this->validateDocumentEligibility($order, $type);
        if ($eligibility !== true) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => $eligibility
            ]);
        }
        $documentData = [
            'series'         => $data['series'] ?? 'A',
            'invoice_number' => strtoupper(substr($type, 0, 1)) . '-' . date('YmdHis'),
            'date'           => date('Y-m-d'),
            'subtotal'       => $order['subtotal'] ?? 0,
            'vat_total'      => $order['tax_total'] ?? 0,
            'discount_total' => $order['discount_total'] ?? 0,
            'grand_total'    => $order['total'] ?? 0,
            'notes'          => $data['notes'] ?? '',
        ];
        $this->financialDocumentsModel->insert($documentData);
        $documentId = $this->financialDocumentsModel->getInsertID();
        $service = new \App\Services\FinancialDocumentService();
        log_message('error', '[DEBUG: CONTROLLER $data enviado ao PDF] ' . print_r([
                'company'  => companyInfo(),
                'customer' => $this->customerModel->find($order['customer_id']),
                'document' => $documentData,
                'items'    => $this->ordersItemsModel->where('order_id', $order['id'])->findAll(),
                'payment'  => $this->paymentsModel->where('order_id', $order['id'])->first(),
            ], true));
        $result  = $service->create($type, [
            'company'  => \companyInfo(),
            'customer' => $this->customerModel->find($order['customer_id']),
            'document' => $documentData,
            'items'    => $this->ordersItemsModel->where('order_id', $order['id'])->findAll(),
            'payment'  => $this->paymentsModel->where('order_id', $order['id'])->first(),
        ]);
        $this->financialDocumentsModel->update($documentId, [
            'pdf_path' => $result['path'],
            'hash'     => $result['hash'],
            'status'   => 'issued',
        ]);
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Documento criado com sucesso.',
            'data'    => [
                'id'       => $documentId,
                'pdf_path' => $result['path'],
                'hash'     => $result['hash'],
            ],
        ]);
    }


    public function edit($id)
    {
        $invoice = $this->financialDocumentsModel->find($id);
        if (!$invoice) {
            return redirect()
                ->to(base_url('admin/sales/invoices'))
                ->with('error', 'Documento não encontrado.');
        }
        $order = $this->ordersModel->find($invoice['order_id']);
        if ($order) {
            $items = $this->ordersItemsModel
                ->where('order_id', $order['id'])
                ->findAll();
            foreach ($items as &$item) {
                $product = $this->productsModel->find($item['product_id']);

                $item['product_name'] = $product['name'] ?? 'Produto #' . $item['product_id'];
                $item['sku']          = $product['sku'] ?? '-';
                $item['variant_name'] = '-'; // ainda não usas variantes
            }
            $order['items'] = $items;
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

    private function validateDocumentEligibility(array $order, string $type)
    {
        // verificar se já existe documento para esta encomenda
        $existingDocs = $this->financialDocumentsModel
            ->where('order_id', $order['id'])
            ->findAll();
        switch ($type) {
            case 'invoice':
                $existsInvoice = array_filter($existingDocs, fn($d) => $d['type'] === 'invoice' && !in_array($d['status'], ['canceled', 'refunded']));
                if ($existsInvoice) {
                    return 'Já existe uma fatura ativa para esta encomenda.';
                }
                if (!in_array($order['status'], ['processing', 'completed'])) {
                    return 'A encomenda ainda não está pronta para faturação.';
                }
                break;
            case 'receipt':
                $payment = $this->paymentsModel->where('order_id', $order['id'])->where('status', 'paid')->first();
                if (!$payment) {
                    return 'Não há pagamentos confirmados para gerar recibo.';
                }
                break;
            case 'credit_note':
                $invoice = array_filter($existingDocs, fn($d) => $d['type'] === 'invoice' && !in_array($d['status'], ['canceled']));
                if (!$invoice) {
                    return 'Não existe fatura ativa associada a esta encomenda.';
                }
                break;
            case 'debit_note':
                $invoice = array_filter($existingDocs, fn($d) => $d['type'] === 'invoice' && !in_array($d['status'], ['canceled']));
                if (!$invoice) {
                    return 'Não existe fatura ativa associada a esta encomenda.';
                }
                break;
        }
        return true;
    }

}
