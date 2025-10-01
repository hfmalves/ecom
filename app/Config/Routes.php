<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('/', ['namespace' => 'App\Controllers\Website'], function ($routes) {
    $routes->get('/', 'AuthController::login');
    $routes->get('shop', 'ShopController::index');
    $routes->get('product/(:segment)', 'ProductController::view/$1');
});
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->group('auth', ['namespace' => 'App\Controllers\Admin\Auth'], function ($routes) {
        $routes->get('login', 'AuthController::login', ['filter' => 'noauth']);
        $routes->post('login', 'AuthController::attemptLogin', ['filter' => 'noauth']);
        $routes->post('verify2FA', 'Auth::verify2FA', ['filter' => 'noauth']);
        $routes->get('register', 'RegisterController::index', ['filter' => 'noauth']);
        $routes->post('register', 'RegisterController::attemptRegister', ['filter' => 'noauth']);
        $routes->get('recovery', 'ForgotPasswordController::index', ['filter' => 'noauth']);
        $routes->post('recovery', 'ForgotPasswordController::sendRecovery', ['filter' => 'noauth']);
        $routes->get('reset/(:segment)', 'ForgotPasswordController::reset/$1', ['filter' => 'noauth']);
        $routes->post('reset', 'ForgotPasswordController::attemptReset', ['filter' => 'noauth']);
        $routes->get('logout', 'Auth::logoutController', ['filter' => 'auth']);
    });
    $routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
    $routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);
    $routes->group('catalog', ['namespace' => 'App\Controllers\Admin\Catalog'], function ($routes) {
        $routes->group('products', function ($routes) {
            $routes->get('/', 'ProductsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'ProductsController::store');
            $routes->get('edit/(:num)', 'ProductsController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'ProductsController::update');
        });
        $routes->group('categories', function ($routes) {
            $routes->get('/', 'CategoriesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CategoriesController::store');
            $routes->get('edit/(:num)', 'CategoriesController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'CategoriesController::update');

        });
        $routes->group('attributes', function ($routes) {
            $routes->get('/', 'AttributesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'AttributesController::store');
            $routes->get('edit/(:num)', 'AttributesController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'AttributesController::update');
            $routes->group('value', function ($routes) {
                $routes->post('store', 'AttributesController::storeValue');
                $routes->post('update', 'AttributesController::updateValue');
                $routes->post('update-order', 'AttributesController::updateValueOrder');
            });
        });
        $routes->group('suppliers', function ($routes) {
            $routes->get('/', 'SuppliersController::index', ['filter' => 'noauth']);
            $routes->post('store', 'SuppliersController::store');
            $routes->get('edit/(:num)', 'SuppliersController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'SuppliersController::update');
        });
        $routes->group('brands', function ($routes) {
            $routes->get('/', 'BrandsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'BrandsController::store');
            $routes->get('edit/(:num)', 'BrandsController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'BrandsController::update');
        });
    });
    $routes->group('customers', ['namespace' => 'App\Controllers\Admin\Customers'], function ($routes) {
        $routes->get('/', 'CustumersController::index', ['filter' => 'noauth']);
        $routes->get('edit/(:num)', 'CustumersController::edit/$1', ['filter' => 'noauth']);
        $routes->post('store', 'CustumersController::store');
        $routes->post('update', 'CustumersController::update');
        $routes->group('groups', function ($routes) {
            $routes->get('/', 'CustumersGroupsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CustumersGroupsController::store');
            $routes->get('edit/(:num)', 'CustumersGroupsController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'CustumersGroupsController::update');
            $routes->post('delete', 'CustumersGroupsController::delete');
        });
    });
    $routes->group('sales', ['namespace' => 'App\Controllers\Admin\Sales'], function ($routes) {
        $routes->group('orders', function ($routes) {
            $routes->get('/', 'OrdersController::index', ['filter' => 'noauth']);
            $routes->get('edit/(:num)', 'OrdersController::edit/$1', ['filter' => 'noauth']);
        });
        $routes->group('transactions', function ($routes) {
            $routes->get('/', 'PaymentsController::index', ['filter' => 'noauth']);
        });
        $routes->group('financial_documents', function ($routes) {
            $routes->get('/', 'FinancialDocumentsController::index', ['filter' => 'noauth']);
        });
        $routes->group('shipments', function ($routes) {
            $routes->get('/', 'OrdersShipmentsController::index', ['filter' => 'noauth']);
        });
        $routes->group('returns', function ($routes) {
            $routes->get('/', 'OrdersReturnController::index', ['filter' => 'noauth']);
        });
        $routes->group('cart', function ($routes) {
            $routes->get('/', 'OrdersCartController::index', ['filter' => 'noauth']);
        });
    });
    $routes->group('marketing', ['namespace' => 'App\Controllers\Admin\Marketing'], function ($routes) {
        $routes->group('coupons', function ($routes) {
            $routes->get('/', 'CouponsController::index', ['filter' => 'noauth']);
        });
        $routes->group('campaigns', function ($routes) {
            $routes->get('/', 'CampaignsController::index', ['filter' => 'noauth']);
        });
        $routes->group('catalog-rules', function ($routes) {
            $routes->get('/', 'PriceRulesCatalogController::index', ['filter' => 'noauth']);
        });
        $routes->group('cart-rules', function ($routes) {
            $routes->get('/', 'CartRulesController::index', ['filter' => 'noauth']);
        });
    });


});
