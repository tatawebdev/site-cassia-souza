<?php

use Controllers\AnalyticsController;
use Controllers\ChatController;
use Controllers\ConvertController;
use Controllers\FlowController;
use Controllers\FunctionController;
use Controllers\HelpController;
use Controllers\HomeController;
use Controllers\LoginController;
use Controllers\MessagesController;
use Controllers\UserSettingsController;
use Core\Router;
use Middleware\AuthMiddleware;

// Grupo de rotas públicas
Router::get('/login', [LoginController::class, 'index']);
Router::post('/login', [LoginController::class, 'realizarLogin']);

// Grupo de rotas protegidas por middleware
Router::middleware(AuthMiddleware::class); // Define o middleware para as próximas rotas

// Rotas da Home
Router::get(['/home', '/index', '/'], [HomeController::class, 'index']);

// Rotas de Fluxos
Router::get(['/flows'], [FlowController::class, 'listar']);
Router::get(['/create-flow'], [FlowController::class, 'criarForm']);
Router::post(['/create-flow'], [FlowController::class, 'criarFlow']);
Router::get(['/edit-flow'], [FlowController::class, 'editarForm']);
Router::post(['/edit-flow'], [FlowController::class, 'editarFlow']);
Router::get(['/delete-flow'], [FlowController::class, 'apagarForm']);
Router::post(['/delete-flow'], [FlowController::class, 'apagarFlow']);
Router::post('/update-flow-status', [FlowController::class, 'updateFlowStatus']);
Router::post('/update-flow-production', [FlowController::class, 'updateFlowProduction']);

// Rotas de Etapas
Router::post(['/steps/convert/button'], [ConvertController::class, 'button']);
Router::post(['/steps/convert/list/button'], [ConvertController::class, 'listTobutton']);
Router::post(['/steps/convert/text'], [ConvertController::class, 'text']);
Router::post(['/steps/convert/list'], [ConvertController::class, 'list']);
Router::post(['/steps/edit/list'], [ConvertController::class, 'editList']);
Router::post(['/steps/convert/config-message-interactive'], [ConvertController::class, 'configMessageInteractive']);
Router::post(['/steps/update/nodes'], [FlowController::class, 'stepsUpdateNodes']);
Router::post(['/steps/update/campo'], [FlowController::class, 'stepsUpdateCampo']);
Router::post(['/steps/update/invert'], [FlowController::class, 'stepsInvertNodes']);
Router::post(['/steps/update/configurar-resposta'], [FlowController::class, 'stepsConfigurarResposta']);
Router::post(['/steps/save'], [FlowController::class, 'stepsSave']);
Router::post(['/steps/delete'], [FlowController::class, 'stepsDelete']);
Router::post(['/steps/listar-tree-json'], [FlowController::class, 'listarTreeJson']);

Router::post(['/steps/get/option'], [ConvertController::class, 'getOption']);




// Rotas de Interações
Router::post(['/list-interations-json'], [FlowController::class, 'listInterationsJson']);
Router::get(['/create-interations'], [FlowController::class, 'createForm']);
Router::post(['/create-interations'], [FlowController::class, 'createInterations']);
Router::post(['/delete-interations'], [FlowController::class, 'deleteInterations']);

// Rota para Visualizar Fluxo
Router::get(['/view-flow'], [FlowController::class, 'visualizar']);

// Rotas de Configurações de Usuário
Router::get(['/user-settings'], [UserSettingsController::class, 'index']);

// Rotas de Mensagens
Router::get(['/messages'], [MessagesController::class, 'index']);

// Rotas de Análise
Router::get(['/analytics'], [AnalyticsController::class, 'index']);

// Rotas de Ajuda
Router::get(['/help'], [HelpController::class, 'index']);

// Rota para Salvar Fluxo
Router::post('/save-flow', [FlowController::class, 'save']);

// Rotas de Funções
Router::get('/functions/popular-lista', [FunctionController::class, 'popularLista']);
Router::get('/functions/list/json', [FunctionController::class, 'listaJson']);



Router::get('/chat', [ChatController::class, 'chat']);
Router::post('/chat/ultimas-mensagens', [ChatController::class, 'ultimasMensagens']);
Router::post('/chat/abrir-mensagem', [ChatController::class, 'abrirMensagem']);
Router::post('/chat/enviar-mensagem-whatsapp', [ChatController::class, 'enviarMensagemWhatsApp']);
Router::post('/chat/enviar-currentToken', [ChatController::class, 'enviarCurrentToken']);
Router::post('/chat/trocar-agente', [ChatController::class, 'trocarAgente']);



