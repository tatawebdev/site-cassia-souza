<?php

use App\Models\PalavrasProibida;

function proxima_etapa($selected)
{
    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => false
    ];
}

function validar_nome($selected)
{
    $nome = trim($selected['data']['message']);

    // Verifica se o nome é válido
    if (empty($nome) || !preg_match('/^[\p{L}\s]+$/u', $nome)) {
        return [
            'result' => false,
            'message' => ['Nome inválido ou vazio'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    $palavrasProibidasExatas = ['oi', 'ola', 'olá', 'e aí', 'salve', 'bom dia', 'boa tarde', 'boa noite', 'hey', 'hello'];
    $palavrasProibidas = PalavrasProibida::getAllPalavrasOnly();

    $acentos = ['á', 'à', 'â', 'ã', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'ç', 'ä', 'ë', 'ï', 'ö', 'ü'];
    $semAcento = ['a', 'a', 'a', 'a', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'c', 'a', 'e', 'i', 'o', 'u'];


    foreach (array_merge($palavrasProibidas) as $palavra) {
        if (strtolower(trim($nome)) === strtolower(trim($palavra))) {
            return [
                'result' => false,
                'message' => ['Nome contém palavras proibidas' . $palavra],
                'data' => [],
                'sendEmail' => false
            ];
        }
    }
    foreach ($palavrasProibidasExatas as $palavra) {
        $palavra = strtolower(trim($palavra));
        $nome = strtolower(trim($nome));
        $palavraSemAcento = str_replace($acentos, $semAcento, $palavra);
        $nome = str_replace($acentos, $semAcento, $nome);

        if ($nome == $palavraSemAcento) {
            return [
                'result' => false,
                'message' => ['Nome contém palavras proibidas '.  $palavra],
                'data' => [],
                'sendEmail' => false
            ];
        }
    }
    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => false
    ];
}

function validar_CPF($selected)
{
    $cpf = trim($selected['data']['message']);

    $cpf = preg_replace('/\D/', '', $cpf);

    if (strlen($cpf) != 11) {
        return [
            'result' => false,
            'message' => ['CPF deve conter 11 dígitos'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return [
                'result' => false,
                'message' => ['CPF inválido'],
                'data' => [],
                'sendEmail' => false
            ];
        }
    }
    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => false
    ];
}

function validar_CNPJ($selected)
{
    $cnpj = trim($selected['data']['message']);

    $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

    if (strlen($cnpj) != 14) {
        return [
            'result' => false,
            'message' => ['CNPJ deve conter 14 dígitos'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    if (preg_match('/(\d)\1{13}/', $cnpj)) {
        return [
            'result' => false,
            'message' => ['CNPJ inválido, todos os dígitos são iguais'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
        return [
            'result' => false,
            'message' => ['CNPJ inválido'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
        $soma += $cnpj[$i] * $j;
        $j = ($j == 2) ? 9 : $j - 1;
    }

    $resto = $soma % 11;

    if ($cnpj[13] != ($resto < 2 ? 0 : 11 - $resto)) {
        return [
            'result' => false,
            'message' => ['CNPJ inválido'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => false
    ];
}
function validar_min_detalhes_mensagem($selected)
{
    $mensagem = trim($selected['data']['message']);
    $palavras = array_filter(explode(' ', $mensagem), fn($palavra) => !empty($palavra));

    if (count($palavras) < 5) {
        return [
            'result' => false,
            'message' => ['A mensagem deve conter no mínimo 5 palavras'],
            'data' => [],
            'sendEmail' => false
        ];
    }

    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => false
    ];
}
function fim_enviar_email($selected)
{
    return [
        'result' => true,
        'message' => [],
        'data' => [],
        'sendEmail' => true
    ];
}
