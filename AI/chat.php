<?php
// chat.php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../AI/OpenAIClient.php';
require_once __DIR__ . '/../dbOperations/insert.php';

try {
    //only post 
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo non consentito. Usa POST.']);
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['message']) || !is_string($input['message']) || trim($input['message']) === '') {
        http_response_code(400);
        echo json_encode(['error' => "Campo 'message' mancante o non valido."]);
        exit;
    }

    $userMessage = trim($input['message']);

    // In un caso reale potresti avere system prompt diversi per feature diverse
    $systemPrompt = 'Dato un lavoro rispondimi con 3 opzioni numerate con stipendio, luogo e lingua dei migliori posti al mondo dove lavorare';

    $client = new OpenAIClient();
    //message+pront
    $aiReply = $client->chat($userMessage, $systemPrompt);

    $db = new Database();
    $pdo = $db->getConnection();

    // Salvataggio su MySQL

    //$pdo = getConnection();
    $stmt = $pdo->prepare("
        INSERT INTO ai_logs (user_message, ai_reply, provider, model)
        VALUES (:user_message, :ai_reply, :provider, :model)
    ");

    $stmt->execute([
        ':user_message' => $userMessage,
        ':ai_reply'     => $aiReply,
        ':provider'     => 'openai',
        ':model'        => 'gpt-4o-mini',
    ]);

    echo json_encode([
        'success' => true,
        'reply'   => $aiReply
    ]);
} catch (Throwable $e) {
    // In produzione: log su file o sistema di logging centralizzato
    http_response_code(500);
    echo json_encode([
        'error' => 'Errore interno durante l\'elaborazione della richiesta.',
        'details' => $e->getMessage() // opzionale, meglio disabilitarlo in produzione
    ]);
}
