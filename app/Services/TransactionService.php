<?php

namespace App\Services;

use PDO;

class TransactionService
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function run(callable $callback): mixed
    {
        $this->db->beginTransaction();

        try {
            $result = $callback($this->db);
            $this->db->commit();
            return $result;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
