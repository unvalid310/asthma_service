<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 ** --------------------------------------------------------------------
 ** Router Setup
 ** --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
// $routes->setDefaultController('Auth');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

// $routes->get('/', 'Auth::index');

$routes->post('api/auth/login', 'Api\AuthController::login');
$routes->post('api/auth/register', 'Api\AuthController::register');
$routes->get('api/profile', 'Api\UserController::index');
$routes->post('api/profile/update/(:num)', 'Api\UserController::update/$1');
$routes->get('api/analize', 'Api\AnalizeController::index');

$routes->get('api/analize/body', 'Api\AnalizeController::body');
$routes->post('api/analize/body/create', 'Api\AnalizeController::postBody');
$routes->post('api/analize/body/update/(:num)', 'Api\AnalizeController::updateBody/$1');

$routes->get('api/analize/envi', 'Api\AnalizeController::envi');
$routes->post('api/analize/envi/create', 'Api\AnalizeController::postEnvi');
$routes->post('api/analize/envi/update/(:num)', 'Api\AnalizeController::updateEnvi/$1');

$routes->get('api/analize/mind', 'Api\AnalizeController::mind');
$routes->post('api/analize/mind/create', 'Api\AnalizeController::postMind');
$routes->post('api/analize/mind/update/(:num)', 'Api\AnalizeController::updateMind/$1');

$routes->get('api/result', 'Api\ResultController::index');
$routes->get('api/result/history', 'Api\ResultController::history');

if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
