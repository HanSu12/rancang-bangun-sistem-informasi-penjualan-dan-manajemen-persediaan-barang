<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');

// Auth routes
$routes->get('login', 'Auth::index');
$routes->post('login_process', 'Auth::login_process');
$routes->get('logout', 'Auth::logout');

// Barang routes
$routes->get('barang', 'Barang::index');
$routes->post('barang/create', 'Barang::create');
$routes->post('barang/update/(:num)', 'Barang::update/$1');
$routes->post('barang/delete/(:num)', 'Barang::delete/$1');

// Kategori routes
$routes->get('kategori', 'Kategori::index');
$routes->post('kategori/create', 'Kategori::create');
$routes->post('kategori/update/(:num)', 'Kategori::update/$1');
$routes->post('kategori/delete/(:num)', 'Kategori::delete/$1');

// Supplier routes
$routes->get('supplier', 'Supplier::index');
$routes->post('supplier/create', 'Supplier::create');
$routes->post('supplier/update/(:num)', 'Supplier::update/$1');
$routes->post('supplier/delete/(:num)', 'Supplier::delete/$1');

// Users routes
$routes->get('users', 'Users::index');
$routes->post('users/create', 'Users::create');
$routes->post('users/update/(:num)', 'Users::update/$1');
$routes->post('users/delete/(:num)', 'Users::delete/$1');
