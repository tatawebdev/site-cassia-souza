<?php

namespace Models;

class OptionModel extends Model
{
    public function __construct()
    {
        parent::__construct();

        // Define a tabela que este modelo manipulará
        $this->setTable('chatbot_options');
    }


    public function create($data)
    {
        $this->insert($data);
        return $this->db->lastInsertId();
    }

    public function getAllOptions()
    {
        return $this->all();
    }

    public function getOptionsForStep($stepId)
    {
        $sql = "
            SELECT 
                cs.id AS step_id, 
                cs.id_flow, 
                cs.pergunta, 
                cs.tipo_resposta, 
                cs.tipo_interacao, 
                cs.nome_da_funcao, 
                cs.id_step_proximo, 
                cs.parent,
                co.id AS option_id,
                co.resposta_opcional,
                co.titulo_interacao,
                co.descricao_interacao,
                co.secao_titulo
            FROM 
                chatbot_steps cs
            LEFT JOIN 
                chatbot_options co ON cs.id = co.id_step
            WHERE 
                cs.id = :step_id;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['step_id' => $stepId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
