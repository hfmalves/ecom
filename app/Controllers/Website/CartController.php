<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Sales\OrdersCartsModel;
use App\Models\Admin\Sales\OrdersCartItemsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;


class CartController extends BaseController
{
    protected $OrdersCartsModel;
    protected $OrdersCartItemsModel;
    protected $ProductsModel;
    protected $ProductsVariantsModel;

    public function __construct()
    {
        $this->OrdersCartsModel = new OrdersCartsModel();
        $this->OrdersCartItemsModel = new OrdersCartItemsModel();
        $this->ProductsModel = new ProductsModel();
        $this->ProductsVariantsModel = new ProductsVariantsModel();
    }
    public function cart()
    {
        return view('website/cart/cart');
    }

    public function checkout()
    {
        return view('website/cart/checkout');
    }

    public function complete()
    {
        return view('website/cart/complete');
    }
    // =====================
    // ACTIONS (AJAX)
    // =====================

    public function add(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        // validação base
        if (
            !isset($data['quantity']) ||
            (!isset($data['product_id']) && !isset($data['variant_id']))
        ) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Dados inválidos'
            ])->setStatusCode(400);
        }

        $qty       = (int) $data['quantity'];
        $variantId = isset($data['variant_id']) ? (int) $data['variant_id'] : null;
        $productId = isset($data['product_id']) ? (int) $data['product_id'] : null;

        $sessionId = session_id();
        $now       = date('Y-m-d H:i:s');

        // =====================
        // VARIANTE (CONFIGURABLE)
        // =====================
        if ($variantId) {
            $variant = $this->ProductsVariantsModel
                ->where('id', $variantId)
                ->where('status', '1')
                ->first();

            if (!$variant) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Variante inválida'
                ])->setStatusCode(404);
            }

            // produto pai vem da variante
            $productId = (int) $variant['product_id'];

            $basePrice = (float) $variant['base_price_tax'];
            $price = (
                $variant['special_price'] > 0 &&
                (!$variant['special_price_start'] || $variant['special_price_start'] <= $now) &&
                (!$variant['special_price_end']   || $variant['special_price_end']   >= $now)
            )
                ? (float) $variant['special_price']
                : $basePrice;

        }
        // =====================
        // PRODUTO SIMPLES
        // =====================
        else {
            $product = $this->ProductsModel
                ->where('id', $productId)
                ->where('status', 'active')
                ->first();

            if (!$product) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Produto inválido'
                ])->setStatusCode(404);
            }

            $basePrice = (float) $product['base_price_tax'];
            $price = (
                $product['special_price'] > 0 &&
                (!$product['special_price_start'] || $product['special_price_start'] <= $now) &&
                (!$product['special_price_end']   || $product['special_price_end']   >= $now)
            )
                ? (float) $product['special_price']
                : $basePrice;
        }

        $discount = ($price < $basePrice) ? ($basePrice - $price) : 0.0;

        // =====================
        // CARRINHO
        // =====================
        $cart = $this->OrdersCartsModel
            ->where('session_id', $sessionId)
            ->where('status', 'active')
            ->first();

        $cartId = $cart
            ? (int) $cart['id']
            : $this->OrdersCartsModel->insert([
                'session_id'  => $sessionId,
                'status'      => 'active',
                'total_items' => 0,
                'total_value' => 0
            ]);

        // =====================
        // ITEM
        // =====================
        $item = $this->OrdersCartItemsModel
            ->where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->where('removed_at', null)
            ->first();

        if ($item) {
            $newQty = $item['qty'] + $qty;

            $this->OrdersCartItemsModel->update($item['id'], [
                'qty'      => $newQty,
                'price'    => $price,
                'discount' => $discount,
                'subtotal' => $price * $newQty
            ]);
        } else {
            $this->OrdersCartItemsModel->insert([
                'cart_id'    => $cartId,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'qty'        => $qty,
                'price'      => $price,
                'discount'   => $discount,
                'subtotal'   => $price * $qty
            ]);
        }

        $this->recalculateCart($cartId);

        return $this->response->setJSON([
            'success' => true,
            'cart'    => $this->cartSummary($cartId)
        ]);
    }



    public function update(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['product_id'], $data['quantity'])) {
            return $this->response->setStatusCode(400);
        }

        $productId = (int) $data['product_id'];
        $variantId = isset($data['variant_id']) ? (int) $data['variant_id'] : null;
        $qty       = (int) $data['quantity'];

        $cart = $this->OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return $this->response->setStatusCode(404);
        }

        $item = $this->OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->where('removed_at', null)
            ->first();

        if (!$item) {
            return $this->response->setStatusCode(404);
        }

        if ($qty <= 0) {
            $this->OrdersCartItemsModel->update($item['id'], [
                'removed_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->OrdersCartItemsModel->update($item['id'], [
                'qty'      => $qty,
                'price'    => $item['price'],      // preço não muda
                'discount' => $item['discount'],   // desconto mantém
                'subtotal' => $item['price'] * $qty
            ]);
        }

        $this->recalculateCart($cart['id']);

        return $this->response->setJSON([
            'success' => true,
            'cart'    => $this->cartSummary($cart['id'])
        ]);
    }


    public function remove(): ResponseInterface
    {
        $data = $this->request->getJSON(true);

        if (!isset($data['product_id'])) {
            return $this->response->setStatusCode(400);
        }

        $productId = (int) $data['product_id'];
        $variantId = isset($data['variant_id']) ? (int) $data['variant_id'] : null;

        $cart = $this->OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return $this->response->setStatusCode(404);
        }

        $this->OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->where('removed_at', null)
            ->set(['removed_at' => date('Y-m-d H:i:s')])
            ->update();

        $this->recalculateCart($cart['id']);

        return $this->response->setJSON([
            'success' => true,
            'cart'    => $this->cartSummary($cart['id'])
        ]);
    }

    public function clear(): ResponseInterface
    {
        $cart = $this->OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if ($cart) {
            $this->OrdersCartItemsModel
                ->where('cart_id', $cart['id'])
                ->where('removed_at', null)
                ->set(['removed_at' => date('Y-m-d H:i:s')])
                ->update();

            $this->OrdersCartsModel->update($cart['id'], [
                'total_items' => 0,
                'total_value' => 0
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'cart'    => $cart ? $this->cartSummary($cart['id']) : ['total_items' => 0, 'total_value' => 0]
        ]);
    }

    private function recalculateCart(int $cartId): void
    {
        $totals = $this->OrdersCartItemsModel
            ->select('SUM(qty) as total_items, SUM(subtotal) as total_value')
            ->where('cart_id', $cartId)
            ->where('removed_at', null)
            ->first();

        $this->OrdersCartsModel->update($cartId, [
            'total_items' => (int) ($totals['total_items'] ?? 0),
            'total_value' => (float) ($totals['total_value'] ?? 0),
        ]);
    }

    private function cartSummary(int $cartId): array
    {
        $cart = $this->OrdersCartsModel->find($cartId);

        return [
            'total_items' => (int) $cart['total_items'],
            'total_value' => (float) $cart['total_value'],
        ];
    }



}
