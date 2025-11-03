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

        // Normaliza estrutura: junta dados do usuário com dados da interação para compatibilidade com código legado
        $usuario = [];
        if (is_array($usuarioRaw['usuario'] ?? null)) {
            $usuario = array_merge($usuario, $usuarioRaw['usuario']);
        }
        if (is_array($usuarioRaw['interacao'] ?? null)) {
            $usuario = array_merge($usuario, $usuarioRaw['interacao']);
        }

        // Obtém step
        $step = (new ChatbotSteps())->getStepById($usuario['id_step'] ?? null) ?: [];

        // Salva mensagem do usuário
        ChatbotInteracoesChat::create([
            'usuario_id' => $usuario['usuario_id'] ?? null,
            'mensagem' => $mensagemUsuario,
            'message_id' => $data['message_id'] ?? null,
            'data' => json_encode([$data]),
            'remetente' => 'user',
            'id_step' => $step['id'] ?? null,
            'status_mensagem' => 'enviado',
            'data_envio' => now(),
        ]);

        // Se não for bot (notBot) encaminha para FCM / equipe
        if (!empty($usuario['notBot'])) {
            // Envia notificação para equipe via FCM (helper legacy may exist); aqui apenas log
            Log::info('Usuario marcado como notBot, encaminhar para equipe', ['numero' => $numeroUsuario, 'mensagem' => $mensagemUsuario]);

            // Reset aguardando se necessário
            if (!empty($usuario['aguardando'])) {
                ChatbotInteracoesUsuario::updateStepById($usuario['interacoes_id'], null, false);
            }

            return;
        }

        // Se IA ativa
        if (!empty($usuario['ia'])) {
            $prompt = $this->buildGeminiPrompt($mensagemUsuario);
            try {
                $responseBody = $this->gemini->generate($prompt, ['responseMimeType' => 'text/markdown']);
                $text = $responseBody ? \App\Services\GeminiService::extractGeneratedText($responseBody) : null;
                if ($text) {
                    // Envia via WhatsApp
                    $this->whatsapp->sendMessageText($numeroUsuario, $text);

                    // pode salvar no histórico de chat se quiser
                    ChatbotInteracoesChat::create([
                        'usuario_id' => $usuario['usuario_id'] ?? null,
                        'mensagem' => $text,
                        'remetente' => 'ia',
                        'status_mensagem' => 'enviado',
                        'id_step' => $usuario['id_step'] ?? null,
                        'data_envio' => now(),
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Erro Gemini: ' . $e->getMessage());
            }

            if (!empty($usuario['aguardando'])) {
                ChatbotInteracoesUsuario::updateStepById($usuario['interacoes_id'], null, false);
            }

            return;
        }

        // Se não há step definido, encerra
        if (empty($step['id'])) {
            return;
        }

        // Ajusta event_type para compatibilidade
        if ($eventType === 'interactive') {
            $eventType = 'message_interactive';
        }

        // Verifica se usuário estava aguardando um tipo de interação específica
        if (!empty($usuario['aguardando'])) {
            $tipoEsperado = $usuario['tipo_interacao_esperado'] ?? null;
            if ($eventType !== $tipoEsperado) {
                $this->whatsapp->sendMessageText($numeroUsuario, 'Selecione uma opção válida');
                return;
            }
        }

        // Processa inputs interativos/texto
        if ($eventType === 'message_interactive' || $eventType === 'message_button') {
            $this->processarInteracaoEtapa($usuario, $step, $data, $numeroUsuario);
        } else { // message_text
            $this->processarTextEtapa($usuario, $step, $data, $numeroUsuario);
        }
    }

    protected function buildGeminiPrompt(string $userMessage): string
    {
        return "Você é um chatbot interagindo com um cliente. Responda objetivamente.\n\n" . $userMessage;
    }

    protected function processarTextEtapa(array $usuario, array $step, array $data, string $numero)
    {
        // Se existir função de validação no contexto Laravel, poderíamos invocar através de callbacks; por ora, assume sucesso
        $nomeFunc = $step['nome_da_funcao'] ?? null;
        if ($nomeFunc && function_exists($nomeFunc)) {
            $params = array_merge($step, $usuario);
            $params['data'] = $data;
            $resultado_validacao = call_user_func($nomeFunc, $params);
            if (!empty($resultado_validacao['result'])) {
                $idStepProximo = $params['id_step_proximo'] ?? null;
                ChatbotInteracoesUsuario::updateStepById($params['interacoes_id'], $idStepProximo);
            } else {
                foreach ($resultado_validacao['message'] as $m) {
                    $this->whatsapp->sendMessageText($numero, $m);
                }
            }
        } else {
            // Sem validação, assumimos avanço
            if (!empty($step['nome_campo'])) {
                ChatbotAtendimento::insertByNumeroCampoResposta($numero, $step['nome_campo'], $data['message'] ?? null);
            }
            // atualiza para proximo step se houver
            $idStepProximo = $step['id_step_proximo'] ?? null;
            if ($idStepProximo) {
                ChatbotInteracoesUsuario::updateStepById($usuario['interacoes_id'], $idStepProximo);
            }
        }
    }

    protected function processarInteracaoEtapa(array $usuario, array $step, array $data, string $numero)
    {
        $interactiveId = $data['interactive_id'] ?? ($data['message'] ?? null);

        // Verifica se opção existe
        $opcoes = $step['options'] ?? [];
        $found = null;
        foreach ($opcoes as $opt) {
            if ((string)($opt['id'] ?? '') === (string)$interactiveId) {
                $found = $opt;
                break;
            }
        }

        if (!$found) {
            $this->whatsapp->sendMessageText($numero, 'Você selecionou uma opção inválida.');
            return;
        }

        $option = ChatbotOptions::getOptionById($interactiveId);
        $idStepProximo = null;
        if ($option) {
            if (is_array($option)) {
                $idStepProximo = $option['id_step_proximo'] ?? null;
            } else {
                $idStepProximo = $option->id_step_proximo ?? null;
            }
        }
        ChatbotInteracoesUsuario::updateStepById($usuario['interacoes_id'], $idStepProximo);
    }

    /**
     * Envia lista interativa baseada na configuração e nas opções
     */
    public function enviarListaInterativaComDados(int $id_step, string $numero)
    {
        $secoes = ChatbotOptions::getListaInterativaWhatsApp($id_step);
        if (empty($secoes)) return;

        $config = (new ChatboConfigMessageInteractive())->where('id_step', $id_step)->first();
        if (!$config) return;

        // Convert sections to WhatsApp API structure
        $waSections = [];

        // If $secoes is a flat list of rows (most likely), wrap into one section
        $first = $secoes[0] ?? null;
        if ($first && isset($first['id'])) {
            $rows = [];
            foreach ($secoes as $item) {
                $rows[] = [
                    'id' => (string)($item['id'] ?? ''),
                    'title' => $item['title'] ?? $item['titulo_interacao'] ?? '',
                    'description' => $item['description'] ?? '',
                ];
            }
            $waSections[] = ['title' => $config->texto_cabecalho ?? 'Opções', 'rows' => $rows];
        } else {
            // Otherwise assume it's already grouped as sections
            foreach ($secoes as $sec) {
                $rows = [];
                foreach ($sec as $item) {
                    $rows[] = [
                        'id' => (string)($item['id'] ?? ''),
                        'title' => $item['title'] ?? $item['titulo_interacao'] ?? '',
                        'description' => $item['description'] ?? '',
                    ];
                }
                $waSections[] = ['title' => $sec['secao_titulo'] ?? 'Opções', 'rows' => $rows];
            }
        }

        $this->whatsapp->sendListMessage($numero, $config->texto_cabecalho ?? '', $config->texto_corpo ?? '', $config->texto_rodape ?? '', $waSections, $config->texto_botao ?? 'Ver opções');
    }
}
