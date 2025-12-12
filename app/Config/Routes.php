<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/dashboard', 'Site\Home::index');


// Configurações de rotas adicionais podem ser adicionadas aqui
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

