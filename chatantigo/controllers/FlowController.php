<?php

namespace Controllers;

use Models\ChatboConfigMessageInteractive;
use Models\Flow;
use Models\FlowModel;
use Models\OptionModel;
use Models\StepModel;

class FlowController
{
    public function visualizar()
    {

        $flowId = intval($_GET['id']);
        template(['view-flow'], ['flowId' => $flowId]);
    }
    public function listarTreeJson()
    {
        $flowId = intval($_GET['id']);
        $flowModel  = new FlowModel();
        $flow = $flowModel->find($flowId);

        $stepModel = new StepModel();
        $steps = $stepModel->buildTree($flowId);
        echo json_encode(['status' => 'success', 'tree' => $stepModel->renderTree($steps, ($flow['nome'] ?? 'Fluxo sem nome'), $flowId)]);
    }
    public function listInterationsJson()
    {

        $id_step = intval($_GET['id_step']);
        $optionModel = new OptionModel();
        $options = $optionModel->getOptionsForStep($id_step);

        echo json_encode($options);
    }
    public function listar()
    {
        $flow = new FlowModel();
        template(['list-flow'], ['lista' => $flow->getAll()]);
    }
    public function criarForm()
    {
        $flow = new FlowModel();
        template(['create-flow'], ['lista' => $flow->getAll()]);
    }
    public function stepsUpdateCampo()
    {
        // Verifica se o método da requisição é POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Verifica se os campos necessários foram enviados
            if (!isset($_POST['id_step']) || !isset($_POST['nome_campo'])) {
                exit(json_encode([
                    'status' => 'error',
                    'message' => 'Os campos "id_step" e "nome_campo" são obrigatórios.',
                    'data' => $_POST
                ]));
            }

            $idStep = $_POST['id_step'];
            $nomeCampo = $_POST['nome_campo'];

            // Validações básicas
            if (empty($idStep) || empty($nomeCampo)) {
                exit(json_encode([
                    'status' => 'error',
                    'message' => 'Os campos não podem estar vazios.',
                    'data' => $_POST
                ]));
            }

            try {
                // Instancia o modelo e executa a atualização
                $model = new StepModel();
                $updateResult = $model->update(['nome_campo' => $nomeCampo], $idStep);

                // Verifica se a atualização foi bem-sucedida
                if ($updateResult) {
                    exit(json_encode([
                        'status' => 'success',
                        'message' => 'Campo atualizado com sucesso.',
                        'data' => ['id_step' => $idStep, 'nome_campo' => $nomeCampo]
                    ]));
                } else {
                    exit(json_encode([
                        'status' => 'error',
                        'message' => 'Não foi possível atualizar o campo. Verifique os dados fornecidos.',
                        'data' => $_POST
                    ]));
                }
            } catch (\Exception $e) {
                // Captura qualquer exceção e retorna uma mensagem de erro
                exit(json_encode([
                    'status' => 'error',
                    'message' => 'Ocorreu um erro ao atualizar o campo: ' . $e->getMessage(),
                    'data' => $_POST
                ]));
            }
        }

