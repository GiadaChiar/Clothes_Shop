<?php


use App\Controllers\UserController;
use App\Controllers\ItemController;
use App\Controllers\HomeController;

//standard route default


$router->get('/', [HomeController::class, 'index']);


// ROUTES API (NO VIEW)

// POST email and password for login
$router->post('/api/auth/login', [UserController::class, 'login']);

// POST personal info for registration
$router->post('/api/auth/register', [UserController::class, 'registration']);




//POST new item
$router->post('/api/item/new', [ItemController::class, 'new']);

$router->post('/api/item/all', [ItemController::class, 'all']);
