<?php

namespace Models;

use PDO;

class ChatbotInteracoesChat extends Model
{
    protected $table = 'chatbot_interacoes_chat';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table);
    }

    /**
     * Retorna todas as interações de chat
     *
     * @return array
     */
    public function getAllInteracoes()
    {
        // Retorna todas as colunas da tabela chatbot_interacoes_chat
        return $this->all('id, usuario_id, mensagem, remetente, status_mensagem, data_envio, data_recebimento, data_visualizacao, data_leitura, id_step, data, message_id');
    }

    /**
     * Retorna uma interação específica de chat por ID
     *
     * @param int $id
     * @return array|false
     */
    public function getInteracaoById($id)
    {
        return $this->where(['id' => $id]);
    }

    /**
     * Retorna interações de um usuário específico
     *
     * @param int $usuarioId
     * @return array
     */
    public function getInteracoesByUsuarioId($usuarioId)
    {
        // Busca todas as interações de um usuário específico
        return $this->where(['usuario_id' => $usuarioId]);
    }

    /**
     * Insere uma nova interação no chat
     *
     * @param array $data
     * @return void
     */
    public function insertInteracao($data)
    {
        // Insere uma nova interação no chat
        $this->insert($data);
    }

    /**
     * Atualiza uma interação existente
     *
     * @param array $data
     * @param int $id
     * @return void
     */
    public function updateInteracao($data, $id)
    {
        // Atualiza uma interação existente
        $this->update($data, $id);
    }

    /**
     * Exclui uma interação pelo ID
     *
     * @param int $id
     * @return void
     */
    public function deleteInteracao($id)
    {
        // Exclui uma interação pelo ID
        $this->delete($id);
    }
    /**
     * Retorna interações agrupadas por data
     *
     * @return array
     */
    public function getInteracoesAgrupadasPorData()
    {
        // SQL para agrupar as interações por data
        $sql = "
            SELECT 
                DATE(data) AS data_interacao,
                COUNT(*) AS total_interacoes,
                GROUP_CONCAT(mensagem SEPARATOR '; ') AS mensagens
            FROM 
                {$this->table}
            GROUP BY 
                DATE(data)
            ORDER BY 
                data_interacao DESC
        ";

        // Executa a consulta e retorna os resultados
        $stmt = $this->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
