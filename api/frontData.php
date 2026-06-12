<?php

require_once __DIR__ . '/../userRequests/LogIn.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../userRequests/newUser.php";
require_once __DIR__ . "/../userRequests/valutation.php";


//api call split in base of requests

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "error" => "Body vuoto o JSON non valido"
    ]);
    exit;
}

$request = $data["request"] ?? null;

$response = [];

switch ($request) {
    case "valutation":

        unset($data['request']);

        try {

            $result = valutation($data);

            echo json_encode([
                "success" => true,
                "debug" => $result
            ]);
            exit;
        } catch (Throwable $e) {
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
            exit;
        }
    


    case "registration":

        unset($data['request']);
        $json = json_encode($data);

        $result = newUser($json);

        $response = [
            "success" => true,
            "type" => "registration",
            "data" => $result
        ];

        break;

    case "login":

        unset($data['request']);
        $json = json_encode($data);
        
        $result = LogIn($json);

        $response = [
            "success" => true,
            "type" => "login",
            "data" => $result
        ];

        break;

    default:

        http_response_code(400);

        $response = [
            "success" => false,
            "message" => "Nessun caso trovato"
        ];
        break;
}

echo json_encode($response);
exit;












?>