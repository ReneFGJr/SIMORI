<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/repositorios', 'Repositorios::index');
$routes->get('/repositorios/view/(:num)', 'Repositorios::views/$1');
$routes->get('/repositorios/create', 'Repositorios::create');
$routes->get('/repositorios/edit/(:num)', 'Repositorios::edit/$1');
$routes->get('/repositorios/copy/(:num)', 'Repositorios::copy/$1');
$routes->get('/repositorios/delete/(:num)', 'Repositorios::delete/$1');


$routes->get('/', 'Home::index');
