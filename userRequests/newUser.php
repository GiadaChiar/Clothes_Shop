<?php
require_once __DIR__ . '/../dbOperations/Insert.php';

//INSERT USER AND NEW CHAT INTO DATABASE
 


function newUser($json){


    $input = json_decode($json, true);

    //check validation my json 
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException(
            'JSON non valido: ' . json_last_error_msg()
        );
    }

$email = $input['email'];
$name = $input['name'];
$surname = $input['surname'];
$password = $input['password_hash'];

if (empty($email) || empty($name) || empty($surname) || empty($password)) {
        $response = [
            "success" => false,
            "type" => "registration",
            "error" => "Si è verificato un problema nell'invio dei dati, riprovare"
        ];
        echo json_encode($response);
    exit;
}


    //insert into database 
$db = new Database();


$pdo = $db->getConnection();

$insertdb = new Insert($pdo);


try {

    $pdo->beginTransaction();


    if (!$userId = $insertdb->insert("users", $input)) {

        $response = [
            "success" => false,
            "type" => "registration",
            "error" => "Si è verificato un problema durante l'inserimento, dati sbagliati o user già registrato"
        ];
        echo json_encode($response);
        exit;
    }      

    $chatId = $insertdb->insert(
        "chats",
        [
            "user_id" => $userId
        ]
    );

    $pdo->commit();

    return $userId;

} catch (Exception $e) {

    $response = [
        "success" => false,
        "type" => "registration",
        "error" => "Si è verificato un problema durante l'inserimento, dati sbagliati o user già registrato, riprova"
    ];
    echo json_encode($response);
    exit;
}



}