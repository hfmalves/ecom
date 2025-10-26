<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;
use App\Models\Admin\Sales\PaymentsModel;

use App\Models\Admin\Catalog\ProductsModel;

use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerGroupModel;

use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;

use App\Models\Admin\Catalog\ProductsVariantsModel;


class OrdersController extends BaseController
{
    protected $ordersModel;
    protected $ordersItemsModel;
    protected $productsModel;
    protected $customerModel;
    protected $customerGroupModel;
    protected $customerAddressModel;
    protected $paymentMethodsModel;
    protected $shippingMethodsModel;
    protected $ordersShipmentsModel;
    protected $ordersShipmentItemsModel;
    protected $ordersStatusHistoryModel;
    protected $paymentsModel;
    protected $productsVariantsModel;


    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
        $this->ordersItemsModel = new OrdersItemsModel();
        $this->productsModel = new ProductsModel();
        $this->productsVariantsModel = new ProductsVariantsModel();
        $this->customerModel = new CustomerModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->customerGroupModel = new CustomerGroupModel();
        $this->paymentMethodsModel = new PaymentMethodsModel();
        $this->shippingMethodsModel = new ShippingMethodsModel();
        $this->ordersShipmentsModel = new OrdersShipmentsModel();
        $this->ordersShipmentItemsModel = new OrdersShipmentItemsModel();
        $this->ordersStatusHistoryModel = new OrdersStatusHistoryModel();
        $this->paymentsModel = new PaymentsModel();
    }
    public function index()
    {
        $ordersModel = $this->ordersModel;

        // KPIs
        $kpi = [
            'total_orders'      => $ordersModel->countAllResults(),
            'pending_orders'    => (clone $ordersModel)->where('status', 'pending')->countAllResults(true),
            'processing_orders' => (clone $ordersModel)->where('status', 'processing')->countAllResults(true),
            'completed_orders'  => (clone $ordersModel)->where('status', 'completed')->countAllResults(true),
            'canceled_orders'   => (clone $ordersModel)->where('status', 'canceled')->countAllResults(true),
            'refunded_orders'   => (clone $ordersModel)->where('status', 'refunded')->countAllResults(true),
            'total_revenue'     => number_format((clone $ordersModel)
                ->selectSum('grand_total')
                ->get()->getRow()->grand_total ?? 0, 2, ',', ' '),
            'total_discount'    => number_format((clone $ordersModel)
                ->selectSum('total_discount')
                ->get()->getRow()->total_discount ?? 0, 2, ',', ' '),
            'avg_ticket'        => number_format((clone $ordersModel)
                ->selectAvg('grand_total')
                ->get()->getRow()->grand_total ?? 0, 2, ',', ' '),
            'avg_items'         => number_format((clone $ordersModel)
                ->selectAvg('total_items')
                ->get()->getRow()->total_items ?? 0, 0, ',', ' '),
            'new_30_days'       => (clone $ordersModel)
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'revenue_30_days'   => number_format(
                (clone $ordersModel)
                    ->selectSum('grand_total')
                    ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                    ->get()->getRow()->grand_total ?? 0,
                2, ',', ' '
            ),
        ];

        // Carregamentos base
        $customers   = $this->customerModel->findAll();
        $addresses   = $this->customerAddressModel->findAll();
        $shipMethods = $this->shippingMethodsModel->findAll();
        $payMethods  = $this->paymentMethodsModel->findAll();

        // Mapeamentos
        $maps = [
            'customer_id'         => array_column($customers, null, 'id'),
            'billing_address_id'  => array_column($addresses, null, 'id'),
            'shipping_address_id' => array_column($addresses, null, 'id'),
            'shipping_method_id'  => array_column($shipMethods, null, 'id'),
            'payment_method_id'   => array_column($payMethods, null, 'id'),
        ];

        // Carregar dados principais
        $orders         = $this->ordersModel->findAll();
        $payments       = $this->paymentsModel->findAll();
        $shipments      = $this->ordersShipmentsModel->findAll();
        $shipmentItems  = $this->ordersShipmentItemsModel->findAll();
        $statusHistory  = $this->ordersStatusHistoryModel->findAll();

        // Mapas auxiliares
        $mapPayments = [];
        foreach ($payments as $p) {
            $mapPayments[$p['order_id']] = $p;
        }

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

        // Enriquecer dados das encomendas
        foreach ($orders as &$o) {
            foreach ($maps as $field => $map) {
                if ($field === 'customer_id') {
                    $o['user'] = $map[$o['customer_id']] ?? ['name' => 'N/A', 'email' => ''];
                } else {
                    $key = str_replace('_id', '', $field);
                    $o[$key] = $map[$o[$field]] ?? ['name' => 'N/A'];
                }
            }

            // Pagamento
            $o['payment'] = $mapPayments[$o['id']] ?? [
                'method'   => 'N/A',
                'status'   => 'pending',
                'paid_at'  => null,
            ];

            // Envios
            $o['shipments']      = $mapShipments[$o['id']] ?? [];
            $o['status_history'] = $mapStatusHistory[$o['id']] ?? [];

            // Detalhes do envio
            if (!empty($o['shipments'])) {
                $mainShipment         = $o['shipments'][0];
                $o['shipment_status'] = $mainShipment['status'] ?? 'pending';
                $o['shipped_at']      = $mainShipment['shipped_at'] ?? null;
                $o['delivered_at']    = $mainShipment['delivered_at'] ?? null;
                $o['returned_at']     = $mainShipment['returned_at'] ?? null;
            } else {
                $o['shipment_status'] = 'pending';
                $o['shipped_at']      = null;
                $o['delivered_at']    = null;
                $o['returned_at']     = null;
            }

            // Itens do envio
            foreach ($o['shipments'] as &$s) {
                $s['items'] = $mapShipmentItems[$s['id']] ?? [];
            }
        }

        return view('admin/sales/orders/index', [
            'orders' => $orders,
            'kpi'    => $kpi,
        ]);
    }
    public function create()
    {
        log_message('error', '--- [CREATE] Método iniciado ---');

        // Aceita POST normal ou AJAX (fetch)
        if (! in_array(strtolower($this->request->getMethod()), ['post', 'ajax'])) {
            log_message('error', '[CREATE] Rejeitado: método != POST/AJAX');
            return $this->response->setJSON(['status' => 'error', 'message' => 'Método inválido']);
        }

        $db = db_connect();
        $db->transBegin();
        log_message('error', '[CREATE] Ligação à BD e transação iniciada');

        try {
            $data = [
                'customer_id'        => null,
                'user_id'            => 1,
                'status'             => 'pending',
                'total_items'        => 0,
                'total_tax'          => 0,
                'total_discount'     => 0,
                'grand_total'        => 0,
                'billing_address_id' => 1,
                'shipping_method_id' => 1,
                'payment_method_id'  => 1,
                'created_at'         => date('Y-m-d H:i:s'),
            ];
            $this->ordersModel->insert($data);
            $orderId = $this->ordersModel->getInsertID();
            if (! $orderId) {
                throw new \Exception('Falha ao criar encomenda.');
            }
            $this->ordersStatusHistoryModel->insert([
                'order_id'   => $orderId,
                'status'     => 'pending',
                'comment'    => 'Encomenda criada.',
                'notify'     => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $db->transCommit();
            log_message('error', '[CREATE] Commit OK, encomenda #' . $orderId);
            return $this->response->setJSON([
                'status'   => 'success',
                'message'  => 'Encomenda criada com sucesso.',
                'redirect' => base_url('admin/sales/orders/edit/' . $orderId),
            ]);
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', '[CREATE][ERRO FATAL] ' . $e->getMessage());

            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Ocorreu um erro ao criar a encomenda.',
            ]);
        }
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

        // --- Cliente e grupo ---
        $order['user'] = $this->customerModel->find($order['customer_id']);
        if (!empty($order['user']['group_id'])) {
            $group = $this->customerGroupModel->find($order['user']['group_id']);
            $order['user']['group_name'] = $group['name'] ?? '-';
        } else {
            $order['user']['group_name'] = '-';
        }

        // --- Moradas e métodos ---
        $order['billing_address']  = $this->customerAddressModel->find($order['billing_address_id']);
        $order['shipping_address'] = $this->customerAddressModel->find($order['shipping_address_id']);
        $order['payment_method']   = $this->paymentMethodsModel->find($order['payment_method_id']);
        $order['shipping_method']  = $this->shippingMethodsModel->find($order['shipping_method_id']);

        // --- 💳 Pagamento real (tabela payments) ---
        $order['payment'] = $this->paymentsModel
            ->where('order_id', $id)
            ->first();

        // --- Itens ---
        $items = $this->ordersItemsModel
            ->where('order_id', $id)
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

        // --- Expedições ---
        $shipments = $this->ordersShipmentsModel->where('order_id', $id)->findAll();
        foreach ($shipments as &$s) {
            $s['items'] = $this->ordersShipmentItemsModel
                ->where('shipment_id', $s['id'])
                ->findAll();
        }
        $order['shipments'] = $shipments;

        // --- Histórico de estado ---
        $order['status_history'] = $this->ordersStatusHistoryModel
            ->where('order_id', $id)
            ->orderBy('created_at', 'asc')
            ->findAll();

        // --- Métodos disponíveis ---
        $paymentMethods  = $this->paymentMethodsModel->findAll();
        $shippingMethods = $this->shippingMethodsModel->findAll();

        // --- View ---
        return view('admin/sales/orders/edit', [
            'order' => $order,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $shippingMethods,
        ]);
    }

    public function updateStatus()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID da encomenda não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        $id = $data['id'];
        unset($data['id']);

        // validar se a encomenda existe
        $order = $this->ordersModel->find($id);
        if (! $order) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "Encomenda #{$id} não encontrada.",
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // defaults
        $data['status']     = $data['status'] ?? 'pending';
        $data['comment']    = $data['comment'] ?? '';
        $data['notify']     = $data['notify'] ?? '0';
        $data['updated_at'] = date('Y-m-d H:i:s');

        // validação dinâmica
        $this->ordersModel->setValidationRules([
            'status' => 'required',
        ]);

        // atualizar a encomenda
        if (! $this->ordersModel->update($id, ['status' => $data['status']])) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->ordersModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // inserir histórico
        $history = [
            'order_id'   => $id,
            'status'     => $data['status'],
            'comment'    => trim($data['comment']),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (! $this->ordersStatusHistoryModel->insert($history)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->ordersStatusHistoryModel->errors(),
                'csrf'   => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }

        // notificar cliente (futuro email real)
        if (!empty($data['notify']) && $data['notify'] === '1') {
            log_message('info', "Notificação de estado enviada para o cliente da encomenda #{$id}.");
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Estado da encomenda atualizado com sucesso!',
            'id'      => $id,
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }





}
