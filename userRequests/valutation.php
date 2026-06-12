<?php



require_once __DIR__ . '/../Requests/newItem.php';
require_once __DIR__ . '/../AI/openAIClient.php';
require_once __DIR__ . '/../AI/PromptManager.php';
require_once __DIR__ . '/../function/ClearAI.php';
require_once __DIR__ . '/../dbOperations/insertValutation.php';


function valutation(array $input)
{
    // INPUT VALIDATION
    
    $category = $input['category'] ?? null;
    $brand    = $input['brand'] ?? null;
    $state    = $input['state'] ?? null;
    $image    = $input['image'] ?? null;
    $user_id  = $input['user_id'] ?? null;

    if (!$category || !$brand || !$state || !$image || !$user_id) {
        echo json_encode([
            "success" => false,
            "type" => "valutation",
            "error" => "Errore nell'invio dei dati"
        ]);
        exit;
    }

    // AI SETUP + PROMPT

    $service = new OpenAIService();
    $promptManager = new PromptManager();

    $systemPrompt = $promptManager->render('valutation', [
        'category'   => $category,
        'brand'      => $brand,
        'state'      => $state,
        'image_url'  => $image
    ]);

    if (!$systemPrompt) {
        echo json_encode([
            "success" => false,
            "error" => "Errore prompt AI"
        ]);
        exit;
    }

    //  AI CALL + CLEAN RESPONSE

    $response = $service->newItem($input, $systemPrompt);

    if (empty($response)) {
        echo json_encode([
            "success" => false,
            "error" => "Errore risposta AI"
        ]);
        exit;
    }

    $result = cleanResponse($response);

    if (!is_array($result)) {
        throw new Exception("Pulizia delle risposte AI non eseguita");
    }

    return insertValutation($input,(int)$user_id, $result);
}
