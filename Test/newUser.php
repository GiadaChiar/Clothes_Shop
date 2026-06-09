<?php
require_once __DIR__ . '/../dbOperations/Insert.php';

//INSERT USER AND NEW CHAT INTO DATABASE

/*login utenteeeeee-------------------------

session_start();

$_SESSION['user_id'] = $userId;*/


//new user 

$json = '{
    "email": "giorgio@gmail.com",
    "name": "Giorgio",
    "surname": "Pizzi",
    "password_hash": "ghibewor6b665b1"
    }';


$input = json_decode($json, true);

//check validation my json 

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException('JSON non valido');
}


$email = $input['email'];
$name = $input['name'];
$surname = $input['surname'];
$password = $input['password_hash'];

if (empty($email) || empty($name) || empty($surname) || empty($password)) {
    echo ("UNO O PIU' CAMPI INSERITI SONO VUOTI INSERIMENTO USER ");
    return;
}


//insert into database 
$db = new Database();


$pdo = $db->getConnection();

$insertdb = new Insert($pdo);

try{

    $pdo->beginTransaction();

    if (!$userId = $insertdb->insert("users",$input)){

        throw new Exception("Error Insert user");
    }

    $chatId = $insertdb->insert(
        "chats",
        [
            "user_id" => $userId
        ]
    );

    $pdo->commit();

    echo "Utente e chat creati correttamente";

} catch (Exception $e) {

    $pdo->rollBack();
    echo $e->getMessage();
}


?>