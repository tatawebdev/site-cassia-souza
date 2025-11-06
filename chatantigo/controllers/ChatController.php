<?php

namespace Controllers;

use ChatbotInteracoesUsuario;
use Models\ChatbotInteracoesChat;
use Models\ChatbotUsuario;
use Models\UserModel;
use WhatsApp\Message;

include_once PATH_CONFIG_WHATSAPP . 'env_loader.php';
include_once PATH_LIBS_WHATSAPP . 'Config.php';
include_once PATH_LIBS_WHATSAPP . 'ContactMessages.php';
include_once PATH_LIBS_WHATSAPP . 'CurlHttpClient.php';
include_once PATH_LIBS_WHATSAPP . 'InteractiveMessages.php';
include_once PATH_LIBS_WHATSAPP . 'Media.php';
include_once PATH_LIBS_WHATSAPP . 'Message.php';
include_once PATH_LIBS_WHATSAPP . 'WebhookProcessor.php';

class ChatController
{

    function ultimasMensagens()
    {
        $ChatbotUsuario = new ChatbotUsuario();

        $mensagens = $ChatbotUsuario->getUltimasMensagens($_POST['pagina'] ?? 1);

        echo json_encode(['status' => 'success', 'message' => 'Passo salvo com sucesso.', 'listMensagens' => $mensagens]);
    }
    function abrirMensagem()
    {
        $ChatbotInteracoesChat = new ChatbotInteracoesChat();

        $mensagens = $ChatbotInteracoesChat->getInteracoesByUsuarioId($_POST['idUser']);

        echo json_encode(['status' => 'success', 'message' => '1 salvo com sucesso.', 'mensagens' => $mensagens]);
    }
    function trocarAgente()
    {
        $ChatbotUsuario = new ChatbotUsuario();

        $ChatbotUsuario->update(['notBot' => $_POST['notBot']], $_POST['Userid']);


        echo json_encode(['status' => 'success', 'message' => '1 salvo com sucesso.']);
    }
    function enviarCurrentToken()
    {
        $userID = $_SESSION['user']['id'];
        $currentToken = $_POST['currentToken'];
        $UserModel = new UserModel();

        $UserModel->update(['tokenFCM' => $currentToken], $userID);
        echo json_encode(['status' => 'success', 'message' => 'Token salvo com sucesso.']);
    }

    function enviarMensagemWhatsApp()
    {
        $ChatbotUsuario = new ChatbotUsuario();
        $ChatbotUsuario->update(['notBot' => 1], $_POST['Userid']);

        $numero = $ChatbotUsuario->getTelefoneByID($_POST['Userid']);

        $objMensagem = Message::getInstance();
        $objMensagem->setRecipientNumber($numero);
        $objMensagem->sendMessageText($_POST['mensagem']);



        (new ChatbotInteracoesChat)->insert([
            'usuario_id' => $_POST['Userid'],
            'mensagem' => $_POST['mensagem'],
            'remetente' => 'botAgent',
            'status_mensagem' => 'enviado',
            'data_envio' => date('Y-m-d H:i:s')
        ]);

        echo json_encode(['status' => 'success', 'message' => 'Passo salvo com sucesso.', $numero]);
    }
    function chat()
    {
        view(['chat/index']);
    }
}
