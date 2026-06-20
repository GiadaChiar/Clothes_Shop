<?php

$allowedOrigins = [
    'http://localhost:5174',
    'https://clothesshop-production.up.railway.app/'
];

if (
    isset($_SERVER['HTTP_ORIGIN']) &&
    in_array($_SERVER['HTTP_ORIGIN'], $allowedOrigins)
) {
    header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
}


// 🔥 CORS GLOBALI (DEV)
//header("Access-Control-Allow-Origin: http://localhost:5174");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");




// 🔥 BLOCCA PREFLIGHT SUBITO (PRIMA DI QUALSIASI LOGICA)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

require __DIR__ . '/../bootstrap.php';

use App\Core\Router;

$router = new Router();

require __DIR__ . '/../routes/api.php';

// 🔥 IMPORTANTE: PULIZIA URI
//$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = preg_replace('/\s+/', '', $uri); // elimina \n \r spazi
$uri = rtrim($uri, '/');

if ($uri === '') {
    $uri = '/';
}

$router->dispatch($uri, $pdo);

