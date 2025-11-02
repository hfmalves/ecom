<?php

namespace App\Controllers\Admin\Sales;

use App\Controllers\BaseController;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Config\payments\PaymentMethodsModel;
use App\Models\Admin\Config\shipping\ShippingMethodsModel;
use App\Models\Admin\Config\taxes\TaxClassesModel;
use App\Models\Admin\Customers\CustomerAddressModel;
use App\Models\Admin\Customers\CustomerGroupModel;
use App\Models\Admin\Sales\OrdersCartsModel;
use App\Models\Admin\Sales\OrdersCartItemsModel;
use App\Models\Admin\Customers\CustomerModel;
use App\Models\Admin\Sales\OrdersItemsModel;
use App\Models\Admin\Sales\OrdersModel;
use App\Models\Admin\Sales\OrdersShipmentItemsModel;
use App\Models\Admin\Sales\OrdersShipmentsModel;
use App\Models\Admin\Sales\OrdersStatusHistoryModel;
use App\Models\Admin\Sales\PaymentsModel;

class OrdersCartController extends BaseController
{
    protected $cartsModel;
    protected $cartItemsModel;
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
    protected $taxClassesModel;

    public function __construct()
    {
        $this->cartsModel    = new OrdersCartsModel();
        $this->cartsItemsModel = new OrdersCartItemsModel();
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
        $this->taxClassesModel = new TaxClassesModel();
    }

    public function index()
    {
        $kpi = [
            'total_carts'       => $this->cartsModel->countAllResults(),
            'active_carts'      => (clone $this->cartsModel)->where('status', 'active')->countAllResults(true),
            'abandoned_carts'   => (clone $this->cartsModel)->where('status', 'abandoned')->countAllResults(true),
            'converted_carts'   => (clone $this->cartsModel)->where('status', 'converted')->countAllResults(true),
            'total_value'       => number_format((clone $this->cartsModel)
                ->selectSum('total_value')
                ->get()->getRow()->total_value ?? 0, 2, ',', ' '),
            'avg_cart_value'    => number_format((clone $this->cartsModel)
                ->selectAvg('total_value')
                ->get()->getRow()->total_value ?? 0, 2, ',', ' '),
            'avg_items'         => number_format((clone $this->cartsModel)
                ->selectAvg('total_items')
                ->get()->getRow()->total_items ?? 0, 0, ',', ' '),
            'new_30_days'       => (clone $this->cartsModel)
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
            'abandoned_30_days' => (clone $this->cartsModel)
                ->where('status', 'abandoned')
                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-30 days')))
                ->countAllResults(true),
        ];

        $customers    = $this->customerModel->findAll();
        $mapCustomers = array_column($customers, null, 'id');

        $carts = $this->cartsModel->orderBy('created_at', 'DESC')->findAll();
        foreach ($carts as &$c) {
            $c['customer'] = $mapCustomers[$c['customer_id']] ?? null;
        }

        return view('admin/sales/cart/index', [
            'carts' => $carts,
            'kpi'   => $kpi,
        ]);
    }

    public function edit($id = null)
    {
        if ($id === null) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Carrinho não encontrado');
        }

        $cart = $this->cartsModel->find($id);
        if (!$cart) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Carrinho #$id não encontrado");
        }

        // --- Cliente e grupo ---
        $cart['customer'] = $this->customerModel->find($cart['customer_id']);
        if (!empty($cart['customer']['group_id'])) {
            $group = $this->customerGroupModel->find($cart['customer']['group_id']);
            $cart['customer']['group_name'] = $group['name'] ?? '-';
        } else {
            $cart['customer']['group_name'] = '-';
        }

        // --- Moradas e métodos ---
        $cart['billing_address']  = $this->customerAddressModel->find($cart['billing_address_id'] ?? null);
        $cart['shipping_address'] = $this->customerAddressModel->find($cart['shipping_address_id'] ?? null);
        $cart['payment_method']   = $this->paymentMethodsModel->find($cart['payment_method_id'] ?? null);
        $cart['shipping_method']  = $this->shippingMethodsModel->find($cart['shipping_method_id'] ?? null);

        // --- Itens do carrinho ---
        $items = $this->cartsItemsModel
            ->where('cart_id', $id)
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
        $cart['items'] = $items;


        // --- Métodos disponíveis ---
        $paymentMethods  = $this->paymentMethodsModel->findAll();
        $shippingMethods = $this->shippingMethodsModel->findAll();

        // --- View ---
        return view('admin/sales/cart/edit', [
            'cart' => $cart,
            'paymentMethods' => $paymentMethods,
            'shippingMethods' => $shippingMethods,
        ]);
    }

    public function abandon()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do carrinho não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = (int) $data['id'];
        $cart = $this->cartsModel->find($id);
        if (! $cart) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Carrinho não encontrado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->cartsModel->update($id, ['status' => 'abandoned'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao marcar o carrinho como abandonado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Carrinho marcado como abandonado com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }

    public function delete()
    {
        $data = $this->request->getJSON(true);
        if (empty($data['id'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID do carrinho não enviado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        $id = (int) $data['id'];
        $cart = $this->cartsModel->find($id);
        if (! $cart) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Carrinho não encontrado.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        if (! $this->cartsModel->delete($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Erro ao eliminar o carrinho.',
                'csrf'    => [
                    'token' => csrf_token(),
                    'hash'  => csrf_hash(),
                ],
            ]);
        }
        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Carrinho eliminado com sucesso.',
            'csrf'    => [
                'token' => csrf_token(),
                'hash'  => csrf_hash(),
            ],
        ]);
    }


}
