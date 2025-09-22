<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Website
$routes->group('/', ['namespace' => 'App\Controllers\Website'], function ($routes) {
    $routes->get('/', 'HomeController::index');
    $routes->get('shop', 'ShopController::index');
    $routes->get('product/(:segment)', 'ProductController::view/$1');
});

// Admin / Backoffice
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // Auth
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

    // Dashboard
    $routes->get('/', 'Dashboard::index', ['filter' => 'auth']);            // /admin
    $routes->get('dashboard', 'DashboardController::index', ['filter' => 'auth']);    // /admin/dashboard

    // Products
    $routes->group('catalog', ['namespace' => 'App\Controllers\Admin\Catalog'], function ($routes) {
        $routes->get('products', 'ProductsController::index', ['filter' => 'noauth']);
        $routes->get('products/edit/(:num)', 'ProductsController::edit/$1', ['filter' => 'noauth']);
        $routes->post('products/update', 'ProductsController::update');
    });

});
