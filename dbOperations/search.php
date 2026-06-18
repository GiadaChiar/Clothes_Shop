<?php
/*
require_once __DIR__ . '/../config/database.php';

class ChatRepository
{

    private $conn;

    //my constructor for connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getLastChatIdByUser(int $userId): ?int
    {
        $query = "
        SELECT id
        FROM chats
        WHERE user_id = :user_id
        ORDER BY created_at DESC
        LIMIT 1
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            "user_id" => $userId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int)$result['id'] : null;
    }
}
*/