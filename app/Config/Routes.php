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
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    // Auth (GET mostra view, POST processa)
    $routes->match(['get','post'], 'auth/login', 'Auth\Auth::login', ['filter' => 'noauth']);
    $routes->match(['get','post'], 'auth/register', 'Auth\Register::index', ['filter' => 'noauth']);
    $routes->match(['get','post'], 'auth/recovery', 'Auth\ForgotPassword::index', ['filter' => 'noauth']);
    $routes->match(['get','post'], 'auth/reset/(:segment)', 'Auth\ForgotPassword::reset/$1', ['filter' => 'noauth']);
    $routes->get('auth/logout', 'Auth\Auth::logout', ['filter' => 'auth']);

    // Dashboard
    $routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
    $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);
});
