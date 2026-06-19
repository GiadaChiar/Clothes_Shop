<?php

namespace App\Models;

use PDO;

class UserModel{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail(string $email): ?array{
        $query = "
        SELECT id, email, password_hash
        FROM users 
        WHERE email = :email";

        $stmt = $this->db->prepare($query);


        $stmt->bindParam(":email", $email);
    

        $stmt->execute();

        $result= $stmt->fetch(PDO::FETCH_ASSOC);



        return $result ?: null;;

    }
}
