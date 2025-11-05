<?php

namespace App\Services\Legacy;

use App\Models\Legacy\ChatbotInteracoesUsuario;
use App\Models\Legacy\ChatbotInteracoesChat;
use App\Models\Legacy\ChatbotAtendimento;
use App\Models\Legacy\ChatbotSteps;
use App\Models\Legacy\ChatbotOptions;
use App\Models\Legacy\ChatboConfigMessageInteractive;
use App\Models\Legacy\Users as LegacyUsers;
use App\Services\GeminiService;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class NewChatbotService
{
    protected GeminiService $gemini;
    protected WhatsAppService $whatsapp;

    public function __construct(GeminiService $gemini, WhatsAppService $whatsapp)
    {
        $this->gemini = $gemini;
        $this->whatsapp = $whatsapp;
    }

    /**
     * Processa a entrada do webhook/recebimento e segue a lógica do antigo newChatbot::processarEntrada
     * Espera array $data com chaves: celular, message, message_id, name, event_type, interactive_id
     */
    public function processInput(array $data): void
    {
        if (empty($data['celular']) || empty($data['message'])) {
            return;
        }

        $nomeUsuario = $data['name'] ?? null;
        $numeroUsuario = $data['celular'];
        $mensagemUsuario = $data['message'];
        $eventType = $data['event_type'] ?? 'message_text';

        // Adiciona usuário e interação (cria se não existir)
        $usuarioRaw = ChatbotInteracoesUsuario::addUserAndInteraction($numeroUsuario, $nomeUsuario);


        $interacao = $usuarioRaw['interacao'] ?? null;
        $step = $interacao['id_step'] ?? null;

        switch ($step) {
            case null:
                $this->etapa1($numeroUsuario);
                // Atualiza o passo diretamente usando Eloquent
                ChatbotInteracoesUsuario::where('id_usuario', $usuarioRaw['usuario']['id'])
                    ->update(['id_step' => 2]);
                break;
            case 2:
                $this->etapa2($numeroUsuario);
                ChatbotInteracoesUsuario::where('id_usuario', $usuarioRaw['usuario']['id'])
                    ->update(['id_step' => 3]);
                break;
            case 3:
                $this->etapa3($numeroUsuario);
                ChatbotInteracoesUsuario::where('id_usuario', $usuarioRaw['usuario']['id'])
                    ->update(['id_step' => 4]);
                break;
            case 4:
                $this->etapa4($numeroUsuario);
                ChatbotInteracoesUsuario::where('id_usuario', $usuarioRaw['usuario']['id'])
                    ->update(['id_step' => 5]);
                break;
            case 5:
                $this->etapa5($numeroUsuario);
                // Final step, no update
                break;
        }



    }



    //etapa1 return <p>Olá! Sou o assistente virtual da Cassia Souza Advocacia Tributária ⚖️&nbsp;</p><p>Estou aqui para compreender a sua demanda e direcioná-la da melhor maneira possível.&nbsp;</p><p><br></p><hr contenteditable="false"><p><br></p><p>Para isso, por favor, responda apenas 5 perguntas para eu lhe encaminhar ao atendimento mais adequado.&nbsp;</p><p><br></p><hr contenteditable="false"><p><span style="color: rgb(0, 0, 0);">Por favor, informe o seu nome.&nbsp;</span></p>

    public function etapa1($numeroUsuario): void
    {
        $mensagem1 = 'Olá! Sou o assistente virtual da Cassia Souza Advocacia Tributária ⚖️';

        $mensagem2 = 'Estou aqui para compreender a sua demanda e direcioná-la da melhor maneira possível. Para isso, por favor, responda apenas 5 perguntas para eu lhe encaminhar ao atendimento mais adequado.';

        $mensagem3 = 'Por favor, informe o seu nome.';


        $this->whatsapp->sendMessageText($numeroUsuario, strip_tags($mensagem1));
        $this->whatsapp->sendMessageText($numeroUsuario, strip_tags($mensagem2));
        $this->whatsapp->sendMessageText($numeroUsuario, strip_tags($mensagem3));

    }

    // Etapa 2: Solicita o nome do usuário (message_text)
    public function etapa2($numeroUsuario): void
    {
        $mensagem = 'Por favor, informe o seu nome.';
        $this->whatsapp->sendMessageText($numeroUsuario, strip_tags($mensagem));
    }

    // Etapa 3: Seleção do assunto da consulta (message_interactive)
    public function etapa3($numeroUsuario): void
    {
        $texto = 'Selecione o assunto da sua consulta:';
        $botoes = [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '29',
                    'title' => 'Dívidas Tributárias',
                    'description' => 'Consultas sobre dívidas fiscais e tributos em aberto.',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '30',
                    'title' => 'Planejamento Tributário',
                    'description' => 'Estratégias para otimizar a carga tributária.',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '31',
                    'title' => 'Execução Fiscal',
                    'description' => 'Ações judiciais relacionadas à cobrança de tributos.',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '32',
                    'title' => 'Consultoria Tributária',
                    'description' => 'Orientação especializada sobre legislação tributária.',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '33',
                    'title' => 'Assuntos Tributários',
                    'description' => 'Outros temas relacionados a tributos.',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '34',
                    'title' => 'Assuntos Não Tributários',
                    'description' => 'Consultas que não envolvem questões tributárias.',
                ],
            ],
        ];
        $sections = [
            [
                'title' => 'Assuntos disponíveis',
                'rows' => array_map(function ($botao) {
                    return [
                        'id' => $botao['reply']['id'],
                        'title' => $botao['reply']['title'],
                        'description' => $botao['reply']['description'] ?? '',
                    ];
                }, $botoes),
            ],
        ];
        $this->whatsapp->sendListMessage(
            $numeroUsuario,
            $texto,
            'Escolha uma das opções abaixo:',
            'Cassia Souza Advocacia',
            $sections,
            'Ver opções'
        );
    }



    // Etapa 4: Solicita detalhes da dúvida (message_text)
    public function etapa4($numeroUsuario): void
    {
        $mensagem = 'Poderia detalhar a sua dúvida para que possamos oferecer uma orientação mais adequada?';
        $this->whatsapp->sendMessageText($numeroUsuario, strip_tags($mensagem));
    }

    // Etapa 5: Seleção do tipo de pessoa (message_button)
    public function etapa5($numeroUsuario): void
    {
        $texto = 'Por favor, informe se a sua consulta é para uma Pessoa Física ou Pessoa Jurídica:';
        $botoes = [
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '35',
                    'title' => 'Pessoa Física',
                ],
            ],
            [
                'type' => 'reply',
                'reply' => [
                    'id' => '36',
                    'title' => 'Pessoa Jurídica',
                ],
            ],
        ];
        $this->whatsapp->sendButtonMessage($numeroUsuario, $texto, $botoes);
    }



}
