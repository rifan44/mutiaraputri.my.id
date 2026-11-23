<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Portfolio::index');
$routes->get('id', 'Portfolio::index/id');
$routes->get('en', 'Portfolio::index/en');
$routes->get('cv/(:segment)', 'Export::cv/$1');
$routes->get('portfolio/(:segment)/pdf', 'Export::portfolio/$1');

$routes->group('admin', static function (RouteCollection $routes): void {
    $routes->get('login', 'Admin\\Auth::loginForm');
    $routes->post('login', 'Admin\\Auth::login');
    $routes->post('logout', 'Admin\\Auth::logout', ['filter' => 'adminAuth']);

    $routes->get('/', 'Admin\\Dashboard::index', ['filter' => 'adminAuth']);
    $routes->get('profile', 'Admin\\Profile::edit', ['filter' => 'adminAuth']);
    $routes->post('profile/save', 'Admin\\Profile::save', ['filter' => 'adminAuth']);
    $routes->get('password', 'Admin\\Auth::passwordForm', ['filter' => 'adminAuth']);
    $routes->post('password', 'Admin\\Auth::changePassword', ['filter' => 'adminAuth']);

    $routes->get('(:segment)/new', 'Admin\\ContentManager::form/$1', ['filter' => 'adminAuth']);
    $routes->get('(:segment)/(:num)', 'Admin\\ContentManager::form/$1/$2', ['filter' => 'adminAuth']);
    $routes->post('(:segment)/save', 'Admin\\ContentManager::save/$1', ['filter' => 'adminAuth']);
    $routes->post('(:segment)/delete/(:num)', 'Admin\\ContentManager::delete/$1/$2', ['filter' => 'adminAuth']);
    $routes->get('(:segment)', 'Admin\\ContentManager::index/$1', ['filter' => 'adminAuth']);
});
