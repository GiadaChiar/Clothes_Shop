<?php
/*
require_once __DIR__ . '/../userRequests/LogIn.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . "/../userRequests/newUser.php";
require_once __DIR__ . "/../userRequests/valutation.php";
require_once __DIR__ . "/../dbOperations/getValutations.php";

//api call split in base of requests


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

    case "all":


        try {

            $user_id = $data["user_id"] ?? null;

            if (!$user_id) {
                $response = [
                    "success" => false,
                    "type" => "all",
                    "error" => "Errore, user id non trovato"
                ];
                break;
            }

            $model = new Valutations($conn);
            $data = $model->getValuatations((int)$user_id);

            $response = [
                "success" => true,
                "type" => "all",
                "data" => $data
            ];
        } catch (Throwable $e) {

            $response = [
                "success" => false,
                "type" => "all",
                "error" => $e->getMessage()
            ];
        }

        break;
        


    default:

        http_response_code(400);

        $response = [
            "success" => false,
            "message" => "Nessun caso trovato"
        ];
        break;
}

header('Content-Type: application/json');



echo json_encode($response);
exit;



*/








?>