<?php

namespace Models;

use PDO;

class ChatbotUsuario extends Model
{
    protected $table = 'chatbot_usuario';

    public function __construct()
    {
        parent::__construct();
        $this->setTable($this->table); // Define a tabela para esta model
    }

    // Função para pegar o ID pelo telefone
    public function getIdByTelefone($telefone)
    {
        // Usa a função whereOne para buscar o registro onde o telefone corresponde
        $usuario = $this->whereOne(['telefone' => $telefone], 'id');

        // Verifica se o registro foi encontrado
        if ($usuario) {
            return $usuario['id']; // Retorna o ID do usuário
        }

        // Se o telefone não for encontrado, retorna null
        return null;
    }
    public function getTelefoneByID($id)
    {
        $usuario = $this->whereOne(['id' => $id], 'telefone');

        if ($usuario) {
            return $usuario['telefone'];
        }

        return null;
    }

    public function getUltimasMensagens($page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;

        $sql = "
            SELECT 
               *
            FROM 
                {$this->table} 
            ORDER BY 
                ultima_mensagem DESC 
            LIMIT :limit OFFSET :offset
        ";

        // Executa a consulta com parâmetros para evitar SQL Injection
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
