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
            $routes->post('disable', 'ProductsController::disable');
            $routes->post('enabled', 'ProductsController::enabled');
            $routes->post('upload-image', 'ProductImagesController::upload');
            $routes->delete('delete-image/(:num)', 'ProductImagesController::delete/$1');
            $routes->post('reorder-images', 'ProductImagesController::reorder');
            $routes->group('variants', function ($routes) {
                $routes->post('create', 'ProductVariantsController::create', ['filter' => 'noauth']);
                $routes->get('edit/(:num)', 'ProductVariantsController::edit/$1', ['filter' => 'noauth']);
                $routes->post('update', 'ProductVariantsController::update');
                $routes->delete('delete/(:num)', 'ProductVariantsController::delete/$1');
            });
            $routes->group('packs', function ($routes) {
                $routes->get('items/(:num)', 'ProductsPackItemController::getPackItems/$1', ['filter' => 'noauth']);
                $routes->post('items/save/(:num)', 'ProductsPackItemController::savePackItems/$1', ['filter' => 'noauth']);
                $routes->post('items/update-qty/(:num)', 'ProductsPackItemController::updateQty/$1', ['filter' => 'noauth']);
                $routes->delete('items/delete/(:num)', 'ProductsPackItemController::deleteItem/$1', ['filter' => 'noauth']);
            });
            $routes->group('virtuals', function ($routes) {
                $routes->get('(:num)', 'ProductsVirtualController::show/$1', ['filter' => 'noauth']);
                $routes->post('save/(:num)', 'ProductsVirtualController::save/$1', ['filter' => 'noauth']);
                $routes->delete('delete/(:num)', 'ProductsVirtualController::delete/$1', ['filter' => 'noauth']);
                $routes->post('upload/(:num)', 'ProductsVirtualController::upload/$1', ['filter' => 'noauth']);
            });
        });
        $routes->group('categories', function ($routes) {
            $routes->get('/', 'CategoriesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CategoriesController::store');
            $routes->get('edit/(:num)', 'CategoriesController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'CategoriesController::update');
            $routes->post('reorder', 'CategoriesController::reorder');
            $routes->post('disable', 'CategoriesController::disable');
            $routes->post('enabled', 'CategoriesController::enabled');
            $routes->post('upload-image', 'CategoriesController::uploadImage');

        });
        $routes->group('attributes', function ($routes) {
            $routes->get('/', 'AttributesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'AttributesController::store');
            $routes->get('edit/(:num)', 'AttributesController::edit/$1', ['filter' => 'noauth']);
            $routes->post('update', 'AttributesController::update');
            $routes->group('value', function ($routes) {
                $routes->post('store', 'AttributesController::storeValue');
                $routes->post('update', 'AttributesController::updateValue');
                $routes->post('delete', 'AttributesController::deleteValue');
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
        $routes->post('deactivate', 'CustumersController::deactivate');
        $routes->post('delete', 'CustumersController::delete');
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
    $routes->group('reports', function ($routes) {
        $routes->group('sales', ['namespace' => 'App\Controllers\Admin\Reports\Sales'], function ($routes) {
            $routes->get('/', 'SalesController::index', ['filter' => 'noauth']);
        });
        $routes->group('products', ['namespace' => 'App\Controllers\Admin\Reports\Products'], function ($routes) {
            $routes->get('/', 'ProductsController::index', ['filter' => 'noauth']);
        });
        $routes->group('customers', ['namespace' => 'App\Controllers\Admin\Reports\Customers'], function ($routes) {
            $routes->get('/', 'CustomersController::index', ['filter' => 'noauth']);
        });
        $routes->group('carts', ['namespace' => 'App\Controllers\Admin\Reports\Carts'], function ($routes) {
            $routes->get('/', 'CartsController::index', ['filter' => 'noauth']);
        });
        $routes->group('marketing', ['namespace' => 'App\Controllers\Admin\Reports\Marketing'], function ($routes) {
            $routes->get('/', 'MarketingController::index', ['filter' => 'noauth']);
        });
        $routes->group('finance', ['namespace' => 'App\Controllers\Admin\Reports\Finance'], function ($routes) {
            $routes->get('/', 'FinanceController::index', ['filter' => 'noauth']);
        });
        $routes->group('shipping', ['namespace' => 'App\Controllers\Admin\Reports\Shipping'], function ($routes) {
            $routes->get('/', 'ShippingController::index', ['filter' => 'noauth']);
        });
        $routes->group('payments', ['namespace' => 'App\Controllers\Admin\Reports\Payments'], function ($routes) {
            $routes->get('/', 'PaymentsController::index', ['filter' => 'noauth']);
        });
        $routes->group('inventory', ['namespace' => 'App\Controllers\Admin\Reports\Inventory'], function ($routes) {
            $routes->get('/', 'InventoryController::index', ['filter' => 'noauth']);
        });
        $routes->group('geography', ['namespace' => 'App\Controllers\Admin\Reports\Geography'], function ($routes) {
            $routes->get('/', 'GeographyController::index', ['filter' => 'noauth']);
        });
        $routes->group('coupons', ['namespace' => 'App\Controllers\Admin\Reports\Coupons'], function ($routes) {
            $routes->get('/', 'CouponsController::index', ['filter' => 'noauth']);
        });
    });
    $routes->group('settings', function ($routes) {
        $routes->group('general', ['namespace' => 'App\Controllers\Admin\Configurations\General'], function ($routes) {
            $routes->get('/', 'GeneralController::index', ['filter' => 'noauth']);
            $routes->post('update', 'GeneralController::update');
        });
        $routes->group('taxes', ['namespace' => 'App\Controllers\Admin\Configurations\Taxes'], function ($routes) {
            $routes->get('/', 'TaxesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'TaxesController::store');
            $routes->post('update', 'TaxesController::update');
            $routes->post('delete', 'TaxesController::delete');
        });
        $routes->group('payments', ['namespace' => 'App\Controllers\Admin\Configurations\Payments'], function ($routes) {
            $routes->get('/', 'PaymentsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'PaymentsController::store');
            $routes->post('update', 'PaymentsController::update');
            $routes->post('delete', 'PaymentsController::delete');
        });
        $routes->group('shipping', ['namespace' => 'App\Controllers\Admin\Configurations\Shipping'], function ($routes) {
            $routes->get('/', 'ShippingController::index', ['filter' => 'noauth']);
            $routes->post('store', 'ShippingController::store');
            $routes->post('update', 'ShippingController::update');
            $routes->post('delete', 'ShippingController::delete');
        });
        $routes->group('currencies', ['namespace' => 'App\Controllers\Admin\Configurations\Currencies'], function ($routes) {
            $routes->get('/', 'CurrenciesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CurrenciesController::store');
            $routes->post('update', 'CurrenciesController::update');
            $routes->post('delete', 'CurrenciesController::delete');
        });
        $routes->group('users', ['namespace' => 'App\Controllers\Admin\Configurations\Users'], function ($routes) {
            $routes->get('/', 'UsersController::index', ['filter' => 'noauth']);
        });
        $routes->group('integrations', ['namespace' => 'App\Controllers\Admin\Configurations\Integrations'], function ($routes) {
            $routes->get('/', 'IntegrationsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'IntegrationsController::store');
            $routes->post('update', 'IntegrationsController::update');
            $routes->post('delete', 'IntegrationsController::delete');
        });
        $routes->group('notifications', ['namespace' => 'App\Controllers\Admin\Configurations\Notifications'], function ($routes) {
            $routes->get('/', 'NotificationsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'NotificationsController::store');
            $routes->post('update', 'NotificationsController::update');
            $routes->post('delete', 'NotificationsController::delete');
        });
        $routes->group('catalog', ['namespace' => 'App\Controllers\Admin\Configurations\Catalog'], function ($routes) {
            $routes->get('/', 'CatalogController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CatalogController::store');
            $routes->post('update', 'CatalogController::update');
            $routes->post('delete', 'CatalogController::delete');
        });
        $routes->group('customers', ['namespace' => 'App\Controllers\Admin\Configurations\Customers'], function ($routes) {
            $routes->get('/', 'CustomersController::index', ['filter' => 'noauth']);
        });
        $routes->group('emails', ['namespace' => 'App\Controllers\Admin\Configurations\Emails'], function ($routes) {
            $routes->get('/', 'EmailsController::index', ['filter' => 'noauth']);
            $routes->post('store', 'EmailsController::store');
            $routes->post('update', 'EmailsController::update');
            $routes->post('delete', 'EmailsController::delete');
        });
        $routes->group('seo', ['namespace' => 'App\Controllers\Admin\Configurations\Seo'], function ($routes) {
            $routes->get('/', 'SeoController::index', ['filter' => 'noauth']);
            $routes->post('update', 'SeoController::update', ['filter' => 'noauth']);
        });
        $routes->group('security', ['namespace' => 'App\Controllers\Admin\Configurations\Security'], function ($routes) {
            $routes->get('/', 'SecurityController::index', ['filter' => 'noauth']);
            $routes->post('update', 'SecurityController::update', ['filter' => 'noauth']);
        });

        $routes->group('languages', ['namespace' => 'App\Controllers\Admin\Configurations\Languages'], function ($routes) {
            // Página de listagem de idiomas
            $routes->get('/', 'LanguagesController::index', ['filter' => 'noauth']);
            $routes->post('store', 'LanguagesController::store');
            $routes->post('update', 'LanguagesController::update');
            $routes->post('delete', 'LanguagesController::delete');
        });
        $routes->group('cache', ['namespace' => 'App\Controllers\Admin\Configurations\Cache'], function ($routes) {
            $routes->get('/', 'CacheController::index', ['filter' => 'noauth']);
            $routes->post('store', 'CacheController::store');
            $routes->post('update', 'CacheController::update');
            $routes->post('delete', 'CacheController::delete');
        });
        $routes->group('system', ['namespace' => 'App\Controllers\Admin\Configurations\System'], function ($routes) {
            $routes->get('/', 'SystemController::index', ['filter' => 'noauth']);
        });
        $routes->group('legal', ['namespace' => 'App\Controllers\Admin\Configurations\Legal'], function ($routes) {
            $routes->get('/', 'LegalController::index', ['filter' => 'noauth']);
        });
    });
});
