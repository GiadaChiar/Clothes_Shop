<?php

namespace App\Models;

use PDO;

class ItemModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function allValutations(int $userId): ?array
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

        $stmt = $this->db->prepare($query);
        $stmt->execute(["user_id" => $userId]);

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

        return $data ? : null;
    }
}
