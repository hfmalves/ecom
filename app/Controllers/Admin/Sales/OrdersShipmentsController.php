<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Customers\CustomerGroupModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;
use App\Models\Admin\Sales\OrdersShipmentHistoryModel;

class OrdersShipmentsController extends BaseController
{
    protected $ordersModel;
    protected $ordersItemsModel;
    protected $productsModel;
    protected $customerModel;
    protected $customerAddressModel;
    protected $customerGroupModel;
    protected $paymentMethodsModel;
    protected $shippingMethodsModel;
    protected $ordersShipmentsModel;
    protected $ordersShipmentItemsModel;
    protected $ordersStatusHistoryModel;
    protected $ordersShipmentHistoryModel;
    protected $productsVariantsModel;

    public function __construct()
    {
        $this->ordersModel = new OrdersModel();
        $this->ordersItemsModel = new OrdersItemsModel();
        $this->productsModel = new ProductsModel();
        $this->productsVariantsModel = new ProductsVariantsModel();
        $this->customerModel = new CustomerModel();
        $this->customerGroupModel = new CustomerGroupModel();
        $this->customerAddressModel = new CustomerAddressModel();
        $this->paymentMethodsModel = new PaymentMethodsModel();
        $this->shippingMethodsModel = new ShippingMethodsModel();
        $this->ordersShipmentsModel = new OrdersShipmentsModel();
        $this->ordersShipmentItemsModel = new OrdersShipmentItemsModel();
        $this->ordersStatusHistoryModel = new OrdersStatusHistoryModel();
        $this->ordersShipmentHistoryModel = new OrdersShipmentHistoryModel();
    }
    public function index()
    {
        // === KPIs de Envio ===
        $kpi = [
            'total'          => $this->ordersShipmentsModel->countAllResults(),
            'pending'        => $this->ordersShipmentsModel->where('status', 'pending')->countAllResults(true),
            'processing'     => $this->ordersShipmentsModel->where('status', 'processing')->countAllResults(true),
            'shipped'        => $this->ordersShipmentsModel->where('status', 'shipped')->countAllResults(true),
            'delivered'      => $this->ordersShipmentsModel->where('status', 'delivered')->countAllResults(true),
            'returned'       => $this->ordersShipmentsModel->where('status', 'returned')->countAllResults(true),
            'canceled'       => $this->ordersShipmentsModel->where('status', 'canceled')->countAllResults(true),
            'last_30_days'   => $this->ordersShipmentsModel
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
        ];

        // === Dados dos Envios ===
        $shipments = $this->ordersShipmentsModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $orders     = $this->ordersModel->findAll();
        $customers  = $this->customerModel->findAll();
        $shipMethods = $this->shippingMethodsModel->findAll();

        $mapOrders      = array_column($orders, null, 'id');
        $mapCustomers   = array_column($customers, null, 'id');
        $mapShipMethods = array_column($shipMethods, null, 'id');

        foreach ($shipments as &$s) {
            $order = $mapOrders[$s['order_id']] ?? null;
            $s['order'] = $order;
            $s['customer'] = $mapCustomers[$order['customer_id']] ?? null;

            if (!empty($order['shipping_method_id'])) {
                $s['shipping_method'] = $mapShipMethods[$order['shipping_method_id']] ?? null;
            } else {
                $s['shipping_method'] = ['name' => $s['carrier'] ?? '—'];
            }
        }

        return view('admin/sales/shipments/index', [
            'shipments' => $shipments,
            'kpi'       => $kpi,
        ]);
    }
    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Envio não encontrado');
        }
        $shipment = $this->ordersShipmentsModel->find($id);
        if (!$shipment) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Envio #$id não encontrado");
        }
        $order = $this->ordersModel->find($shipment['order_id']);
        if (!$order) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Encomenda associada ao envio #$id não encontrada");
        }
        $customer = $this->customerModel->find($order['customer_id']);
        if ($customer) {
            $groupName = '-';
            if (!empty($customer['group_id'])) {
                $group = $this->customerGroupModel->find($customer['group_id']);
                $groupName = $group['name'] ?? '-';
            }
            $customer['group_name'] = $groupName;
        }
        $paymentMethod  = $this->paymentMethodsModel->find($order['payment_method_id']);
        $shippingMethod = $this->shippingMethodsModel->find($order['shipping_method_id']);
        $billingAddress  = $this->customerAddressModel->find($order['billing_address_id']);
        $shippingAddress = $this->customerAddressModel->find($order['shipping_address_id']);
        $items = $this->ordersItemsModel
            ->where('order_id', $order['id'])
            ->findAll();
        foreach ($items as &$item) {
            $product = $this->productsModel->find($item['product_id']);
            $item['product_name'] = $product['name'] ?? 'Produto #' . $item['product_id'];
            $item['sku'] = $product['sku'] ?? '-';

            if (!empty($item['variant_id'])) {
                $variant = $this->productsVariantsModel->find($item['variant_id']);
                $item['variant_name'] = $variant['sku'] ?? 'Variante #' . $item['variant_id'];
            } else {
                $item['variant_name'] = '-';
            }
        }
        $shipment['order']          = $order;
        $shipment['customer']       = $customer;
        $shipment['payment_method'] = $paymentMethod;
        $shipment['shipping_method'] = $shippingMethod;
        $shipment['billing_address'] = $billingAddress;
        $shipment['shipping_address'] = $shippingAddress;
        $shipment['items'] = $items;

        // --- Histórico de alterações no envio (se tiveres tabela própria, senão ignora) ---
        $shipment['history'] = $this->ordersShipmentHistoryModel
            ->where('shipment_id', $shipment['id'])
            ->orderBy('created_at', 'DESC')
            ->findAll();
        $shippingMethods = $this->shippingMethodsModel->findAll();
        $statuses = [
            'pending'    => 'Pendente',
            'processing' => 'Em processamento',
            'shipped'    => 'Enviado',
            'delivered'  => 'Entregue',
            'returned'   => 'Devolvido',
            'canceled'   => 'Cancelado',
        ];

        // --- View ---
        return view('admin/sales/shipments/edit', [
            'shipment' => $shipment,
            'shippingMethods' => $shippingMethods,
            'statuses' => $statuses,
        ]);
    }
    public function update()
    {
        $data = $this->request->getJSON(true);

        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do envio não enviado.',
            ]);
        }

        $id = (int) $data['id'];
        unset($data['id']);

        $shipment = $this->ordersShipmentsModel->find($id);
        if (! $shipment) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "Envio #{$id} não encontrado.",
            ]);
        }

        // --- Buscar nome da transportadora ---
        $carrierName = $shipment['carrier'] ?? '';
        if (!empty($data['shipping_method_id'])) {
            $shippingMethod = model(ShippingMethodsModel::class)->find($data['shipping_method_id']);
            if ($shippingMethod) {
                $carrierName = $shippingMethod['name'];
            }
        }

        // --- Dados consolidados ---
        $data = [
            'shipping_method_id' => (int)($data['shipping_method_id'] ?? 0),
            'carrier'            => $carrierName,
            'tracking_number'    => trim($data['tracking_number'] ?? ''),
            'status'             => strtolower(trim($data['status'] ?? 'pending')),
            'comments'           => trim($data['comments'] ?? ''),
            'updated_at'         => date('Y-m-d H:i:s'),
        ];

        // --- Validação ---
        if (! $this->ordersShipmentsModel->validate($data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->ordersShipmentsModel->errors(),
            ]);
        }

        // --- Atualização ---
        if (! $this->ordersShipmentsModel->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'error',
                'errors' => $this->ordersShipmentsModel->errors(),
            ]);
        }

        // --- Histórico ---
        if (property_exists($this, 'ordersShipmentHistoryModel')) {
            $this->ordersShipmentHistoryModel->insert([
                'shipment_id' => $id,
                'status'      => $data['status'],
                'carrier'     => $data['carrier'],
                'tracking'    => $data['tracking_number'],
                'comment'     => $data['comments'],
                'created_at'  => date('Y-m-d H:i:s'),
            ]);
        }

        // --- Atualiza estado da encomenda associada ---
        if (! empty($shipment['order_id'])) {
            $this->ordersModel->update($shipment['order_id'], [
                'status'     => $data['status'],
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Envio atualizado com sucesso!',
            'id'      => $id,
        ]);
    }






}
