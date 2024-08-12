<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/post', 'Post::index');
$routes->get('/post/create', 'Post::create');
$routes->post('/post/store', 'Post::store');
$routes->get('/post/edit/(:any)', 'Post::edit/$1');
$routes->post('/post/update/(:any)', 'Post::update/$1');
$routes->get('/post/delete/(:any)', 'Post::delete/$1');
