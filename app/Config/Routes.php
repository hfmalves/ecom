<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin\Auth\Auth::login', ['filter' => 'noauth']);

$routes->group('auth', ['namespace' => 'App\Controllers\Admin\Auth'], function ($routes) {
    $routes->get('/', 'Auth::login', ['filter' => 'noauth']);
    $routes->get('login', 'Auth::login', ['filter' => 'noauth']);
    $routes->post('login', 'Auth::attemptLogin', ['filter' => 'noauth']);
    $routes->post('verify2FA', 'Auth::verify2FA', ['filter' => 'noauth']);
    $routes->get('logout', 'Auth::logout', ['filter' => 'auth']);
    // Registo
    $routes->get('register', 'Register::index', ['filter' => 'noauth']);
    $routes->post('register', 'Register::attemptRegister', ['filter' => 'noauth']);
    // Recuperação
    $routes->get('recovery', 'ForgotPassword::index', ['filter' => 'noauth']);
    $routes->post('recovery', 'ForgotPassword::sendRecovery', ['filter' => 'noauth']);
    $routes->get('reset/(:segment)', 'ForgotPassword::reset/$1', ['filter' => 'noauth']);
    $routes->post('reset', 'ForgotPassword::attemptReset', ['filter' => 'noauth']);
});
