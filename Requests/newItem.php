<?php

//newItem.php

require_once __DIR__ . '/../AI/OpenAIClient.php';
require_once __DIR__ . '/../function/downloadImage.php';

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
        $imageUrl = $input["image_url"];

        $imageData = downloadImage($imageUrl);

        // 2. base64 vero file
        $base64 = base64_encode($imageData);

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
                            . "User ID: $userId, Category: $category, Brand: $brand, State: $state"
                    ],
                    [
                        "type" => "image_url",
                        "image_url"  => [
                            "url" => "data:image/jpeg;base64,$base64"
                        ]
                    ]
                ]
            ]
        ];

        return $this->client->chatVision($messages);
    }
}
