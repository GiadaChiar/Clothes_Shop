<?php


/*
require_once __DIR__ . '/../dbOperations/Insert.php';
require_once __DIR__ . '/../dbOperations/search.php';
require_once __DIR__ . '/../function/ImageConvert.php';










function insertValutation(array $input, int $user_id, array $result){

// DB INIT
$db = new Database();
$pdo = $db->getConnection();
$insert = new Insert($pdo);
$pdo->beginTransaction();

try {
// IMAGE CONVERSION (Base64 -> BLOB)

$image = $input["image"] ?? '';

//$binary = base64ToBinary($base64);
$image = preg_replace(
    '#^data:image/\w+;base64#i',
    '',
    $image
);

$binary = base64_decode($image);


//binary = "data:image/jpeg;base64," . $base64;

if (!$binary) {
throw new Exception("Errore immagine non convertita in binary");
}

        $input["image"] = $binary;


$itemId = $insert->insert("items", $input);


    


        if (!$itemId) {
throw new Exception("Errore insert item");
}

// GET CHAT
$chatRepo = new ChatRepository($pdo);
$chatId = $chatRepo->getLastChatIdByUser($user_id);

if (!$chatId) {
throw new Exception("Chat non trovata");
}

// 8. SPLIT AI DATA
$tips = $result['selling_tips'] ?? [];

if (empty($tips)) {
throw new Exception("Missing tips AI");
}

unset($result['selling_tips']);

// BUILD VALUATION DATA

$valuation = [
"chat_id" => $chatId,
"item_id" => $itemId,
"suggested_price" => $result["suggested_price"] ?? null,
"range_min" => $result["range_min"] ?? null,
"range_max" => $result["range_max"] ?? null,
"motivation" => $result["motivation"] ?? null,
"season" => $result["season"] ?? null,
"rarity" => strtolower(trim($result["rarity"] ?? null)),
"demand" => strtolower(trim($result["demand"] ?? null)),
];

// INSERT VALUATION
$valuationId = $insert->insert("valutations", $valuation);

if (!$valuationId) {
throw new Exception("Errore insert valuation");
}

// INSERT TIPS
foreach ($tips as $tip) {
$insert->insert("valutation_tips", [
"valuation_id" => $valuationId,
"tip" => $tip
]);
}

// COMMIT
$pdo->commit();

return [
"type" => "valutation",
"item_id" => $itemId,
"valuation_id" => $valuationId,
"ai" => $result,
"tips" => $tips,
];
} catch (Exception $e) {
$pdo->rollBack();
throw $e;
}
}
*/
?>