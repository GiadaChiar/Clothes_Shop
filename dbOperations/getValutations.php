<?php


require_once __DIR__ . '/../config/database.php';
//Search all valuatations for user 


class Valutations
{
    private $conn;

    //my constructor for connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getValuatations(int $userId): array
{
    $query = "
    SELECT
    val.suggested_price, val.range_min, val.range_max, val.motivation, 
val.season, val.rarity, val.demand,items.brand,items.image,
items.id as id_item FROM items 
INNER JOIN valutations as val 
	ON val.item_id = items.id
WHERE user_id = :user_id;
    ";

    $stmt = $this->conn->prepare($query);

    if (!$stmt) {
        die(json_encode([
            "error" => "PREPARE FALLITA",
            "info" => $this->conn->errorInfo()
        ]));
    }

    $ok = $stmt->execute(["user_id" => $userId]);

    if (!$ok) {
        die(json_encode([
            "error" => "EXECUTE FALLITA",
            "info" => $stmt->errorInfo()
        ]));
    }

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($data === false) {
            die(json_encode([
                "error" => "FETCH FALLITA"
            ]));
        }

        //convert value image 
        foreach ($data as &$row) {
            if (!empty($row["image"])) {
                $base64 = base64_encode($row["image"]);
                $row["image"] = 'data:image/jpeg;base64,' . $base64;
            }
        }


    return $data;
}
}