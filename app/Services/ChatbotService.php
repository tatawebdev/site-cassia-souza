<?php

namespace App\Services;

use App\Models\ChatbotAtendimento;
use App\Models\ChatbotConfigMessageInteractive;
use App\Models\ChatbotInteracaoChat;
use App\Models\ChatbotInteracaoUsuario;
use App\Models\ChatbotOption;
use App\Models\ChatbotStep;
use App\Services\GeminiService;
use App\Services\WhatsAppService;
use App\Services\Helpers;
use Illuminate\Support\Facades\Mail;
use App\Mail\ChatEmail;
use Illuminate\Support\Str;

class ChatbotService
{

    public $nomeUsuario = null;
    public $numeroUsuario;
    public $mensagemUsuario;
    public $mensagemId;
    public $event_type;
    public $interactiveId;
    public $last_message_id;
    public $updateStep = false;
    public $stopStep = false;
    protected GeminiService $gemini;
    protected WhatsAppService $whatsapp;

    public function __construct(GeminiService $gemini, WhatsAppService $whatsapp)
    {
        require_once app_path('Functions/validacoes.php');

        $this->gemini = $gemini;
        $this->whatsapp = $whatsapp;
    }

    public function processInput(array $data): void
    {
        // ChatbotInteracaoUsuario::truncate();

        if (empty($data['celular']) || empty($data['message'])) {
            return;
        }
        $this->nomeUsuario = $data['name'] ?? null;
        $this->numeroUsuario = $data['celular'] ?? null;
        $this->mensagemUsuario = $data['message'] ?? null;
        $this->mensagemId = $data['message_id'] ?? null;
        $this->event_type = $data['event_type'] ?? 'message_text';
        $this->interactiveId = $data['interactive_id'] ?? null;
        $this->updateStep = false;
        $resultado = $this->obterUsuarioEEtapa();


        $step = $resultado['step'] ?? null;
        $usuario = $resultado['usuario'] ?? null;



        // try {
        //     $notion = new NotionClient();
        //     $response = $notion->addTextToPage($this->mensagemUsuario, $usuario['notion']);

        // } catch (Exception $e) {
        //     $this->enviarMensagemWhatsApp(json_encode($e->getMessage()));
        // }


        ChatbotInteracaoChat::create([
            'usuario_id' => $usuario['usuario_id'],
            'mensagem' => $this->mensagemUsuario,
            'message_id' => $data['message_id'],
            'data' => json_encode([$data]),
            'remetente' => 'user',
            'id_step' => $step['id'] ?? null,
            'status_mensagem' => 'enviado',
            'data_envio' => date('Y-m-d H:i:s')
        ]);

        if (!!$usuario['notBot']) {
            // $this->sendFCMNotificationUser($this->mensagemUsuario);

            if (!!$usuario['aguardando']) {
                ChatbotInteracaoUsuario::update([
                    'id_flow' => null,
                    'id_step' => null,
                    'aguardando' => 0,
                    'tipo_interacao_esperado' => ''
                ], $usuario['interacoes_id']);
            }
            return;
        }

        if (!($step['id'] ?? false)) {
            return;
        }
        if ($data['event_type'] == "interactive") {
            $data['event_type'] = "message_interactive";
        }

        if (!!$usuario['aguardando']) {
            $tipoInteracaoCorreta = $data['event_type'] == $usuario['tipo_interacao_esperado'];
            if ($tipoInteracaoCorreta) {
                $this->processarEtapa($usuario, $step, $data);
            } else {
                ChatbotInteracaoChat::create([
                    'usuario_id' => $usuario['usuario_id'],
                    'mensagem' => "Selecione uma opção válida",
                    'remetente' => 'bot',
                    'status_mensagem' => 'enviado',
                    'id_step' => $usuario['id_step'],
                    'data_envio' => date('Y-m-d H:i:s')
                ]);
                $this->enviarMensagemWhatsApp("Selecione uma opção válida");
            }
        }
        if ($this->stopStep) {
            return;
        }
        if ($this->updateStep) {

            if (!!$step['nome_campo']) {
                ChatbotAtendimento::insertByNumeroCampoResposta($this->numeroUsuario, $step['nome_campo'], $data['message']);
            }
            $resultado = $this->obterUsuarioEEtapa();

            $step = $resultado['step'];
            $usuario = $resultado['usuario'];
        }

        $enviaremail = !$step['id_step_proximo'] && count($step['options']) == 0;



        $step['pergunta'] = Helpers::convertHtmlToWhatsApp($step['pergunta']);

        $enviodeInteracao = false;
        switch ($step['tipo_interacao']) {
            case 'message_button':
                // Divide a string de perguntas em partes
                $perguntas = explode("|", $step['pergunta']);

                // Envia todas as perguntas, exceto a última
                for ($i = 0; $i < count($perguntas) - 1; $i++) {
                    if (!!trim($perguntas[$i])) {
                        $enviodeInteracao = true;
                        $this->enviarMensagemWhatsApp($perguntas[$i]);
                    }
                }

                // Envia a última pergunta com botões
                $ultimaPergunta = trim(end($perguntas)); // Obtém a última pergunta
                if (!!$ultimaPergunta) {
                    $enviodeInteracao = true;
                    $this->enviarMensagemComBotoes($ultimaPergunta, $usuario['id_step']);
                }
                break;

            case 'message_interactive':
                $enviodeInteracao = true;
                $this->enviarListaInterativaComDados(
                    $usuario['id_step'],
                );
                break;

            default:
                // Para outros tipos de interação, envia todas as perguntas
                ChatbotInteracaoChat::create([
                    'usuario_id' => $usuario['usuario_id'],
                    'mensagem' => $step['pergunta'],
                    'remetente' => 'bot',
                    'status_mensagem' => 'enviado',
                    'id_step' => $usuario['id_step'],
                    'data_envio' => date('Y-m-d H:i:s')
                ]);
                $perguntas = explode("|", (trim($step['pergunta'], "|")));
                foreach ($perguntas as $perguntaIndividual) {
                    if (!!$perguntaIndividual) {
                        $this->enviarMensagemWhatsApp(trim($perguntaIndividual));
                        $enviodeInteracao = true;
                    }
                }
        }

        if ($enviaremail) {
            ChatbotInteracaoUsuario::where('id', $usuario['interacoes_id'])->update([
                'id_flow' => null,
                'id_step' => null,
                'aguardando' => 0,
                'tipo_interacao_esperado' => ''
            ]);

            $this->enviarEmailAtendimentobyNumber($this->numeroUsuario);

        }
        if ($enviodeInteracao) {
            if (isset($usuario['interacoes_id']))

                ChatbotInteracaoChat::create([
                    'usuario_id' => $usuario['usuario_id'],
                    'mensagem' => $step['pergunta'],
                    'remetente' => 'bot',
                    'status_mensagem' => 'enviado',
                    'id_step' => $usuario['id_step'],
                    'data_envio' => date('Y-m-d H:i:s')
                ]);
            if (!$enviaremail) {

                $interacaoUsuario = ChatbotInteracaoUsuario::find($usuario['interacoes_id']);
                if ($interacaoUsuario) {
                    $interacaoUsuario->update([
                        'aguardando' => 1,
                        'tipo_interacao_esperado' => $step['tipo_interacao']
                    ]);
                }
            }
        }

    }

