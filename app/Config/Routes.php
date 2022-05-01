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
$routes->setDefaultNamespace('App\Controllers\Blog');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->group('/', ['namespace' => 'App\Controllers\Blog'], function($routes) {
	$routes->get('', 'Home::index', ['as' => 'page.index']);
	// El parametro que recibe esta ruta es el slug del post a proyectar
	$routes->get('post/(:segment)', 'Home::post/$1', ['as' => 'posts.show']);
	
});

$routes->group('auth', ['namespace' => 'App\Controllers\Auth'], function($routes) {
	$routes->get('register', 'RegisterController::register', ['as' => 'auth.register']);
	$routes->post('register', 'RegisterController::store', ['as' => 'auth.store']);
	$routes->get('login', 'LoginController::login', ['as' => 'auth.login']);
	$routes->post('signin', 'LoginController::signin', ['as' => 'auth.signin']);
	$routes->get('signout', 'LoginController::signout', ['as' => 'auth.signout']);
});

// Todas estas rutas deben pasar el filtro de autenticación. Se pueden pasar argumentos a estos filtros :arg1,arg2
$routes->group('admin', ['namespace' => 'App\Controllers\Admin', 'filter' => 'auth:Administrador'], function($routes) {
	$routes->get('posts', 'PostController::index', ['as' => 'posts.index']);
	$routes->get('posts/create', 'PostController::create', ['as' => 'posts.create']);
	$routes->post('posts/store', 'PostController::store', ['as' => 'posts.store']);

	$routes->get('categories', 'CategoryController::index', ['as' => 'categories.index']);
	$routes->get('categories/create', 'CategoryController::create', ['as' => 'categories.create']);
	$routes->post('categories/store', 'CategoryController::store', ['as' => 'categories.store']);
	$routes->get('categories/edit/(:segment)', 'CategoryController::edit/$1', ['as' => 'categories.edit']);
	$routes->post('categories/update/(:segment)', 'CategoryController::update/$1', ['as' => 'categories.update']);
	$routes->get('categories/destroy/(:segment)', 'CategoryController::destroy/$1', ['as' => 'categories.destroy']);
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
