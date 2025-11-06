<?php

namespace Controllers;

use Models\ChatboConfigMessageInteractive;
use Models\OptionModel;
use Models\StepModel;

class ConvertController
{
    public function listTobutton()
    {


        $stepModel = new StepModel();

        // Atualiza o passo atual para o próximo
        $stepModel->update(['id_step_proximo' => null, 'tipo_interacao' => 'message_button'], $_POST['stepID']);

        $optionModel = new OptionModel();

        // Atualiza o passo relacionado
        $optionModel->updateWhere([
            'descricao_interacao' => '',
            'secao_titulo' => '',
            'tipo_interacao' => 'message_button',
        ], [
            'id_step' => $_POST['stepID'],
        ]);

        // Retorna a resposta ao usuário
        exit(json_encode([
            'success' => true,
            'message' => 'A conversão para botão foi gerada.',
        ]));
    }

    public function getOption()
    {
        $optionModel = new OptionModel();
        $existingOption = $optionModel->whereOne(['id' => $_POST['optionID']]);

        if (!$existingOption) {
            $message = "Opção não encontrada.";
        } else {
            $message = "Opção encontrada com sucesso.";
        }

        exit(json_encode([
            'success' => !!$existingOption,
            'message' => $message,
            'data' => $existingOption
        ]));
    }

    public function configMessageInteractive()
    {
        $chatboConfigMessageInteractive = new ChatboConfigMessageInteractive();

        // Verifica se a configuração já existe
        $existingConfig = $chatboConfigMessageInteractive->whereOne(['id_step' => $_POST['stepID']]);

        if (!$existingConfig) {
            $message = "Nenhuma configuração encontrada para este passo.";
        } else {
            $message = "Configuração encontrada com sucesso.";
        }

        exit(json_encode([
            'success' => !!$existingConfig,
            'message' => $message,
            'data' => $existingConfig // Adiciona os dados da configuração existente
        ]));
    }

    public function list()
    {
        // exit(json_encode([
        //     'success' => true,
        //     'message' => 'Interação criada com sucesso!'
        // ]));

        $stepModel = new StepModel();

        $step = $stepModel->whereOne(['id' => $_POST['stepID']]);

        if (!$step) {
            exit(json_encode([
                'success' => false,
                'message' => 'Etapa não encontrado!'
            ]));
        }

        $chatboConfigMessageInteractive = new ChatboConfigMessageInteractive();

        $existingConfig = $chatboConfigMessageInteractive->whereOne(['id_step' => $_POST['stepID']]);

        $data = [
            'id_step' => $_POST['stepID'],
            'texto_cabecalho' => $_POST['headerText'] ?? '',
            'texto_corpo' => $_POST['bodyText'] ?? '',
            'texto_rodape' => $_POST['footerText'] ?? '',
            'texto_botao' => $_POST['buttonText'] ?? '',
        ];

        if (!$existingConfig) {
            $chatboConfigMessageInteractive->insert($data);
        } else {
            $chatboConfigMessageInteractive->update($data, $existingConfig['id']);
        }



        $stepModel = new StepModel();

        $stepModel->update(['pergunta' => $_POST['headerText'] ?? ''],  $_POST['stepID']);


        $optionModel = new OptionModel();

        $data = [
            'id_step' => $_POST['stepID'],
            'titulo_interacao' => $_POST['listaTituloInteracao'] ?? null,
            'tipo_interacao' => 'message_interactive',
            'descricao_interacao' => $_POST['listaDescricaoInteracao'] ?? null,
            'secao_titulo' => $_POST['listaSecaoTitulo'] ?? null,
            'id_step_proximo' => $step['id_step_proximo'] ?? null,
        ];

        $optionCreated = $optionModel->create($data);

        // Verifica se a criação da opção foi bem-sucedida
        if (!$optionCreated) {
            exit(json_encode([
                'success' => false,
                'message' => 'Erro ao criar a interação!'
            ]));
        }

        $stepModel->update(['id_step_proximo' => null, 'tipo_interacao' => 'message_interactive'], $_POST['stepID']);

        // Retorna uma resposta de sucesso
        exit(json_encode([
            'success' => true,
            'message' => 'Interação criada com sucesso!'
        ]));
    }
    public function editList()
    {
        // Verifica se o campo de configuração ou nova opção está definido como 'true'
        $editConfi = $_POST['interacoesModalConfig']['config'] == 'true';
        $editOption = $_POST['interacoesModalConfig']['novo'] == 'true';

        // Variável para armazenar a mensagem
        $message = '';

        if ($editConfi) {
            // Atualiza a configuração existente
            $chatboConfigMessageInteractive = new ChatboConfigMessageInteractive();
            $config = $chatboConfigMessageInteractive->whereOne(['id_step' => $_POST['stepID']]);

            $stepModel = new StepModel();

            $stepModel->update(['pergunta' => $_POST['headerText'] ?? ''],  $_POST['stepID']);

            $data = [
                'texto_cabecalho' => $_POST['headerText'] ?? '',
                'texto_corpo' => $_POST['bodyText'] ?? '',
                'texto_rodape' => $_POST['footerText'] ?? '',
                'texto_botao' => $_POST['buttonText'] ?? '',
            ];

            $chatboConfigMessageInteractive->update($data, $config['id']);

            // Mensagem de sucesso ao atualizar a configuração
            $message .= 'Configuração atualizada com sucesso. ';
        }

        if ($editOption) {
            if (isset($_POST['listaID'])) {
                // Atualiza a opção existente
                $optionModel = new OptionModel();
                $optionModel->update([
                    'titulo_interacao' => $_POST['listaTituloInteracao'],
                    'descricao_interacao' => $_POST['listaDescricaoInteracao'],
                    'secao_titulo' => $_POST['listaSecaoTitulo'],
                ], $_POST['listaID']);

                // Mensagem de sucesso ao atualizar a opção
                $message .= 'Opção editada com sucesso. ';
            }
        }

        // Retorna uma resposta JSON com sucesso e a mensagem adequada
        exit(json_encode([
            'success' => true,
            'message' => trim($message) // Remove espaços extras da mensagem
        ]));
    }

