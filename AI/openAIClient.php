<?php
// OpenAIClient.php

require_once __DIR__ . '/../config/database.php';
require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class OpenAIClient
{
    private string $AI_Key;
    private string $baseUrl = 'https://api.openai.com/v1';


    public function __construct()
    {
        if (!isset($_ENV['OPENAI_API_KEY'])) {
            throw new RuntimeException("OPENAI_API_KEY non trovata nel .env");
        }
        $this->AI_Key = $_ENV['OPENAI_API_KEY'] ?? '';
    }

   
    /**
     * Esegue una chat completion con GPT-5.1.
     */
    public function chat(string $userMessage, ?string $systemPrompt = null): string
    {
        $url = $this->baseUrl . '/chat/completions';

        $messages = [];

        if ($systemPrompt) {
            $messages[] = [
                'role' => 'system',
                'content' => $systemPrompt
            ];
        }

        $messages[] = [
            'role' => 'user',
            'content' => $userMessage
        ];

        $payload = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'temperature' => 0.4,
            'max_tokens' => 300
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->AI_Key,
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30,

            //FIX SSL
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => 'C:\php\extras\ssl\cacert.pem',
        ]);

        $responseBody = curl_exec($ch);

        if ($responseBody === false) {
            $error = curl_error($ch);
            throw new RuntimeException('Errore nella chiamata cURL a OpenAI: ' . $error);
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new RuntimeException('OpenAI ha restituito status ' . $statusCode . ': ' . $responseBody);
        }

        $data = json_decode($responseBody, true);

        if (!isset($data['choices'][0]['message']['content'])) {
            throw new RuntimeException('Risposta OpenAI senza contenuto valido: ' . $responseBody);
        }

        return $data['choices'][0]['message']['content'];
    }








    public function chatVision(array $messages, int $id_user): string
    {

    

        $url = $this->baseUrl . '/chat/completions';

        $payload = [
            'model' => 'gpt-4o-mini',
            'messages' => $messages,
            'temperature' => 0.4,
            'max_tokens' => 300
        ];

        $ch = curl_init($url);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->AI_Key,
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $response = [
                "success" => false,
                "type" => "valutation",
                "error" => "Errore nella risposta dell'AI"
            ];
            echo json_encode($response);
            exit;
        }

        $data = json_decode($response, true);

        if (!isset($data['choices'][0]['message']['content'])) {
            $response = [
                "success" => false,
                "type" => "valutation",
                "error" => "Errore formatom dela risposta dell'AI, invalido"
            ];
            echo json_encode($response);
            exit;
            
        }

        $content= $data['choices'][0]['message']['content'];
        return $content;
    }

}






