<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Web Auth Routes
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::doRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('user', 'Auth::getAllUser');
$routes->get('user/(:num)/edit', 'Auth::edit/$1');
$routes->put('user/(:num)', 'Auth::update/$1');
$routes->delete('user/(:num)', 'Auth::delete/$1');

// Web Animal Routes
$routes->resource('animal', ['controller' => 'Animal']);

// API Auth Routes
$routes->group('api', function ($routes) {
    $routes->post('login', 'Api\Auth::login');
    $routes->post('register', 'Api\Auth::register');
});

// API Animal Routes
$routes->resource('api/animal', ['controller' => 'Api\Animal', 'except' => 'update']);
$routes->group('api', function ($routes) {
    $routes->post('animal/update/(:num)', 'Api\Animal::update/$1');
    $routes->post('animal/(:num)/favorite', 'Api\Animal::addToFavorite/$1');
    $routes->delete('favorite/(:num)', 'Api\Animal::removeFromFavorite/$1');
    $routes->get('favorite', 'Api\Animal::getUserFavorite');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
