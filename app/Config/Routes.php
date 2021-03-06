<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
//login routes
$routes->get('/login', 'Login::index');
$routes->get('/log', 'Login::check');
$routes->post('/log', 'Login::check');
$routes->get('/logout', 'Login::logout');
$routes->post('/create-account', 'Login::createAccount');

//autres routes
$routes->get('/catalogue', 'Catalogue::index');
$routes->post('/add-panier', 'Catalogue::addPanier');

$routes->get('/panier', 'Panier::index');
$routes->post('/delete-article', 'Panier::deleteArticle');
$routes->post('/change-quantity(:num)', 'Panier::changeQuantity/$1');

$routes->get('/commande', 'Commande::index');
$routes->get('/commandeDetail(:num)', 'CommandeDetail::index/$1');
$routes->get('/checkout', 'Panier::checkout');
$routes->get('/my-account', 'MyAccount::index');
$routes->post('/update-account', 'MyAccount::updateAccount');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
