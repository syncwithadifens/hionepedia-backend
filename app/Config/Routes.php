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
$routes->get('/', 'Auth::index');
$routes->resource('animal');
$routes->post('animal/update/(:segment)', 'Animal::update/$1');

$routes->resource('api/animal', ['controller' => 'Api\Animal']);
$routes->post('api/animal/update/(:num)', 'Api\Animal::update/$1');

$routes->post('api/animal/(:num)/favorite', 'Api\Animal::addToFavorite/$1');
$routes->delete('api/favorite/(:num)', 'Api\Animal::removeFromFavorite/$1');
$routes->get('api/favorite', 'Api\Animal::getUserFavorite');

$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::doLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::doRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('user', 'Auth::getAllUser');
$routes->get('user/(:num)', 'Auth::delete/$1');

$routes->group('api', function ($routes) {
    $routes->post('login', 'Api\Auth::login');
    $routes->post('register', 'Api\Auth::register');
});

// $routes->get('animal/(:num)', 'Api\Animal::show/$1');
// $routes->delete('animal/(:num)', 'Api\Animal::delete/$1');
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