        // Retorna erro caso o método HTTP não seja POST
        exit(json_encode([
            'status' => 'error',
            'message' => 'Método não permitido. Use POST.',
            'data' => []
        ]));
    }
    public function stepsUpdateNodes()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nodes'])) {

            (new FlowModel)->resetStepsAndOptions($_POST['id_flow']);

            foreach ($_POST['nodes'] as $node) {
                try {
                    $model = ($node['table'] === 'steps') ? new StepModel() : new OptionModel();
                    $id = $node['table'] === 'steps' ? $node['id_step'] : $node['id_option'];

                    $model->update(['id_step_proximo' => $node['id_step_proximo']], $id);
                } catch (\Exception $e) {
                    exit(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
                }
            }
            exit(json_encode(['status' => 'success', 'message' => 'Atualização realizada com sucesso']));
        }
        exit(json_encode(['status' => 'error', 'message' => 'Requisição inválida.', $_POST]));
    }
    public function stepsConfigurarResposta()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stepModel = new StepModel();

            if (isset($_POST['id_step']) && isset($_POST['nome_da_funcao'])) {
                $result = $stepModel->update(['nome_da_funcao' => $_POST['nome_da_funcao']], $_POST['id_step']);

                if ($result) {
                    exit(json_encode(['status' => 'success', 'message' => 'Fluxo atualizado com sucesso.']));
                } else {
                    exit(json_encode(['status' => 'error', 'message' => 'Falha ao atualizar o fluxo.']));
                }
            } else {
                exit(json_encode(['status' => 'error', 'message' => 'ID do passo ou nome da função não fornecidos.']));
            }
        } else {
            exit(json_encode(['status' => 'error', 'message' => 'Método não permitido.']));
        }
    }
    public function stepsInvertNodes()
    {
        // Verifica se a requisição é do tipo POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $flowId = intval($_POST['id_flow']);
            $id1 = intval($_POST['id1']);
            $id2 = intval($_POST['id2']);

            // Carrega o modelo do fluxo
            $flowModel = new FlowModel();
            $flow = $flowModel->where(['id' => $flowId]);

            // Verifica se o fluxo existe
            if (empty($flow)) {
                exit(json_encode(['status' => 'error', 'message' => 'Fluxo não encontrado.']));
            }

            $flow = $flow[0];


            // Carrega o modelo de passos e tenta inverter os IDs
            $stepModel = new StepModel();
            $result = $stepModel->swapIds($id1, $id2, 'id_step_proximo');

            // Verifica se a operação de troca foi bem-sucedida
            if ($result) {
                // var_dump(       $flow );
                if ($flow['id_step_inicial'] == $_POST['id1']) {
                    $flowModel->update(['id_step_inicial' => $_POST['id2']], $flowId);
                }


                exit(json_encode(['status' => 'success', 'message' => 'Passos invertidos com sucesso.']));
            } else {
                exit(json_encode(['status' => 'error', 'message' => 'Erro ao inverter passos.']));
            }
        } else {
            exit(json_encode(['status' => 'error', 'message' => 'Requisição inválida.']));
        }
    }
    public function updateFlowStatus()
    {
        $data = $_POST;

        if (isset($data['id']) && isset($data['status'])) {
            $flowId = $data['id'];
            $newStatus = $data['status'];

            $flowModel = new FlowModel();

            if ($newStatus == 1) {
                // Desativar todos os outros fluxos
                $flowModel->updateWithoutWhere(['atual' => 0]);

                // Atualizar o status do fluxo atual
                $flowModel->update(['atual' => $newStatus], $flowId);
                echo json_encode(['status' => 'success', 'message' => 'O fluxo foi ativado com sucesso!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'A desativação não é permitida. Selecione outro fluxo.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Os campos ID e status são obrigatórios. Por favor, preencha todos os campos corretamente.']);
        }
    }
    public function updateFlowProduction()
    {
        $data = $_POST;

        // Verifica se os dados necessários estão presentes
        if (isset($data['id']) && isset($data['teste'])) {
            $flowId = $data['id'];
            $newTeste = $data['teste'];

            $flowModel = new FlowModel();

            // Verifica se já existe um fluxo em modo teste
            $existingFlow = !!$newTeste && $flowModel->whereOne(['teste' => 1]);

            if (!$existingFlow) {
                // Atualiza o status do fluxo
                $flowModel->update(['teste' => $newTeste], $flowId);
                echo json_encode(['status' => 'success', 'message' => $newTeste ? 'Modo Teste ativado com sucesso.' : 'Modo Produção ativado com sucesso.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Já existe um fluxo ativo em modo teste.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Dados inválidos. Por favor, forneça um ID e um status de teste.']);
        }
    }


    public function stepsSave()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $stepModel = new StepModel();
                $optionModel = new OptionModel();

                $actionMode = $_POST['actionMode'] ?? null;
                $nodeId = $_POST['nodeId'] ?? null;

                if ($actionMode === 'editar') {

                    if ($_POST['tipo_do_no'] === "resposta_message_button") {
                        $optionModel->update(['titulo_interacao' => $_POST['pergunta'] ?? ''], $nodeId);
                    } else if ($_POST['tipo_do_no'] === "flow") {

                        $flowModel = new FlowModel();
                        $flowModel->update(
                            ['nome' => ($_POST['pergunta'] ?? '')],
                            $_POST['id_flow']
                        );
                    } else {
                        $stepModel->update([
                            'nome_da_funcao' => $_POST['nome_da_funcao'] ?? 'proxima_etapa',
                            'pergunta' => $_POST['pergunta'] ?? ''
                        ], $nodeId);
                    }
                    $newId = $nodeId;
                } elseif ($actionMode === 'cadastrar') {
                    // Cria um novo passo
                    $newId = $stepModel->createStep($_POST);

                    foreach ($_POST['selectedNodesData'] ?? [] as $data) {
                        if (isset($data['tipo_interacao'])) {
                            $updateData = ['id_step_proximo' => $newId];

                            // Atualiza dependendo do tipo de interação
                            if ($data['tipo_interacao'] === "message_button" || $data['tipo_interacao'] === "message_interactive") {
                                $optionModel->update($updateData, $data['id']);
                            } else {
                                $stepModel->update($updateData, $data['id']);
                            }
                        }
                    }
                }

                // Resposta de sucesso
                if (isset($newId)) {
                    echo json_encode(['status' => 'success', 'message' => 'Passo salvo com sucesso.', 'id' => $newId]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Erro ao salvar o passo.']);
                }
            } catch (\Exception $e) {
                echo json_encode(['status' => 'error', 'message' => 'Ocorreu um erro: ' . $e->getMessage()]);
            }
        }
    }

    public function stepsDelete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $stepModel = new StepModel();
            $optionModel = new OptionModel();




            $steps = [];
            foreach ($_POST['nodes'] as $node) {
                try {
                    $data = $node['data'];
                    if ($data['tipo_do_no'] === "resposta_message_button" || $data['tipo_do_no'] === "resposta_message_interactive") {
                        $optionModel->delete($data['id']);
                        $steps[$data['id_step']] = $data['id_step'];
                    } else {
                        $steps[$data['id_step']] = $data['id_step'];
                        $stepModel->delete($data['id']);
                    }
                } catch (\Exception $th) {
                }
            }

            foreach ($steps as $steps => $stepID) {
                $chatboConfigMessageInteractive = new ChatboConfigMessageInteractive();
                $chatboConfigMessageInteractive->deleteWhere(['id_step' => $stepID]);
            }


            // Retornando uma resposta JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Registro deletado com sucesso.'
            ]);
        }
    }


    public function criarFlow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do fluxo
            $flowName = $_POST['nome'] ?? '';
            $flowDescription = $_POST['descricao'] ?? '';
            $flow = new FlowModel();
            $flowId = $flow->create($flowName, $flowDescription);
            redirect("/view-flow?id=$flowId");
        }
    }
    public function editarForm()
    {


        $flowId = intval($_GET['id']);

        $flowModel  = new FlowModel();
        $flow = $flowModel->find($flowId);

        template(['flows/edit-flow'], ['flow' => $flow]);
    }
    public function createForm()
    {


        // $flowId = intval($_GET['id']);

        // $flowModel  = new FlowModel();
        // $flow = $flowModel->find($flowId);
        $flow = "";

        template(['steps/create-interations'], ['flow' => $flow]);
    }

    public function createInterations()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            // Obtém os dados do fluxo
            $optionModel = new OptionModel();


            $data = [
                'id_step' => $_POST['id_step'] ?? null,
                'titulo_interacao' => $_POST['titulo_interacao'] ?? null,
                'tipo_interacao' => $_POST['tipo_interacao'] ?? null,
                'descricao_interacao' => $_POST['descricao_interacao'] ?? null,
                'secao_titulo' => $_POST['secao_titulo'] ?? null,
            ];

            // Cria a nova opção
            $newOptionId = $optionModel->create($data);

            // Atualiza o tipo de interação
            if (!!$_POST['tipo_interacao']) {
                $stepModel = new StepModel();
                $stepModel->update(['tipo_interacao' => $_POST['tipo_interacao']], $_POST['id_step']);
            }
            // Retorna a resposta em JSON
            echo json_encode([
                'success' => true,
                'message' => 'Interação criada com sucesso!'
            ]);
            exit; // Encerra o script após enviar a resposta
        }

        // Se não for uma requisição POST
        echo json_encode([
            'success' => false,
            'message' => 'Método não permitido. Use POST.'
        ]);
        exit;
    }
    public function deleteInterations()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $optionModel = new OptionModel();

            // Deletando o registro com base no ID enviado via POST
            $optionModel->delete($_POST['id']);

            // Retornando uma resposta JSON
            echo json_encode([
                'status' => 'success',
                'message' => 'Registro deletado com sucesso.'
            ]);
            exit;
        }
    }

    public function editarFlow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do fluxo
            $flowModel = new \Models\FlowModel();

            $flowId = $_POST['id'] ?? '';
            $data = [
                'nome' => $_POST['name'],
                'descricao' => $_POST['description'],
            ];
            $flowModel->update($data, $flowId);

            // $flow = new FlowModel();
            // $flowId = $flow->update($flowName, $flowDescription);
            redirect("/view-flow?id=$flowId");
        }
    }
    public function apagarForm()
    {


        $flowId = intval($_GET['id']);

        $flowModel  = new FlowModel();
        $flow = $flowModel->find($flowId);

        template(['flows/delete-flow'], ['flow' => $flow]);
    }
    public function apagarFlow()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $flowModel = new \Models\FlowModel();
            $flowId = $_POST['id'] ?? '';

            // Obter o fluxo atual (ou fluxo que está sendo apagado)
            $currentFlow = $flowModel->getById($flowId);
            // Verificar se o fluxo atual foi encontrado
            if ($currentFlow) {
                // Se o fluxo atual estiver ativado, procuro o próximo fluxo
                if ($currentFlow[0]['atual'] == 1) {
                    // Obter o próximo fluxo disponível
                    $nextFlow = $flowModel->getNextActiveFlow($flowId);

                    if ($nextFlow) {
                        // Atualizar o status do próximo fluxo para 1
                        $flowModel->updateStatus($nextFlow['id'], 1);
                    }
                }
                $flowModel->deleteFlow($flowId);
            }


            redirect("/flows");
        }

        exit(json_encode(['status' => 'error', 'message' => 'Método inválido.']));
    }



    public function editar()
    {
        $flow = new FlowModel();
        template(['list-flow'], ['lista' => $flow->getAll()]);
    }
    public function apagar()
    {
        $flow = new FlowModel();
        template(['list-flow'], ['lista' => $flow->getAll()]);
    }

    public function save()
    {
        // Verifica se a requisição é uma POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém os dados do fluxo
            $flowName = $_POST['flow-name'] ?? '';
            $flowDescription = $_POST['flow-description'] ?? '';
            $questions = $_POST['step-question'] ?? [];
            $responseTypes = $_POST['step-response-type'] ?? [];
            $options = $_POST['step-options'] ?? [];

            // Aqui você pode salvar o fluxo no banco de dados
            // Exemplo básico de como você poderia salvar o fluxo
            $flow = new FlowModel();
            $flowId = $flow->create($flowName, $flowDescription);

            // Salvar cada etapa
            foreach ($questions as $index => $question) {
                $responseType = $responseTypes[$index];
                $stepId = $flow->addStep($flowId, $question, $responseType);

                // Se for escolha múltipla, salvar as opções
                if ($responseType === 'escolha-múltipla') {
                    foreach ($options[$index] as $option) {
                        $flow->addOption($stepId, $option);
                    }
                }
            }

            // Redirecionar ou exibir uma mensagem de sucesso
            header('Location: /flows'); // Redireciona para a página de lista de fluxos
            exit();
        }
    }
}
