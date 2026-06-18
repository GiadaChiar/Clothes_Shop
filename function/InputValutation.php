<?php


/*
//function setValutation(string $data){
function setValutation(string $data)
{

    $data = json_decode($data, true);

    if (!$data) {
        throw new Exception("JSON non valido");
    }

    $tips = $data['selling_tips'] ?? [];
    unset($data['selling_tips']);

    return [
        'valuation' => $data,
        'tips' => $tips
    ];

    //split my input for sql insert 


}*/
?>