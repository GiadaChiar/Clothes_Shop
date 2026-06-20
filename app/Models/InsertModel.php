<?php

namespace App\Models;

use PDO;

class InsertModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
    public function insert(string $table, array $data): ?int
    {


        $columns = implode(', ', array_keys($data));

        $placeholders = ':' . implode(', :', array_keys($data));


        $query = "INSERT INTO {$table}({$columns})VALUES({$placeholders})";

        $stmt = $this->db->prepare($query);
        $stmt->execute($data);


        $idInsert = (int) $this->db->lastInsertId();

        return $idInsert ?: null;
    }


}
