<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Website
$routes->group('/', ['namespace' => 'App\Controllers\Website'], function ($routes) {
    $routes->get('/', 'Home::index');
    $routes->get('shop', 'Shop::index');
    $routes->get('product/(:segment)', 'Product::view/$1');
});

// Admin / Backoffice
// Admin / Backoffice
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {

    // Auth
    $routes->group('auth', ['namespace' => 'App\Controllers\Admin\Auth'], function ($routes) {
        $routes->get('login', 'Auth::login', ['filter' => 'noauth']);
        $routes->post('login', 'Auth::attemptLogin', ['filter' => 'noauth']);

        $routes->get('register', 'Register::index', ['filter' => 'noauth']);
        $routes->post('register', 'Register::attemptRegister', ['filter' => 'noauth']);

        $routes->get('recovery', 'ForgotPassword::index', ['filter' => 'noauth']);
        $routes->post('recovery', 'ForgotPassword::sendRecovery', ['filter' => 'noauth']);

        $routes->get('reset/(:segment)', 'ForgotPassword::reset/$1', ['filter' => 'noauth']);
        $routes->post('reset', 'ForgotPassword::attemptReset', ['filter' => 'noauth']);

        $routes->get('logout', 'Auth::logout', ['filter' => 'auth']);
    });

    // Dashboard
    $routes->get('/', 'Dashboard::index', ['filter' => 'auth']);            // /admin
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);    // /admin/dashboard
});
