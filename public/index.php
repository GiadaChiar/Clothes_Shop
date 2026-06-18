<?php

// 🔥 CORS GLOBALI (DEV)
header("Access-Control-Allow-Origin: http://localhost:5174");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

header("Content-Type: application/json");

header("Access-Control-Allow-Origin: *");

header("Access-Control-Allow-Headers: Content-Type");



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
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($uri, $pdo);
var_dump($_SERVER['REQUEST_URI']);
var_dump($_SERVER['REQUEST_METHOD']);
