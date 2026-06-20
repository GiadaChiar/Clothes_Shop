<?php

namespace App\Models;

use PDO;

class ChatModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
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

        $stmt = $this->db->prepare($query);
        $stmt->execute([
            "user_id" => $userId,
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['id'] : null;
    }
}
