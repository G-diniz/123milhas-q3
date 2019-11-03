<?php

function convertToString($float)
{
    return sprintf('%0.2f', $float);
}

function findBestPrice($message)
{
    //Remove thousand delimiter to prevent conversion errors to float
    $newMessage = preg_replace('/\./m', '', $message);

    //Replace cents delimiter to prevenr conversion errors to float
    $newMessage = preg_replace('/,/m', '.', $newMessage);

    //Retrieve desired sequence
    $sequence = '/R\$(.*)\(1\)/m';
    preg_match_all($sequence, $newMessage, $matches, PREG_SET_ORDER, 0);

    //Check if there is connection prices in message
    if (preg_match("/com escalas/", $message)) {
        $preco_com_escala = convertToString($matches[0][1]);
    } else {
        $preco_com_escala = '';
    }

    //check is there is no connection prices in message
    if (preg_match("/sem escalas/", $message)) {
        $preco_sem_escala = convertToString($matches[1][1]);
    } else {
        $preco_sem_escala = '';
    }

    return [
        'com-escala' => $preco_com_escala,
        'sem-escala' => $preco_sem_escala,
    ];
}



$mensagem = "Melhor preço sem escalas R$ 1.367(1) <br>
Melhor preço com escalas R$ 994 (1)";


$resultado = findBestPrice($mensagem);

echo "RESULTADO!<br><pre>";
print_r($resultado);
echo "</pre>";
