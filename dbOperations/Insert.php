<?php
/*

//Only insert into Database 
require_once __DIR__ . '/../config/database.php';


class Insert {


    private $conn;

    //my constructor for connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    //return id new row
    public function insert(string $table, array $data):int{


        $columns = implode(', ', array_keys($data));

        $placeholders = ':' . implode(', :', array_keys($data));


        $query = "INSERT INTO {$table}({$columns})VALUES({$placeholders})";

        $stmt = $this->conn->prepare($query);

        if (!$stmt->execute($data)) {
            throw new RuntimeException("Errore inserimento in {$table}");
        }

        return (int)$this->conn->lastInsertId();
    }



    
}*/

?>