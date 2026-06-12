<?php
//check if user is already registered


require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../dbOperations/searchIdUser.php';

function LogIn($json){

    $input = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('JSON non valido: ' . json_last_error_msg());
    }

    $db = new Database();
    $pdo = $db->getConnection();

    $search = new SearchUser($pdo);

    $userId = $search->searchIdUser($input);

    if (!$userId) {
    
        $response = [
            "success" => false,
            "type" => "login",
            "error" => "Utente non trovato, email o password errate"
        ];
        echo json_encode($response);
        exit;
    }

    return $userId;
}

?>