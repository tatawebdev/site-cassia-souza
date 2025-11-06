<?php
$filename = realpath(__DIR__ . '/..') . '/apiwhatsapp/app/helpers/validacoes.php';
$response = [];
if (file_exists($filename)) {
    include $filename;
    $functions = get_defined_functions();
    $userFunctions = $functions['user'];
    $response['functions'] = $userFunctions;
    $response['status'] = 'success';
} else {
    $response['status'] = 'error';
    $response['message'] = "O arquivo não foi encontrado: " . $filename;
}
header('Content-Type: application/json');
echo json_encode($response);



