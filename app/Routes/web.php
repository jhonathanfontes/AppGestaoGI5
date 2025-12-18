<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes
$routes->get('login', 'UsuarioController::login');
$routes->post('login', 'UsuarioController::doLogin');
$routes->get('logout', 'UsuarioController::logout');

$routes->get('/', 'Home::index');

// Protected Routes
// $routes->group('/', ['filter' => 'auth'], function ($routes) {
$routes->group('/', function ($routes) {
    $routes->get('home', 'Site\Home::index');
    $routes->get('dashboard', 'Site\Home::index');

    // User configuration routes
    $routes->get('configuracao/usuarios', 'UsuarioController::index');
    $routes->get('configuracao/usuarios/new', 'UsuarioController::new');
    $routes->post('configuracao/usuarios/create', 'UsuarioController::create');

    // People routes
    $routes->get('pessoas', 'PessoaController::index');
    $routes->get('pessoas/new', 'PessoaController::new');
    $routes->post('pessoas/create', 'PessoaController::create');

    // Company routes
    $routes->get('empresas', 'EmpresaController::index');
    $routes->get('empresas/new', 'EmpresaController::new');
    $routes->post('empresas/create', 'EmpresaController::create');

    // Other protected routes...
    $routes->get('tools/build-assets', 'Tools\Assets::build');
    $routes->get('dev-tools', 'DevTools::index');
    $routes->get('dev-tools/build', 'DevTools::build');
    $routes->get('dev-tools/clear-cache', 'DevTools::clearCache');
    $routes->get('dev-tools/status', 'DevTools::status');
    $routes->get('/upload', 'Upload::index');
    $routes->post('/upload/do_upload', 'Upload::do_upload');
    $routes->post('/upload/do_upload_cert', 'Upload::do_upload_cert');
    $routes->get('/download/(:segment)/(:segment)/(:segment)/(:segment)', 'Upload::download/$1/$2/$3/$4');
});
