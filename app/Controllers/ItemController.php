<?php



namespace App\Controllers;

use PDO;
use App\Services\ItemService;

// All about items (insert and valutation)
class ItemController
{

    private ItemService $itemService;

    public function __construct(PDO $db)
    {
        $this->itemService = new ItemService($db);
    }


    // create a new item valutation
    public function new(){
        try {

            header('Content-Type: application/json');
            
            $data = json_decode(file_get_contents("php://input"), true);

            $category = $data['category'] ?? null;
            $brand = $data['brand'] ?? null;
            $state = $data['state'] ?? null;
            $image = $data['image'] ?? null;
            $user_id = $data['user_id'] ?? null;


            if (!$category || !$brand || !$state || !$image || !$user_id) {
                http_response_code(400);

                echo json_encode([
                    "success" => false,
                    "type" => "valutation",
                    "credential"=>$data,
                    "error" => "Credenziali mancanti o incomplete",
                ]);
                exit;
            }

            $result = $this->itemService->valutation($data);

            if ($result) {
                http_response_code(200);

                echo json_encode([
                    "success" => true,
                    "debug" => $result
                ]);
                exit;
            }
        } catch (\Throwable $e) {

            echo json_encode([
                "success" => false,
                "type" => "valutation",
                "error" => $e->getMessage(),
            ]);
            exit;
        }
    }





    // show all valutations by id user
    public function all()
    {
        header('Content-Type: application/json');

        try {

            $user_id = json_decode(file_get_contents("php://input"), true);

            if (!$user_id) {
                http_response_code(400);

                echo json_encode([
                    "success" => false,
                    "type" => "all",
                    "error" => "Errore durante l'accesso, utente non autentificato correttamente, rifare il login"
                ]);
                exit;
            }

            $result = $this->itemService->allValutations($user_id);


            if($result){

            http_response_code(200);

            echo json_encode([
                "success" => true,
                "type" => "all",
                "data" => $result 
            ]);
            exit;
            }

        } catch (\Throwable $e) {

            http_response_code(500);

            echo json_encode([
                "success" => false,
                "type" => "all",
                "error" => $e->getMessage()
            ]);
            exit;
        }
    }
}