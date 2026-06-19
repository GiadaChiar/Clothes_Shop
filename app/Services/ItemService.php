<?php

namespace App\Services;

use App\Models\ItemModel;
use App\AI\PromptManager;
use App\AI\OpenAIService;
use App\Models\InsertModel;
use App\Models\ChatModel;
use App\Services\TransactionService;

require dirname(__DIR__, 2) . '/function/ClearAI.php';

use PDO;

class ItemService
{

    private PDO $db;
    private TransactionService $transaction;
    private ItemModel $itemModel;
    private PromptManager $promptManager;
    private OpenAIService $service;
    private InsertModel $insertModel;
    private ChatModel $chatRepo;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->transaction = new TransactionService($db);
        $this->promptManager = new PromptManager();
        $this->service = new OpenAIService();
        $this->insertModel = new InsertModel($db);
        $this->chatRepo = new ChatModel($db);
        $this->itemModel = new ItemModel($db);
    }


    // show all user's valutations
    public function allValutations($data): ?array
    {

        $userId = (int) $data['user_id'];

        if(!$userId){
            throw new \Exception(
                "Errore di autentificazione, ripetere il login"
            );
        }

        $all =  $this->itemModel->allValutations($userId);

        if (!$all) {
            throw new \Exception(
                "Nessuna valutazione trovata"
            );
        }
        return $all ?: null;
    }



    // insert and create new item valutation
    public function valutation(array $input)
    {

        // 1.input validation

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

        // 2.setup AI and prompt

        $systemPrompt = $this->promptManager->render('valutation', [
            'category'   => $category,
            'brand'      => $brand,
            'state'      => $state,
            'image_url'  => $image
        ]);


        // 3.call AI for valutation
        $response = $this->service->newItem($input, $systemPrompt);

        if (empty($response)) {
            echo json_encode([
                "success" => false,
                "error" => "Errore nella valutazione con l'AI, riprovare tra qualche minuto"
            ]);
            exit;
        }

        // 4. clean reasponse AI 
        $result = cleanResponse($response);

        if (!is_array($result)) {
            echo json_encode([
                "success" => false,
                "error" => "Errore risposta AI non formattata adeguatamente, riprovare"
            ]);
            exit;
        }

        // 5. insert valutation into db
        $insert = $this->insertValutation($input, (int)$user_id, $result);


        return $insert;
    }


    // insert valuatation into db
    public function insertValutation(array $input, int $user_id, array $result)
    {

        return $this->transaction->run(
            function (PDO $db) use ($input, $user_id, $result) {

        $image = $input["image"] ?? '';
        $user_id = $input["user_id"] ?? '';
        unset($input["request"]);


        
            //1. change image from baase64 to binary for database insert
            $image = preg_replace(
                '#^data:image/\w+;base64,#i',
                '',
                $image
            );

            $binary = base64_decode($image);

            $input["image"] = $binary;

            if (!$binary) {
                throw new \Exception("Errore durante la conversione dell'immagine");
            }

            //2. insert new item (user item) into db
            $itemId = $this->insertModel->insert("items", $input);

            if (!$itemId) {
                throw new \Exception("Errore durante la memorizzazione dell'aricolo inserito, riprovare");
            }

            // 3. insert relation between item and chat 
            $chatId = $this->chatRepo->getLastChatIdByUser($user_id);
            if (!$chatId) {
                throw new \Exception("Errore durante l'associazione dell'aricolo inserito, riprovare");
            }

            // 4. split data tips and valutation
            $tips = $result['selling_tips'] ?? [];


            unset($result['selling_tips']);

            if (!$tips || !$result) {
                throw new \Exception("Errore durante la separazione tra la valutazione e i consigli, riprovare");
            }

            // 5. Setting data
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

            // 6.insert valutation into db
            $valuationId = $this->insertModel->insert("valutations", $valuation);

            // insert tips
            foreach ($tips as $tip) {
                $this->insertModel->insert("valutation_tips", [
                    "valuation_id" => $valuationId,
                    "tip" => $tip
                ]);
            }

            if (!$chatId) {
                throw new \Exception("Errore durante la memorizzazione della valutazione AI");
            }

            return [
                "type" => "valutation",
                "item_id" => $itemId,
                "valuation_id" => $valuationId,
                "ai" => $result,
                "tips" => $tips,
            ];
            
        });
    }
}
