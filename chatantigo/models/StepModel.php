<?php

namespace Models;

class StepModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->setTable('chatbot_steps');
    }

    public function updates($id, $flowId, $question, $responseType, $parentId = null)
    {
        $data = [
            'id_flow' => $flowId,
            'pergunta' => $question,
            'tipo_interacao' => $responseType,
            'parent' => $parentId
        ];

        return self::update($data, $id);
    }


    public function create($data)
    {
        $this->insert($data);
        return $this->db->lastInsertId();
    }


    public function createStep($data)
    {
        // Obter o próximo ID
        $nextId = $this->getNextId(); // Função para obter o próximo ID



        // Criar um array de dados
        $dataToInsert = [
            'id' => $nextId
        ];

        // Adicionar campos apenas se existirem no $data
        if (isset($data['id_flow'])) {
            $dataToInsert['id_flow'] = $data['id_flow'];
        }

        if (isset($data['pergunta'])) {
            $dataToInsert['pergunta'] = $data['pergunta'];
        }

        if (isset($data['tipo_resposta'])) {
            $dataToInsert['tipo_resposta'] = $data['tipo_resposta'];
        }

        if (isset($data['tipo_interacao'])) {
            $dataToInsert['tipo_interacao'] = $data['tipo_interacao'];
        }

        if (isset($data['nome_da_funcao'])) {
            $dataToInsert['nome_da_funcao'] = $data['nome_da_funcao'];
        }

        if (isset($data['parent'])) {
            $dataToInsert['parent'] = $data['parent'];
        }

        // Inserir no banco de dados
        return $this->create($dataToInsert);
    }

    private function getNextId()
    {
        $stmt = $this->db->query("SELECT CASE
        WHEN COALESCE(MAX(id_step_proximo), 1) IN (SELECT id FROM chatbot_steps)
        THEN COALESCE(MAX(id), 1) + 1 
        ELSE COALESCE(MAX(id_step_proximo), 1) 
    END AS next_id 
FROM chatbot_steps;
");
        return $stmt->fetchColumn();
    }



    public function getSteps($flowId)
    {
        try {
            return $this->query("SELECT * FROM " . $this->getTable() . " WHERE id_flow = ? order by id limit 1", [$flowId])->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Você pode registrar o erro aqui
            return [];
        }
    }

    public function getFirstStepByFlowId($flowId)
    {
        try {
            $sql = "SELECT * FROM " . $this->getTable() . " WHERE id_flow = ? ORDER BY id LIMIT 1";
            return $this->query($sql, [$flowId])->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Registrar o erro, se necessário, para auditoria ou depuração
            error_log("Erro ao buscar o primeiro passo por flowId: " . $e->getMessage());
            return [];
        }
    }
    public function getFirstStepByStepId($stepId)
    {
        try {
            $sql = "SELECT *, 'ok' FROM " . $this->getTable() . " WHERE id = ? ORDER BY id LIMIT 1";
            return $this->query($sql, [$stepId])->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Registrar o erro, se necessário, para auditoria ou depuração
            error_log("Erro ao buscar o primeiro passo por flowId: " . $e->getMessage());
            return [];
        }
    }
    public function getOptionsByStepId($stepId)
    {
        try {
            $sql = "SELECT * FROM chatbot_options WHERE id_step = ? ORDER BY id";
            return $this->query($sql, [$stepId])->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Registrar o erro para depuração, se necessário
            error_log("Erro ao buscar opções por stepId: " . $e->getMessage());
            return [];
        }
    }


    public function buildTree($flowId)
    {
        // Obtém os passos iniciais do fluxo
        $steps = $this->getFirstStepByFlowId($flowId);

        // Constrói a árvore de passos
        $steps = $this->buildTreeStep($steps);

        return   $steps;
    }

    public function buildTreeStep($steps)
    {
        // Inicializa um array para armazenar a estrutura da árvore
        $stepMap = [];
        if (!is_array($steps)) {
            if (is_numeric($steps)) {
                $steps = $this->getFirstStepByStepId($steps);
            }
        }


        foreach ($steps as $step) {
            // Adiciona cada passo ao mapa
            $stepMap[$step['id']] = [
                'id' => $step['id'],
                'id_step' => $step['id'],
                'pergunta' => $step['pergunta'],
                'table' => 'steps',
                'tipo_resposta' => $step['tipo_resposta'],
                'tipo_interacao' => $step['tipo_interacao'],
                'nome_da_funcao' => $step['nome_da_funcao'],
                'nome_campo' => $step['nome_campo'] ?? null,
                'parent' => $step['parent'],
                'tipo_do_no' => 'pergunta_' . $step['tipo_interacao'],
                'children' => $this->getChildrenSteps($step) // Chamada para obter os filhos com tipo_interacao
            ];
        }
        return $stepMap; // Retorna o mapa de passos
    }

    // Nova função para obter os filhos a partir do id_step_proximo e tipo_interacao
    private function getChildrenSteps($step)
    {

        // Se o tipo de interação for message_button, busca opções na tabela chatbot_options
        switch ($step['tipo_interacao']) {
            case 'message_interactive':
            case 'message_button':
                $options = $this->getChatbotOptionsByStepId($step['id']);

                foreach ($options as &$option) {
                    $option['tipo_do_no'] = "resposta_" . $option['tipo_interacao'];
                    $option['table'] = 'options';
                    $option['id_step'] = $option['id_step'];
                    $option['nome_campo'] = $option['nome_campo'] ?? null;
                    $option['id_option'] = $option['id'];
                    if (!empty($option['id_step_proximo'])) {
                        $option['children'] = $this->buildTreeStep($option['id_step_proximo']);
                    }
                }
                return $options;

                break;
            case 'message_text':
                // Inicializa o array de retorno com dados básicos
                $response = [
                    [
                        'id' => $step['id'],
                        'id_step' => $step['id'],
                        'table' => 'steps',
                        'nome_campo' => $step['nome_campo'] ?? null,
                        'titulo_interacao' => 'Resposta do Usuario',
                        'tipo_interacao' => $step['tipo_interacao'],
                        'nome_da_funcao' => $step['nome_da_funcao'] ?? '',
                        'tipo_do_no' => "resposta_" . $step['tipo_interacao'],
                    ]
                ];

                if (!empty($step['id_step_proximo'])) {
                    $nextSteps = $this->getFirstStepByStepId($step['id_step_proximo']);
                    $response[0]['children'] = $this->buildTreeStepWithInteractionType($nextSteps, $step['tipo_interacao']);
                }

                return $response;
                break;
        }



        // Se não houver id_step_proximo, retorna um array vazio
        return [];
    }
    // Função para buscar opções na tabela chatbot_options
    private function getChatbotOptionsByStepId($stepId)
    {
        // Lógica para consultar o banco de dados e obter as opções
        return $this->query("SELECT * FROM `chatbot_options` WHERE `id_step` = ?", [$stepId])->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Nova função para construir a árvore considerando o tipo de interação
    private function buildTreeStepWithInteractionType($steps, $tipoInteracao)
    {
        // Inicializa um array para armazenar a estrutura da árvore
        $stepMap = [];

        foreach ($steps as $step) {
            // Adiciona cada passo ao mapa
            $stepMap[$step['id']] = [
                'id' => $step['id'],
                'id_step' => $step['id'],
                'table' => 'steps',
                'pergunta' => $step['pergunta'],
                'tipo_resposta' => $step['tipo_resposta'],
                'tipo_interacao' => $step['tipo_interacao'],
                'nome_da_funcao' => $step['nome_da_funcao'],
                'parent' => $step['parent'],
                'nome_campo' => $step['nome_campo'],
                'tipo_do_no' => "pergunta_" . $step['tipo_interacao'],
                'children' => $this->getChildrenSteps($step) // Chamada para obter os filhos com tipo_interacao
            ];
        }

        return $stepMap; // Retorna o mapa de passos
    }


    public function renderTree(array $tree, $textFlow, $idFlow)
    {
        // Inicializa o resultado com a saudação
        $result = [
            [
                'id' => 'nameFlow',
                'text' => $textFlow,
                'data' => [
                    'id' => null,
                    'pergunta' => $textFlow,
                    'tipo_resposta' => '',
                    'tipo_interacao' => '',
                    'nome_da_funcao' => '',
                    'parent' => null,
                    'nome_campo' => null,
                    'tipo_do_no' => 'flow',
                    'id_flow' => $idFlow,
                ],
                'children' =>  $this->renderTreeloop($tree, $idFlow)
            ]
        ];


        return $result; // Retorna a estrutura gerada
    }

    public function renderTreeloop(array $tree, $idFlow, string $listaID = '')
    {
        $result = []; // Inicializa o resultado para os nós

        foreach ($tree as $item) {
            // Cria o nó com as propriedades essenciais
            $node = [
                'id' => $listaID . $item['id'], // Concatena listaID com o ID do item
                'text' => strip_tags($item['pergunta'] ?? $item['titulo_interacao'] ?? ''), // Remove todas as tags HTML
                // 'text' => ($item['pergunta'] ?? $item['titulo_interacao'] ?? '') . '| id =' . ($listaID . $item['id']), // Pergunta que será exibida
                'data' => [ // Dados adicionais do nó
                    'id' => $item['id'],
                    'pergunta' => $item['pergunta'] ?? $item['titulo_interacao'] ?? '',
                    'id_option' => $item['id_option'] ?? null,
                    'table' => $item['table'] ?? null,
                    'id_step' => $item['id_step'] ?? null,
                    'tipo_resposta' => $item['tipo_resposta'] ?? '',
                    'tipo_interacao' => $item['tipo_interacao'] ?? '',
                    'nome_da_funcao' => $item['nome_da_funcao'] ?? '',
                    'parent' => $item['parent'] ?? null,
                    'nome_campo' => $item['nome_campo'] ?? null,
                    'tipo_do_no' => $item['tipo_do_no'] ?? null,
                    'id_flow' => $idFlow,
                ],
                'children' => !empty($item['children']) ? $this->renderTreeloop($item['children'], $idFlow, $listaID . $item['id'] . '-') : [] // Chamando recursivamente para processar filhos
            ];

            $result[] = $node; // Adiciona o nó ao resultado
        }

        return $result; // Retorna a estrutura gerada
    }

    public function exists($flowId, $question)
    {
        try {
            // Query para verificar se já existe um registro com o mesmo id_flow e pergunta
            $sql = "SELECT COUNT(*) as count FROM " . $this->getTable() . " WHERE id_flow = ? AND pergunta = ?";
            $stmt = $this->query($sql, [$flowId, $question]);

            // Obtém o número de registros encontrados
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            // Se count for maior que 0, significa que o registro já existe
            return $result['count'] > 0;
        } catch (\PDOException $e) {
            error_log("Erro ao verificar existência do registro: " . $e->getMessage());
            return false;
        }
    }
}
