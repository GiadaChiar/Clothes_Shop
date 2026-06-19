<?php

//newItem.php
namespace App\AI;


use App\AI\OpenAIClient;



//require_once __DIR__ . '/../AI/OpenAIClient.php';
//require_once __DIR__ . '/../function/downloadImage.php';
require_once dirname(__DIR__, 2) . '/function/downloadImage.php';


//create new Item after Valuta button

class OpenAIService
{
    private OpenAIClient $client;

    public function __construct()
    {
        $this->client = new OpenAIClient();
    }

    public function newItem(array $input, string $systemPrompt): string
    {


        $userId = $input["user_id"];
        $category = $input["category"];
        $brand = $input["brand"];
        $state = $input["state"];
        $image = $input["image"];

        // rimuove header se presente
        $base64 = preg_replace(
            '#^data:image/\w+;base64,#i',
            '',
            $image
        );



        //$imageData = downloadImage($imageUrl);

        // 2. base64 vero file
        //$base64 = base64_encode($imageData);

        $messages = [
            [
                "role" => "system",
                "content" => $systemPrompt
            ],
            [
                "role" => "user",
                "content" => [
                    [
                        "type" => "text",
                        "text" =>
                        "Analizza questo prodotto e restituisci una valutazione."
                            . "category: $category, brand: $brand, state: $state"
                    ],
                    [
                        "type" => "image_url",
                        "image_url"  => [
                            "url" => $image
                        ]
                    ]
                ]
            ]
        ];


        return $this->client->chatVision($messages, $userId);
    }
}
