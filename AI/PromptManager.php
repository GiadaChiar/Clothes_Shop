<?php

class PromptManager
{
    private string $promptDir;

    public function __construct()
    {
        $this->promptDir = __DIR__ . '/../Prompts/';
    }

    public function get(string $name): string
    {
        $file = $this->promptDir . $name . '.txt';

        if (!file_exists($file)) {
            throw new RuntimeException("Prompt non trovato: {$name}");
        }

        return file_get_contents($file);
    }



    public function render(string $name, array $vars = []): string
    {
        $prompt = $this->get($name);

        foreach ($vars as $key => $value) {
            $prompt = str_replace(
                '{{' . $key . '}}',
                $value,
                $prompt
            );
        }

        return $prompt;
    }
}
