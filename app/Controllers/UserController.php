<?php



namespace App\Controllers;

use PDO;
use App\Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct(PDO $db)
    {
        $this->userService = new UserService($db);
    }

    public function login()
    {
        try {

            header('Content-Type: application/json');
            // INPUT JSON da React
            $data = json_decode(file_get_contents("php://input"), true);

            $email = $data['email'] ?? null;
            $password = $data['password'] ?? null;


            if (!$email || !$password) {
                http_response_code(400);

                echo json_encode([
                    "success" => false,
                    "type" => "login",
                    "error" => "credenziali incomplete",
                ]);
                exit;
            }

            // chiamata service
            $result = $this->userService->login($email, $password);

            if($result){
                http_response_code(200);

                echo json_encode([
                    "success" => true,
                    "type" => "login",
                    "data" => $result
                ]);
                exit;
            }
        
        } catch (\Throwable $e) {

            http_response_code(401);

            echo json_encode([
                "success" => false,
                "type" => "login",
                "error" => $e->getMessage()
            ]);
            exit;
        }
    }





    public function registration(){


        try {

            header('Content-Type: application/json');
            // INPUT JSON da React
            $data = json_decode(file_get_contents("php://input"), true);

            $email = $data['email'] ?? null;
            $name = $data['name'];
            $surname = $data['surname'];
            $password = $data['password_hash'] ?? null;


            if (empty($email) || empty($name) || empty($surname) || empty($password)) {
                http_response_code(400);

                echo json_encode([
                    "success" => false,
                    "type" => "registration",
                    "error" => "Campi mancanti o incorretti"
                ]);
                exit;
            }

            // chiamata service
            $IdUser = $this->userService->registration($data);

            if ($IdUser) {
                
                http_response_code(200);

                echo json_encode([
                    "success" => true,
                    "type" => "registration",
                    "data" =>  $IdUser
                ]);
                exit;
            }
        } catch (\Throwable $e) {
            http_response_code(401);

            echo json_encode([
                "success" => false,
                "type" => "registration",
                "error" => $e->getMessage(),
            ]);
            exit;
        }
    }
}
