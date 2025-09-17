<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'Home::index');
// Routes for Shop Controller
$routes->get('shop', 'Shop::index');
$routes->get('shop/addToCart/(:num)', 'Shop::addToCart/$1');
$routes->get('shop/cart', 'Shop::cart');
$routes->post('shop/processCheckout', 'Shop::processCheckout');
$routes->post('shop/updateCartQuantity', 'Shop::updateCartQuantity');
$routes->get('shop/checkout', 'Shop::checkout');

// Routes untuk tambah barang
$routes->get('shop/add', 'Shop::add');
$routes->post('shop/store', 'Shop::store');


return $routes;