<?php

namespace App\Controllers\Website;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Admin\Sales\OrdersCartsModel;
use App\Models\Admin\Sales\OrdersCartItemsModel;
use App\Models\Admin\Catalog\ProductsModel;
use App\Models\Admin\Catalog\ProductsVariantsModel;
use App\Models\Admin\Marketing\CartRuleCouponModel;
use App\Models\Admin\Marketing\CartRuleModel;


class CartController extends BaseController
{
    protected $OrdersCartsModel;
    protected $OrdersCartItemsModel;
    protected $ProductsModel;
    protected $ProductsVariantsModel;
    protected $CartRuleModel;
    protected $CartRuleCouponModel;

    public function __construct()
    {
        $this->OrdersCartsModel = new OrdersCartsModel();
        $this->OrdersCartItemsModel = new OrdersCartItemsModel();
        $this->ProductsModel = new ProductsModel();
        $this->ProductsVariantsModel = new ProductsVariantsModel();
        $this->CartRuleModel = new CartRuleModel();
        $this->CartRuleCouponModel = new CartRuleCouponModel();
    }
    public function cart()
    {
        $data = $this->getCartData();

        return view('website/cart/cart', $data);
    }
    public function checkout()
    {
        return view('website/cart/checkout');
    }
    public function complete()
    {
        return view('website/cart/complete');
    }
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
        $qty       = (int) $data['quantity'];

        // 🔒 NORMALIZAÇÃO CORRETA DO variant_id
        $variantId = null;
        if (
            array_key_exists('variant_id', $data) &&
            $data['variant_id'] !== null &&
            $data['variant_id'] !== '' &&
            $data['variant_id'] !== 'null'
        ) {
            $variantId = (int) $data['variant_id'];
        }

        $cart = $this->OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return $this->response->setStatusCode(404);
        }

        // 🔥 QUERY CORRETA (NULL vs =)
        $query = $this->OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->where('removed_at', null);

        if ($variantId === null) {
            $query->where('variant_id IS NULL', null, false);
        } else {
            $query->where('variant_id', $variantId);
        }

        $item = $query->first();

        if (!$item) {
            return $this->response->setStatusCode(404);
        }

        // =====================
        // UPDATE
        // =====================
        if ($qty <= 0) {
            // soft delete (como já tinhas definido)
            $this->OrdersCartItemsModel->update($item['id'], [
                'removed_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->OrdersCartItemsModel->update($item['id'], [
                'qty'      => $qty,
                'price'    => $item['price'],
                'discount' => $item['discount'],
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
        log_message('debug', 'CART REMOVE REQUEST', [
            'payload' => $data,
        ]);
        if (!isset($data['product_id'])) {
            return $this->response->setStatusCode(400);
        }

        $productId = (int) $data['product_id'];

        $variantId = null;
        if (
            array_key_exists('variant_id', $data) &&
            $data['variant_id'] !== null &&
            $data['variant_id'] !== 'null'
        ) {
            $variantId = (int) $data['variant_id'];
        }

        $cart = $this->OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return $this->response->setStatusCode(404);
        }

        $query = $this->OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId);

        if ($variantId === null) {
            $query->where('variant_id IS NULL', null, false);
        } else {
            $query->where('variant_id', $variantId);
        }
        $query->delete();
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
    public function drawer()
    {
        $data = $this->getCartData();

        return view('layout/partials_website/cart_drawer_content', $data);
    }

    private function getCartData(): array
    {
        $sessionId = session_id();

        $cart = $this->OrdersCartsModel
            ->where('session_id', $sessionId)
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return [
                'cartItems' => [],
                'cartTotals' => [
                    'total_items' => 0,
                    'total_value' => 0,
                ]
            ];
        }

        $items = $this->OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('removed_at', null)
            ->findAll();

        $cartItems = [];

        foreach ($items as $item) {
            $cartItems[] = [
                'item'    => $item,
                'product' => $this->ProductsModel->find($item['product_id']),
                'variant' => $item['variant_id']
                    ? $this->ProductsVariantsModel->find($item['variant_id'])
                    : null,
            ];
        }

        return [
            'cartItems' => $cartItems,
            'cartTotals' => [
                'total_items' => (int) $cart['total_items'],
                'total_value' => (float) $cart['total_value'],
            ],
            'coupon' => session('coupon')
        ];
    }

    public function cartContent()
    {
        $data = $this->getCartData();
        return view('layout/partials_website/cart_content', $data);
    }



    public function coupon()
    {
        $data = $this->request->getJSON(true);
        $code = strtoupper(trim($data['code'] ?? ''));

        if ($code === '') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Código inválido'
            ]);
        }

        // Cupão
        $coupon = $this->CartRuleCouponModel
            ->where('code', $code)
            ->where('include', 1)
            ->first();

        if (!$coupon) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cupão não existe'
            ]);
        }

        // Regra associada
        $rule = $this->CartRuleModel->find($coupon['rule_id']);

        if (!$rule) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Regra inválida'
            ]);
        }

        // Validade temporal
        $now = date('Y-m-d H:i:s');
        if ($now < $rule['start_date'] || $now > $rule['end_date']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cupão expirado'
            ]);
        }

        // Limite de utilização
        if (
            (int)$coupon['uses_per_coupon'] > 0 &&
            (int)$coupon['times_used'] >= (int)$coupon['uses_per_coupon']
        ) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Cupão esgotado'
            ]);
        }

        // Guardar na sessão
        session()->set('coupon', [
            'code'           => $coupon['code'],
            'rule_id'        => $rule['id'],
            'discount_type'  => $rule['discount_type'],
            'discount_value' => $rule['discount_value'],
            'conditions'     => json_decode($rule['condition_json'], true)
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Cupão aplicado com sucesso'
        ]);
    }


}
