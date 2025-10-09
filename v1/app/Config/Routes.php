<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//$routes->get('/repositorios', 'Repositorios::index');
$routes->get('/repository/view/(:num)', 'Repository::views/$1');
$routes->get('/repositorios/sets/show/(:num)', 'Repository::sets_show/$1');
$routes->get('/repository/record_view/(:num)', 'Repository::record_view/$1');
$routes->get('/repository/record_harvest/(:num)', 'Repository::record_harvest/$1');
$routes->get('/repository/record_extract_harvest/(:num)', 'Repository::record_extract_harvest/$1');
$routes->get('/repository/records_extract/(:num)', 'Repository::records_extract/$1');

$routes->get('/repository/subject/(:num)', 'Repository::list_subject/$1');
$routes->get('/repository/creator/(:num)', 'Repository::list_creator/$1');

//$routes->get('/repositorios/create', 'Repository::create');
//$routes->get('/repositorios/edit/(:num)', 'Repository::edit/$1');
//$routes->get('/repositorios/copy/(:num)', 'Repository::copy/$1');
//$routes->get('/repositorios/delete/(:num)', 'Repository::delete/$1');

$routes->get('/repository', 'Repository::index');
$routes->get('/repository/create', 'Repository::create');
$routes->post('/repository/store', 'Repository::store');
$routes->get('/repository/edit/(:num)', 'Repository::edit/$1');
$routes->post('/repository/update/(:num)', 'Repository::update/$1');
$routes->get('/repository/delete/(:num)', 'Repository::delete/$1');
$routes->get('/repository/show/(:num)', 'Repository::show/$1');
$routes->get('/repository/analyse/(:num)', 'Repository::analyse/$1');
$routes->get('/repository/harvesting/(:num)', 'Repository::harvesting/$1');
$routes->get('/repository/stat_make/(:num)', 'Repository::stat_make/$1');
$routes->get('/repository/url_check', 'Repository::url_check');
$routes->get('/oai/identify/(:num)', 'Repository::harvestingOAI/$1');
$routes->get('/oai/sets/(:num)', 'Repository::harvesting_sets/$1');
$routes->get('/oai/register/(:num)', 'Repository::harvesting_register/$1');
$routes->get('/oai/records/(:num)', 'Repository::harvestingOAIrecords/$1');
$routes->get('/indicadores', 'Indicadores::index');






$routes->get('/', 'Home::index');
