<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\Website\HomeModel;
use App\Models\Website\BlockHomeNewsletterModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [
        'email',
        'company',
        'category'
    ];
    protected $cartItems = [];
    protected $cartTotals = [
        'total_items' => 0,
        'total_value' => 0,
    ];
    protected function loadCart(): void
    {
        $OrdersCartsModel = new \App\Models\Admin\Sales\OrdersCartsModel();
        $OrdersCartItemsModel = new \App\Models\Admin\Sales\OrdersCartItemsModel();
        $ProductsModel = new \App\Models\Admin\Catalog\ProductsModel();
        $ProductsVariantsModel = new \App\Models\Admin\Catalog\ProductsVariantsModel();

        $cart = $OrdersCartsModel
            ->where('session_id', session_id())
            ->where('status', 'active')
            ->first();

        if (!$cart) {
            return;
        }

        $items = $OrdersCartItemsModel
            ->where('cart_id', $cart['id'])
            ->where('removed_at', null)
            ->findAll();

        foreach ($items as $item) {
            $this->cartItems[] = [
                'item'    => $item,
                'product' => $ProductsModel->find($item['product_id']),
                'variant' => $item['variant_id']
                    ? $ProductsVariantsModel->find($item['variant_id'])
                    : null,
            ];
        }

        $this->cartTotals = [
            'total_items' => (int) $cart['total_items'],
            'total_value' => (float) $cart['total_value'],
        ];
    }


    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * @return void
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->session = service('session');

        // =====================
        // MENU / CATEGORIAS
        // =====================
        $menuModel = new \App\Models\Website\MenuModel();
        $menu = $menuModel->getMenuTree();

        $categoryModel = new \App\Models\Admin\Catalog\CategoriesModel();
        $categories = $categoryModel->findAll();

        // =====================
        // HOME / NEWSLETTER
        // =====================
        $homeModel = new HomeModel();
        $newsletterModel = new BlockHomeNewsletterModel();

        $home = $homeModel->where('is_active', 1)->first();
        $newsletter = null;

        if ($home) {
            $newsletter = $newsletterModel
                ->where('home_id', $home['id'])
                ->where('is_active', 1)
                ->first();
        }

        // =====================
        // CARRINHO (ISTO FALTAVA)
        // =====================
        $this->loadCart();

        // =====================
        // VARIÁVEIS GLOBAIS
        // =====================
        service('renderer')->setVar('items', $categories);
        service('renderer')->setVar('menu', $menu);
        service('renderer')->setVar('newsletter', $newsletter);

        // 👉 ESTAS DUAS LINHAS RESOLVEM TUDO
        service('renderer')->setVar('cartItems', $this->cartItems);
        service('renderer')->setVar('cartTotals', $this->cartTotals);
    }


}
