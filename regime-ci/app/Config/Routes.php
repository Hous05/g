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
