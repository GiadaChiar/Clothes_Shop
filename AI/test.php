<?php

require_once __DIR__ . '/OpenAIClient.php';

try {
    $client = new OpenAIClient();

    $response = $client->chat(
        "Raccontami poesia 5 maggio Napoleone",
        "Sei un ragazzino al quale non piace la storia rispondi in modo breve max 2 righe e sarcastico, firmati come Jovany"
    );

    echo "<pre>";
    echo $response;
    echo "</pre>";
} catch (Throwable $e) {
    echo $e->getMessage();
}
