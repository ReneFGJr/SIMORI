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

$routes->get('/repository', 'Repository::index');
$routes->get('/repository/create', 'Repository::create');
$routes->post('/repository/store', 'Repository::store');
$routes->get('/repository/edit/(:num)', 'Repository::edit/$1');
$routes->post('/repository/update/(:num)', 'Repository::update/$1');
$routes->get('/repository/delete/(:num)', 'Repository::delete/$1');
$routes->get('/repository/show/(:num)', 'Repository::show/$1');
$routes->get('/repository/analyse/(:num)', 'Repository::analyse/$1');
$routes->get('/repository/harvesting/(:num)', 'Repository::harvesting/$1');
$routes->get('/repository/url_check', 'Repository::url_check');
$routes->get('/oai/identify/(:num)', 'Repositorios::harvesting/$1');
$routes->get('/oai/sets/(:num)', 'Repositorios::harvesting_sets/$1');
$routes->get('/oai/register/(:num)', 'Repositorios::harvesting_register/$1');






$routes->get('/', 'Home::index');
