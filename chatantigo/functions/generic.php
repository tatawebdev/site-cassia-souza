<?php
// functions/generic.php

// Função para sanitizar dados de entrada
function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)));
}

// Função para redirecionar para uma URL
function redirect($url)
{
    header("Location: $url");
    exit;
}

// Função para exibir mensagens
function flashMessage($message, $type = 'info')
{
    // Salva a mensagem na sessão
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

// Função para obter a mensagem da sessão
function getFlashMessage()
{
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'];
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

function dump($variable)
{
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

// Função para fazer dump de uma variável e encerrar a execução
function dd($variable)
{
    dump($variable);
    die; // Encerra a execução do script
}


// functions/view.php

/**
 * Função para renderizar uma view.
 *
 * @param string $view O nome da view a ser renderizada.
 * @param array $params Os parâmetros a serem passados para a view.
 */
function view(array $views, array $params = [])
{

    extract($params);
    // Renderiza cada view passada no array
    foreach ($views as $view) {
        // Caminho para o arquivo da view
        $viewPath = PATH_VIEWS . '/' . $view . '.php';

        if (file_exists($viewPath)) {
            include $viewPath; // Inclui a view
        }
    }
}



/**
 * Função para renderizar um template com várias views.
 *
 * @param array $views Um array de views a serem renderizadas.
 * @param array $params Os parâmetros a serem passados para as views.
 */
function template(array $views, array $params = [])
{
    // Extraí os parâmetros para que possam ser usados diretamente nas views
    extract($params);

    // Caminho para o arquivo do template
    $filePath = PATH_VIEWS . '/template/template.php';

    // Verifica se o arquivo do template existe
    if (file_exists($filePath)) {
        // Inicializa um container para as views renderizadas
        $MyViewContainer = '';

        // Renderiza cada view passada no array
        foreach ($views as $view) {
            // Caminho para o arquivo da view
            $viewPath = PATH_VIEWS . '/' . $view . '.php';

            // Verifica se o arquivo da view existe
            if (file_exists($viewPath)) {
                ob_start(); // Inicia o buffer de saída
                include $viewPath; // Inclui a view
                $MyViewContainer .= ob_get_clean(); // Armazena o conteúdo no container
            }
        }

        // Passa o conteúdo das views renderizadas para o template
        include $filePath; // Inclui o arquivo do template
    } else {
        // Se não encontrar o template, exibe uma mensagem de erro ou trata conforme necessário
        echo "Template não encontrado: $filePath";
    }
}

function getFileUpdateInfo()
{

    $filePath = realpath(__DIR__ . '/../..') . '/apiwhatsapp/app/helpers/validacoes.php';

    if (file_exists($filePath)) {
        // Obtém a última data de modificação do arquivo
        $lastModified = filemtime($filePath);
        $jsonFilePath = __DIR__ . '/last_update.json';

        // Lê o conteúdo do arquivo JSON
        $jsonData = [];
        if (file_exists($jsonFilePath)) {
            $jsonData = json_decode(file_get_contents($jsonFilePath), true);
        }

        // Verifica se a última modificação é diferente da registrada no JSON
        if (!isset($jsonData['lastUpdate']) || $jsonData['lastUpdate'] !== $lastModified) {
            $jsonData['lastUpdate'] = $lastModified;

            // Escreve a nova data de atualização no arquivo JSON
            file_put_contents($jsonFilePath, json_encode($jsonData, JSON_PRETTY_PRINT));

            // Retorna true se houve modificação
            return true;
        }

        // Retorna false se não houve modificação
        return false;
    }

    return null; // Retorna null se o arquivo não existe
}
