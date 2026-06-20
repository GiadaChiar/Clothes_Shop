<?php

$allowedOrigins = [
    'http://localhost:5174',
    'https://clothesshop-production.up.railway.app/',
];

if (
    isset($_SERVER['HTTP_ORIGIN'])
    && in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)
) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}


//  CORS (DEV)

header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");




//
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require __DIR__ . '/../bootstrap.php';

use App\Core\Router;

$router = new Router();

require __DIR__ . '/../routes/api.php';

// Clean api;
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = preg_replace('/\s+/', '', $uri); // delete \n \r space
$uri = rtrim($uri, '/');

if ($uri === '') {
    $uri = '/';
}

$router->dispatch($uri, $pdo);
