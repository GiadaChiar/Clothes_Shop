<?php
require_once __DIR__ . '/../AI/OpenAIClient.php';
require_once __DIR__ . '/../Requests/newItem.php';
require_once __DIR__ . '/../AI/PromptManager.php';
require_once __DIR__ . '/../dbOperations/Insert.php';
require_once __DIR__ . '/../function/InputValutation.php';
require_once __DIR__ . '/../function/InsertValutation.php';
//INSERT ITEM INTO DATABASE

//httml call
//$input = json_decode(file_get_contents("php://input"), true);
//testValutation.php

$json = '{
    "user_id": 6,
    "category": "maglia",
    "brand": "Gucci",
    "state": "nuovo",
    "image_url": "https://img.magnific.com/premium-vector/gucci-logo-tshirt-mockup-pink-colors-mockup-realistic-shirt-with-short-sleeves-blank-tshirt-template-with-empty-space-design-gucci-brand_661108-7793.jpg?"
}';


/*var_dump(class_exists('Insert'));
die();*/

$input = json_decode($json, true);

//check validation my json 

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException('JSON non valido');
}


$category = $input['category'];
$brand = $input['brand'];
$state = $input['state'];
$image_url = $input['image_url'];

if(empty($category) || empty($brand) || empty($state)|| empty($image_url)){
    echo("UNO O PIU' CAMPI INSERITI SONO VUOTI ");
    return;
}


$service = new OpenAIService();

$promptManager = new PromptManager();

//$systemPrompt = "Sei un esperto di moda e valutazione prodotti.";
//$systemPrompt = $promptManager->get('valutation');


$systemPrompt = $promptManager->render(
    'valutation',
    [
        'category' => $category,
        'brand' => $brand,
        'state' => $state,
        'image_url'=> $image_url
    ]
);


if (!$systemPrompt) {
    echo "pront in the file valutation.txt not found";
}


$response = $service->newItem($input, $systemPrompt);


$response = trim($response);

// rimuove ```json e ```
$response = preg_replace('/^```json|```$/', '', $response);
$response = trim($response);


$result = json_decode($response, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException(
        "JSON AI non valido" . $response
    );
}

echo "INSERIAMO NEL DATABASE NEW ITEM";
//insert into database 
$db = new Database();


$pdo = $db->getConnection();

$insertdb = new Insert($pdo);

try {

    $pdo->beginTransaction();


    if (!$itemId = $insertdb->insert("items", $input)) {

        throw new Exception("Error Insert Item");
    }



    $result = setValutation($response);
    $valutation = ($result['valuation']);
    $tips = ($result['tips']);

    //insert itemId
    $valutation['item_id'] = $itemId;

    //insert valutation and get id

    $idvalutation = $insertdb("valutations", $valutation);


     //insert tips 
    foreach ($tips as $tip){
        $insertdb->insert("valuation_tips",["valuation_id" => $idvalutation,
        "tip" => $tip]);
    }


    $pdo->commit();

    echo "OKAY NEW ITEM!";
} catch (Exception $e) {

    $pdo->rollBack();
    echo $e->getMessage();
}

/*
$result = setValutation($response);
$valutation= ($result['valuation']);
$tips = ($result['tips']);

if (!$itemId){
    echo "id non trovatooo";
}

InsertValutation($valutation,$tips, $itemId);

print_r($valutation);
print_r($tips);
echo $response;

*/