    private function obterUsuarioEEtapa()
    {
        $usuario = ChatbotInteracaoUsuario::addUserAndInteraction($this->numeroUsuario, $this->nomeUsuario); // 0
        $step = ChatbotStep::with('options')->find($usuario['id_step'])->toArray();

        $step['nome_da_funcao'] = !empty($step['nome_da_funcao']) ? $step['nome_da_funcao'] : "proxima_etapa";

        return [
            'usuario' => $usuario,
            'step' => $step,
        ];
    }

    public function enviarMensagemWhatsApp($mensagem, $numero = null, $previewUrl = false)
    {
        if ($numero === null) {
            $numero = $this->numeroUsuario;
        }
        $this->whatsapp->sendMessageText($numero, $mensagem, $previewUrl);
    }

    public function processarEtapa($usuario, $step, $data)
    {
        switch ($data['event_type']) {
            case 'message_interactive':
            case 'message_button':
                $this->processarInteracaoEtapa($usuario, $step, $data);
                break;
            case 'message_text':
                $this->processarTextEtapa($usuario, $step, $data);
        }
    }
    //processarInteracaoEtapa
    public function processarInteracaoEtapa($usuario, $step, $data)
    {
        $interactive_id = $data['interactive_id'];

        // Filtrando as opções para verificar se a opção selecionada pelo usuário existe
        $resultado = array_filter($step['options'], function ($option) use ($interactive_id) {
            return $option['id'] == $interactive_id;
        });

        if (count($resultado) === 0) {
            $this->enviarMensagemWhatsApp("Você selecionou uma opção inválida.");
        } else {
            $id_step_proximo = ChatbotOption::where('id', $data['interactive_id'])
                ->first()['id_step_proximo'] ?? null;

            ChatbotInteracaoUsuario::updateStepById($usuario['interacoes_id'], $id_step_proximo);

            $this->updateStep = true;
        }
    }

