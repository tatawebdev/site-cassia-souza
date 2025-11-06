<?php

use Models\FunctionModel;

session_start(); // Inicia a sessão no início do arquivo

// Incluir funções genéricas
require_once __DIR__ . '/functions/generic.php';


define('PATH_API_WHATSAPP', dirname(__DIR__, 1) . '/apiwhatsapp/');
define('PATH_LIBS_WHATSAPP', PATH_API_WHATSAPP . 'app/libs/whatsApp/');
define('PATH_CONFIG_WHATSAPP', PATH_API_WHATSAPP . 'app/config/');

// Definindo as constantes
define('PATH_VIEWS', __DIR__ . '/views/');
define('PATH_MODELS', __DIR__ . '/models/');
define('PATH_CONTROLLERS', __DIR__ . '/controllers/');

// Autoloading para as classes do namespace Models e Core
spl_autoload_register(function ($class) {
    $prefixes = [
        'Models\\' => __DIR__ . '/models/',
        'Middleware\\' => __DIR__ . '/middleware/',
        'Core\\' => __DIR__ . '/core/',
        'Controllers\\' => __DIR__ . '/controllers/'
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        // Verifica se a classe pertence ao namespace
        if (strncmp($prefix, $class, strlen($prefix)) === 0) {
            // Obtém o nome relativo da classe
            $relative_class = substr($class, strlen($prefix));


            $file = $base_dir . $relative_class . '.php';


            // Verifica se o arquivo existe e inclui
            if (file_exists($file)) {
                require $file;
            } else {
                throw new Exception("Arquivo não encontrado: $file");
            }
        }
    }
});



// Incluir o arquivo de rotas
require_once __DIR__ . '/routes/web.php';


// Pega a rota da URL
$request_uri = $_SERVER['REQUEST_URI'];

$route = parse_url($request_uri, PHP_URL_PATH);

if (getFileUpdateInfo()) {
    $functionModel = new FunctionModel();
    $functionModel->popularLista();
}
// Despacha a rota
try {
    \Core\Router::dispatch($route);
} catch (Exception $e) {
    // Em caso de erro, carrega a página 404
    // echo $e->getMessage();

    include PATH_VIEWS . '404.php';
}
