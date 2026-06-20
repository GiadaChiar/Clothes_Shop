<?php


//convert image to base64 to binary for database

function base64ToBinary(string $base64): string
{
    if (strpos($base64, ',') !== false) {
        $base64 = explode(',', $base64)[1];
    }

    $imageBinary = base64_decode($base64);

    if ($imageBinary === false) {
        throw new Exception("Base64 immagine non valida");
    }


    return $imageBinary;
}
