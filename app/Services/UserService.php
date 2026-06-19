<?php

namespace App\Services;
use App\Models\UserModel;
use App\Models\InsertModel;
use App\Services\TransactionService;
use PDO;


// User operations
class UserService {

    private PDO $db;
    private TransactionService $transaction;
    private UserModel $userModel;
    private InsertModel $insertModel;



    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->transaction = new TransactionService($db);
        $this->userModel = new UserModel($db);
        $this->insertModel = new InsertModel($db);
        
    }


    //login user
    public function login(string $email, string $password): ?int
    {

    //1. Search user by email
    $user = $this->userModel->findByEmail($email);

        if (!$user) {
            throw new \Exception(
                "Nessun utente registrato con questa email"
            );
        }

    // 2.check if my password equal to db password
        if ($password !== $user['password_hash']) {
            throw new \Exception("Password errata, riprovare");
        }

        $idUser = $user["id"];
        if($idUser){
                return $idUser;
        }
        
    return null;

    }






    // registration new user
    public function registration(array $data): ?int
    {
   

        return $this->transaction->run(
            function (PDO $db) use ($data) {



            //1.check if already exist user search by email
            $existing = $this->userModel->findByEmail($data['email']);

            if ($existing) {
                throw new \Exception("L'email è già stata registrata, passa al login");
            }


            $table = "users";
            unset($data['request']);

            //2. Insert new User
            $userId = $this->insertModel->insert($table, $data);

            if (!$userId) {
                throw new \Exception("Errore non è stato possibile effettuare la registrazione, controllare la connessione o utente già registrato");
            }

            // 3. create his/her personal chat
            $chatId = $this->insertModel->insert(
                "chats",
                [
                    "user_id" => $userId
                ]
            );

            if (!$chatId) {
                throw new \Exception("Problemi tecnici, ci scusiamo per il disagio. Riprovare più tardi");
            }


            return $userId;
        });
    }
}

