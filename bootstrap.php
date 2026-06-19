<?php

use App\Core\Database;

// Caricamento autoload
require __DIR__ . '/vendor/autoload.php';

// ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$dotenv->load();

// DATABASE (creato UNA volta)
$database = new Database();
$pdo = $database->getConnection();