    //processarTextEtapa
    public function processarTextEtapa($usuario, $step, $data)
    {

        if (function_exists($step['nome_da_funcao'])) {
            $step['step_id'] = $step['id'];
            unset($step['id']);
            $params = array_merge($step, $usuario);
            $params['data'] = $data;

            $resultado_validacao = call_user_func($step['nome_da_funcao'], $params);

            $this->stopStep = !$resultado_validacao['result'];
            if ($resultado_validacao['result']) {

                $id_step_proximo = $params['id_step_proximo'];
                ChatbotInteracaoUsuario::updateStepById($params['interacoes_id'], $id_step_proximo);
                $this->updateStep = true;
            } else {
                foreach ($resultado_validacao['message'] as $message) {
                    ChatbotInteracaoChat::create([
                        'usuario_id' => $usuario['usuario_id'],
                        'mensagem' => $message,
                        'remetente' => 'bot',
                        'status_mensagem' => 'enviado',
                        'id_step' => $usuario['id_step'],
                        'data_envio' => date('Y-m-d H:i:s')
                    ]);
                    // $this->enviarMensagemWhatsApp($message);
                }
            }
        }
    }


    public function enviarListaInterativaWhatsApp($tituloLista, $subtituloLista, $textoAgradecimento, $verOpcoes, $secoes, $numero = null)
    {
        if ($numero === null) {
            $numero = $this->numeroUsuario;
        }

        // Organiza as seções para o formato da API do WhatsApp
        $sections = [];
        foreach ($secoes as $item) {
            $title = $item['secao_titulo'] ?? 'Opções';
            $rowID = (string) $item['id'];
            $rowTitle = $item['titulo'];
            $rowDescription = $item['descricao'] ?? '';

            if (!isset($sections[$title])) {
                $sections[$title] = [
                    'title' => $title,
                    'rows' => [],
                ];
            }
            $sections[$title]['rows'][] = [
                'id' => $rowID,
                'title' => $rowTitle,
                'description' => $rowDescription,
            ];
        }

        // Reindexa para garantir que seja um array numérico
        $sections = array_values($sections);

        // Garantir que os argumentos obrigatórios tipados como string não sejam null
        $this->whatsapp->sendListMessage(
            $numero,
            (string) ($tituloLista ?? ''),
            (string) ($subtituloLista ?? ''),
            (string) ($textoAgradecimento ?? ''),
            $sections,
            (string) ($verOpcoes ?? 'Ver opções')
        );
    }

    public function enviarListaInterativaComDados($id_step, $numero = null)
    {
        $secoes = ChatbotOption::where('id_step', $id_step)
            ->get(['secao_titulo', 'id', 'titulo_interacao as titulo', 'descricao_interacao as descricao'])
            ->toArray();
        if (empty($secoes)) {
            return;
        }
        $config = ChatbotConfigMessageInteractive::where('id_step', $id_step)->first();

        if ($config) {
            $this->enviarListaInterativaWhatsApp(
                $config->texto_cabecalho,
                $config->texto_corpo,
                $config->texto_rodape,
                $config->texto_botao,
                $secoes,
                $numero
            );
        }
    }

    public function enviarBotoesMensagemWhatsApp($buttonText, $opcoes, $numero = null)
    {
        if ($numero === null) {
            $numero = $this->numeroUsuario;
        }

        $buttons = [];
        foreach ($opcoes as $key => $opcao) {
            $buttons[] = [
                'type' => 'reply',
                'reply' => [
                    'id' => $key,
                    'title' => Helpers::convertHtmlToWhatsApp($opcao['button']),
                ],
            ];
        }
        $this->enviarMensagemComBotoes($buttonText, $opcoes, $numero);
    }

    private function enviarMensagemComBotoes($buttonText, $id_step, $numero = null)
    {
        $buttons = ChatbotOption::getBotoesMensagemWhatsApp($id_step);

        if ($numero === null) {
            $numero = $this->numeroUsuario;
        }



        $this->whatsapp->sendButtonMessage($numero, $buttonText, $buttons);
    }

