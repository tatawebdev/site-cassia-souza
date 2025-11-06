<?php

namespace Models;

use PDO;

class FlowModel extends Model
{
    public function __construct()
    {

        parent::__construct();
        $this->setTable('chatbot_flows');
    }


    public function create($name, $description)
    {
        $data = [
            'nome' => $name,
            'descricao' => $description
        ];

        if (!$this->existsAlgumRegistro()) {
            $data['atual'] = 1;
        }

        $this->insert($data);
        return $this->db->lastInsertId();
    }
    public function existsAlgumRegistro()
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM " . $this->getTable();

            $stmt = $this->query($sql);

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result['count'] > 0;
        } catch (\PDOException $e) {
            error_log("Erro ao verificar a existência do registro: " . $e->getMessage());
            return false;
        }
    }
    public function addStep($flowId, $question, $responseType)
    {
        $stepModel = new StepModel();
        return $stepModel->create($flowId, $question, $responseType);
    }

    public function addOption($stepId, $option)
    {
        $optionModel = new OptionModel();
        return $optionModel->create($stepId, $option);
    }
    public function getAll()
    {
        return $this->all(); // Retorna todos os registros da tabela 'chatbot_flows'
    }

    public function resetStepsAndOptions($flowId)
    {
        try {
            // Atualiza chatbot_steps
            $sqlSteps = "UPDATE chatbot_steps SET id_step_proximo = NULL WHERE id_flow = ?";
            $this->query($sqlSteps, [$flowId]);

            // Atualiza chatbot_options
            $sqlOptions = "UPDATE chatbot_options SET id_step_proximo = NULL WHERE id_step IN (
                SELECT id FROM chatbot_steps WHERE id_flow = ?
            )";
            $this->query($sqlOptions, [$flowId]);

            return true; // Retorna true se a atualização for bem-sucedida
        } catch (\PDOException $e) {
            error_log("Erro ao resetar steps e options: " . $e->getMessage());
            return false; // Retorna false se houver erro
        }
    }

    public function getById($id)
    {
        return $this->where(['id' => $id]);
    }

    public function getNextActiveFlow($currentId)
    {
        $sql = "SELECT * FROM " . $this->getTable() . " WHERE " . $this->getPrimaryKey() . " <> ? ORDER BY " . $this->getPrimaryKey() . " ASC LIMIT 1";
        return $this->query($sql, [$currentId])->fetch(PDO::FETCH_ASSOC);
    }

    // Função para atualizar o status de um registro
    public function updateStatus($id, $status)
    {
        $data = ['atual' => $status];
        return $this->update($data, $id);
    }


    public function deleteFlow($id_flow)
    {
        try {
            $this->db->beginTransaction();

            // 1. Excluir as opções associadas aos passos do fluxo
            $sql = "DELETE co FROM chatbot_options co
                    JOIN chatbot_steps cs ON co.id_step = cs.id
                    WHERE cs.id_flow = ?";
            $this->query($sql, [$id_flow]);

            // 2. Excluir os passos do fluxo
            $sql = "DELETE FROM chatbot_steps WHERE id_flow = ?";
            $this->query($sql, [$id_flow]);

            // 3. Excluir o fluxo
            $sql = "DELETE FROM chatbot_flows WHERE id = ?";
            $this->query($sql, [$id_flow]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new \Exception("Erro ao deletar o fluxo: " . $e->getMessage());
        }
    }
}
