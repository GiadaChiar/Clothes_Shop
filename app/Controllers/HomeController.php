<?php



namespace App\Controllers;

class HomeController
{
public function index()
{
echo json_encode([
"success" => true,
"message" => "API running"
]);
}
}