    public static function enviarEmailAtendimentobyNumber($numero)
    {
        $cnpj = ChatbotAtendimento::getCNPJByNumero($numero);
        $assuntoUsuario = ChatbotAtendimento::getAssuntoUsuarioByNumero($numero);
        $content = ChatbotAtendimento::getAllByNumero($numero)->toArray();
        ChatbotAtendimento::deleteByNumero($numero);

        $dados = [
            'assunto' => 'Chatbot do Whatsapp',
            'assuntoUsuario' => $assuntoUsuario,
            'numero_usuario' => $numero,
            'cnpj' => $cnpj,
        ];

        // Montar tabela de registros
        $numeroDigits = preg_replace('/[^0-9]/', '', $numero);
        $numeroFormatado = preg_replace('/(\d{2})(\d{2})(\d{5})(\d{4})/', '+$1 ($2) $3-$4', $numeroDigits);

        $tabela = '<table style="width: 100%; border-collapse: collapse;">';
        $tabela .= '<tr>
                <th style="padding: 10px; border: 1px solid #ccc; background:#f5f5f5;">Campo</th>
                <th style="padding: 10px; border: 1px solid #ccc; background:#f5f5f5;">Valor</th>
                </tr>';
        $tabela .= '<tr>
                <td style="padding: 10px; border: 1px solid #ccc;">WhatsApp</td>
                <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars($numeroFormatado) . '</td>
                </tr>';

        // Adiciona os dados brutos da solicitação
        if (!empty($content)) {
            foreach ($content as $row) {
                // Se existir nome_campo e resposta, exibe apenas esses campos
                if (isset($row['nome_campo']) && isset($row['resposta'])) {
                    $tabela .= '<tr>
                <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars(ucwords(str_replace('_', ' ', $row['nome_campo']))) . '</td>
                <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars($row['resposta']) . '</td>
                </tr>';
                } else {
                    // Caso contrário, exibe todos os campos normalmente
                    foreach ($row as $campo => $valor) {
                        $tabela .= '<tr>
                    <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars(ucwords(str_replace('_', ' ', $campo))) . '</td>
                    <td style="padding: 10px; border: 1px solid #ccc;">' . htmlspecialchars($valor) . '</td>
                </tr>';
                    }
                }
            }
        }

        $tabela .= '</table>';
        // Conteúdo AI
        $aiContentHtml = '';

        $html = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//PT' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>

        <html xmlns='http://www.w3.org/1999/xhtml' style='-webkit-text-size-adjust:none;'>
            <head>
                <meta charset='utf-8'/>
                <meta name='HandheldFriendly' content='true'/>
                <meta name='viewport' content='width=device-width; initial-scale=0.666667; maximum-scale=0.666667; user-scalable=0'/>
                <meta name='viewport' content='width=device-width'/>
                <title>" . $dados['assunto'] . "</title>

            </head>
            <body style='padding:25px 0 75px 0; background-color:#DFDFDF; margin:0 auto; width:100%; height:100%; font-family:Helvetica,Arial,sans-serif;'>
                <table border='0' cellspacing='0' align='center' cellpadding='0' style='border-collapse:collapse; margin:50px 0 0 0;' width='100%' height='100%' bgcolor='#DFDFDF'>
                    <tbody>
                        <tr>
                            <td>
                                <table align='center' width='600' bgcolor='#FFF'>
                                    <tr>
                                        <td style='background-color:#001f56; text-align:center;'>
                                            <h1 style='margin:20px 0; text-align:center; color:#FFF;'>" . $dados['assunto'] . "</h1>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='background-color:#FFF; text-align:left; padding:15px;font-size:14px;'>
                                            " . $aiContentHtml . "
                                            <h3 style='color:#001f56; text-align:center; margin-top: 20px;'>Dados Brutos da Solicitação e CNPJ</h3>
                                            " . $tabela . "
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>";

        try {
            $to = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS');
            Mail::to($to)
                ->bcc('suporte@tataweb.com.br')
                ->send(new ChatEmail($dados['assunto'] . $dados['assuntoUsuario'], $html));
        } catch (\Exception $e) {
            error_log('Erro ao enviar e-mail de atendimento: ' . $e->getMessage());
            return false;
        }

        return true;
    }


    // // Primeiro prompt (resumo) — pede texto simples
    // $prompt1 = "Atue como um assistente de advogado tributarista. Resuma a principal dúvida ou necessidade deste cliente de forma concisa, considerando o seguinte contexto:\n\n" . implode("\n", $messagesText);

    // try {
    //     $geminiText1 = $this->gemini->generateText($prompt1);
    //     $geminiResponse1 = $geminiText1 ? [$geminiText1] : [];
    // } catch (\Exception $e) {
    //     error_log("Erro ao integrar com GeminiAPI para resumo da dúvida: " . $e->getMessage());
    //     $geminiResponse1 = ["Não foi possível gerar o resumo da dúvida. Erro: " . $e->getMessage()];
    // }

    // // Segundo prompt (diagnóstico objetivo) — preferencialmente como markdown
    // $prompt2 = "Você é um analista tributário sênior. Sua tarefa é fornecer uma análise tributária extremamente objetiva e concisa, focando apenas nos detalhes úteis para uma advogada tributarista.\n\n" . implode("\n", $messagesText);

    // try {
    //     $geminiText2 = $this->gemini->generateMarkdown($prompt2);
    //     $geminiResponse2 = $geminiText2 ? [$geminiText2] : [];
    // } catch (\Exception $e) {
    //     error_log("Erro ao integrar com GeminiAPI para diagnóstico tributário: " . $e->getMessage());
    //     $geminiResponse2 = ["Não foi possível gerar o diagnóstico tributário. Erro: " . $e->getMessage()];
    // }



}