    public function text()
    {
        $stepModel = new StepModel();
        $optionModel = new OptionModel();

        if ($_POST['id_option'] == null) {
            $resultOneOption = $optionModel->whereOne(['id_step' => $_POST['id_step']]);
        } else {
            $resultOneOption = $optionModel->whereOne(['id' => $_POST['id_option']]);
        }




        // Verifica se a opção foi encontrada
        if ($resultOneOption) {
            // Deleta a opção encontrada
            $optionModel->delete($_POST['id_option']);

            // Atualiza o passo relacionado
            $stepModel->update([
                'id_step_proximo' => $resultOneOption['id_step_proximo'],
                'tipo_interacao' => 'message_text'
            ], $_POST['id_step']);

            $chatboConfigMessageInteractive = new ChatboConfigMessageInteractive();
            $chatboConfigMessageInteractive->deleteWhere(['id_step' => $_POST['id_step']]);
            // Retorna sucesso na operação
            exit(json_encode([
                'success' => true,
                'message' => 'Opção excluída e passo atualizado com sucesso!'
            ]));
        }

        // Retorna erro se a opção não foi encontrada
        exit(json_encode([
            'success' => false,
            'message' => 'Opção não encontrada!'
        ]));
    }
    public function button()
    {
        $stepModel = new StepModel();
        $optionModel = new OptionModel();

        // Obtendo o passo com base no ID
        $result = $stepModel->whereOne(['id' => $_POST['id_step']]);

        // Verifica se o resultado foi encontrado
        if (!$result) {
            exit(json_encode([
                'success' => false,
                'message' => 'Passo não encontrado!'
            ]));
        }

        // Preparando os dados para a nova opção
        $data = [
            'id_step' => $_POST['id_step'],
            'titulo_interacao' => $_POST['titulo_interacao'] ?? null,
            'tipo_interacao' => $_POST['tipo_interacao'] ?? null,
            'descricao_interacao' => $_POST['descricao_interacao'] ?? null,
            'secao_titulo' => $_POST['secao_titulo'] ?? null,
            'id_step_proximo' => $result['id_step_proximo'] ?? null,
        ];

        // Criando a nova opção
        $optionCreated = $optionModel->create($data);

        // Verifica se a criação da opção foi bem-sucedida
        if (!$optionCreated) {
            exit(json_encode([
                'success' => false,
                'message' => 'Erro ao criar a interação!'
            ]));
        }

        // Atualiza o passo, caso a opção tenha sido criada com sucesso
        $stepModel->update(['id_step_proximo' => null, 'tipo_interacao' => $_POST['tipo_interacao']], $_POST['id_step']);

        // Retorna uma resposta de sucesso
        exit(json_encode([
            'success' => true,
            'message' => 'Interação criada com sucesso!'
        ]));
    }
}
