<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 // Rotas públicas
$routes->get('login', 'UsuarioController::login');
$routes->post('login', 'UsuarioController::doLogin');
$routes->get('logout', 'UsuarioController::logout');

$routes->get('/', 'Home::index');
 
 // Rotas protegidas
// $routes->group('/', ['filter' => 'auth'], function ($routes) {
$routes->group('/', function ($routes) {
    $routes->get('home', 'Site\Home::index');
    $routes->get('dashboard', 'Site\Home::index');

    // Rotas de configuração de usuários
    $routes->get('configuracao/usuarios', 'UsuarioController::index');
    $routes->get('configuracao/usuarios/new', 'UsuarioController::new');
    $routes->post('configuracao/usuarios/create', 'UsuarioController::create');

    // Rotas de Pessoas
    $routes->get('pessoas', 'PessoaController::index');
    $routes->get('pessoas/new', 'PessoaController::new');
    $routes->post('pessoas/create', 'PessoaController::create');

    // Rotas de Empresas
    $routes->get('empresas', 'EmpresaController::index');
    $routes->get('empresas/new', 'EmpresaController::new');
    $routes->post('empresas/create', 'EmpresaController::create');

    // Outras rotas protegidas...
    $routes->get('tools/build-assets', 'Tools\Assets::build');
    $routes->get('dev-tools', 'DevTools::index');
    $routes->get('dev-tools/build', 'DevTools::build');
    $routes->get('dev-tools/clear-cache', 'DevTools::clearCache');
    $routes->get('dev-tools/status', 'DevTools::status');
    $routes->get('/upload', 'Upload::index');
    $routes->post('/upload/do_upload', 'Upload::do_upload');
    $routes->post('/upload/do_upload_cert', 'Upload::do_upload_cert');
    $routes->get('/download/(:segment)/(:segment)/(:segment)/(:segment)', 'Upload::download/$1/$2/$3/$4');
    $routes->post('api/upload', 'Api\UploadController::upload');
    $routes->get('api/download', 'Api\UploadController::download');
});

