<?php


use App\Controllers\UserController;


// ROUTES API (NO VIEW)

// POST email and password for login 
$router->post('/api/auth/login', [UserController::class, 'login']);

// POST personal info for registration
$router->post('/api/auth/register', [UserController::class, 'registration']);

// GET user id 
//$router->get('/api/users/{id}', [UserController::class, 'showId']);
