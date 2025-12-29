<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('fertilizer', 'Fertilizer::index');
$routes->get('fertilizer/add', 'Fertilizer::add');          // ✅ FORM PAGE
$routes->get('fertilizer/edit/(:num)', 'Fertilizer::edit/$1');

$routes->get('signup', 'Auth::signup', ['filter' => 'noauth']);
$routes->get('login', 'Auth::login', ['filter' => 'noauth']);
$routes->get('logout', 'Auth::logout');

/* 🔹 API ROUTES */
$routes->group('api', function ($routes) {

    // PUBLIC
    $routes->post('signup', 'Api\AuthApi::signup');
    $routes->post('login',  'Api\AuthApi::login');
    $routes->get('fertilizer/list', 'Api\FertilizerApi::listFertilizer');
    $routes->get('gemini-test', 'Api\GeminiTest::index');
    

    // PROTECTED
    $routes->group('', ['filter' => 'jwt'], function ($routes) {
        $routes->post('fertilizer/add', 'Api\FertilizerApi::addfertilizer');
        $routes->post('fertilizer/update/(:num)', 'Api\FertilizerApi::update/$1');
        $routes->delete('fertilizer/delete/(:num)', 'Api\FertilizerApi::delete/$1');
    });
});

