<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('fertilizer', 'Fertilizer::index');
$routes->get('fertilizer/edit/(:num)', 'Fertilizer::edit/$1');

$routes->get('signup', 'Auth::signup', ['filter' => 'noauth']);
$routes->get('login', 'Auth::login', ['filter' => 'noauth']);
$routes->get('logout', 'Auth::logout');


/* 🔹 API ROUTES */
$routes->group('api', function ($routes) {

    /* 🔓 PUBLIC APIs (NO JWT) */
    $routes->post('signup', 'Api\AuthApi::signup');
    $routes->post('login',  'Api\AuthApi::login');
    $routes->get('fertilizer/list', 'Api\FertilizerApi::listFertilizer');

    /* 🔐 PROTECTED APIs (JWT REQUIRED) */
    $routes->group('', ['filter' => 'jwt'], function ($routes) {

        $routes->match(['get','post'], 'fertilizer/add', 'Api\FertilizerApi::addfertilizer');
        $routes->get('fertilizer/edit/(:num)', 'Api\FertilizerApi::edit/$1');
        $routes->post('fertilizer/update/(:num)', 'Api\FertilizerApi::update/$1');
        $routes->delete('fertilizer/delete/(:num)', 'Api\FertilizerApi::delete/$1');

    });

});
