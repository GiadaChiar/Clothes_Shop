<?php
/*
//Only insert into Database 

class SearchUser {

    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function searchIdUser($data){

        $email = $data["email"] ?? null;
        $password = $data["password_hash"] ?? null;

        if (!$email || !$password) {
            $response = [
                "success" => false,
                "type" => "login",
                "error" => "Dati mancanti, riprovare"
            ];
            echo json_encode($response);
            exit;
        }

        $query = "SELECT id FROM users WHERE email = :email AND password_hash = :password";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return $user["id"];
    }
}

*/
?>