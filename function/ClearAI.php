<?php
/*
//clear format for AI responses

function cleanResponse(string $response): array
{
    $response = trim($response);
    $response = preg_replace('/```json|```/', '', $response);

    $decoded = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception("AI JSON non valido");
    }

    return $decoded;
}


*/


?>