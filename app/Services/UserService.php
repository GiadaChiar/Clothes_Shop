<?php

namespace App\Services;
use App\Models\UserModel;
use App\Models\InsertModel;
use PDO;

class UserService {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function login(string $email, string $password):array
    {
    $userModel = new UserModel($this->db);

    $user = $userModel->findByEmail($email);

    if (!$user) {
        throw new \Exception("User not found");
    }

        if ($password !== $user['password_hash']) {
            throw new \Exception("Invalid credentials");
        }



        return $user;

    }

    
    public function registration(array $data): int
    {
        $insertModel = new InsertModel($this->db);
        $table = "users";
        unset($data['request']);

        $userId = $insertModel->insert($table,$data);

        if (!$userId) {
            throw new \Exception("No new user");
        }

        return $userId;
    }

}