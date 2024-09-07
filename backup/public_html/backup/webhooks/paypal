<?php
// Capture o conteúdo da requisição POST do PayPal
$raw_post_data = file_get_contents('php://input');
$decoded_data = json_decode($raw_post_data, true);

// Verifique se os dados foram recebidos corretamente
if ($decoded_data) {
    // Faça alguma ação com os dados, por exemplo, salvar no banco de dados
    file_put_contents('log.txt', print_r($decoded_data, true));
}

// Responda ao PayPal com um código HTTP 200 OK
http_response_code(200);
?>
