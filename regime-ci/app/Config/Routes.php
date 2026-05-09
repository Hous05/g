<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->match(['get', 'post'], 'register', 'Auth::registerStepOne');
$routes->match(['get', 'post'], 'register/health', 'Auth::registerStepTwo');
$routes->match(['get', 'post'], 'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->match(['get', 'post'], 'profile', 'Profile::edit');
$routes->match(['get', 'post'], 'objective', 'Program::objective');
$routes->match(['get', 'post'], 'program', 'Program::detail');
$routes->get('program/export', 'Program::export');
$routes->match(['get', 'post'], 'wallet', 'Wallet::index');
$routes->match(['get', 'post'], 'gold', 'Gold::index');
$routes->post('ajax/imc', 'Ajax::imc');
$routes->post('ajax/suggestions', 'Ajax::suggestions');
$routes->post('ajax/recharge', 'Ajax::recharge');
$routes->match(['get', 'post'], 'admin/login', 'Admin::login');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/dashboard', 'Admin::dashboard');

// Admin CRUD Routes
$routes->group('admin', static function ($routes) {
    // Régimes
    $routes->get('regimes', 'AdminRegimes::index');
    $routes->match(['get', 'post'], 'regimes/create', 'AdminRegimes::create');
    $routes->match(['get', 'post'], 'regimes/edit/(:num)', 'AdminRegimes::edit/$1');
    $routes->get('regimes/delete/(:num)', 'AdminRegimes::delete/$1');
    $routes->post('regimes/ajaxList', 'AdminRegimes::ajaxList');

    // Activités
    $routes->get('activities', 'AdminActivities::index');
    $routes->match(['get', 'post'], 'activities/create', 'AdminActivities::create');
    $routes->match(['get', 'post'], 'activities/edit/(:num)', 'AdminActivities::edit/$1');
    $routes->get('activities/delete/(:num)', 'AdminActivities::delete/$1');

    // Codes de recharge
    $routes->get('codes', 'AdminCodes::index');
    $routes->post('codes/generate', 'AdminCodes::generate');
    $routes->get('codes/delete/(:num)', 'AdminCodes::delete/$1');

    // Paramètres
    $routes->match(['get', 'post'], 'parameters', 'AdminParameters::index');
});
