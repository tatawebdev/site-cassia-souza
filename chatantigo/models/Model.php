<?php
// src/Models/Model.php

namespace Models;

use PDO;

class Model
{
    protected $db;
    protected $table; // Propriedade para armazenar o nome da tabela
    protected $primaryKey = 'id'; // Define a chave primária padrão como 'id'

    public function __construct()
    {
        $this->db = new PDO('mysql:host=mysql.cassiasouzaadvocacia.com.br;dbname=cassiasouzaadv02;charset=utf8', 'cassiasouzaadv02', 'Gebeleia2010100');

        // Definir o modo de erro do PDO para exceções
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Garantir que o conjunto de caracteres seja utf8
        $this->db->exec("SET NAMES utf8");
    }

    protected function setTable($table)
    {
        $this->table = $table;
    }

    protected function getTable()
    {
        return $this->table;
    }

    protected function setPrimaryKey($key)
    {
        $this->primaryKey = $key;
    }

    protected function getPrimaryKey()
    {
        return $this->primaryKey;
    }


    public function query($sql, $params = [])
    {
        // Verifique se a conexão com o banco de dados não está nula
        if ($this->db) {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } else {
            throw new \Exception("Conexão com o banco de dados não foi estabelecida.");
        }
    }
    public function raw($sql, $params = [])
    {
        return $this->query($sql, $params);
    }

    public function all($columns = '*')
    {
        return $this->query("SELECT $columns FROM " . $this->getTable())->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id, $columns = '*')
    {
        return $this->query("SELECT $columns FROM " . $this->getTable() . " WHERE " . $this->getPrimaryKey() . " = ?", [$id])->fetch(PDO::FETCH_ASSOC);
    }


    public function swapIds($id1, $id2, $column = null)
    {
        try {
            $this->db->beginTransaction();

            // Se não houver coluna especificada, não fazemos a troca na coluna.
            if ($column) {
                // 1. Armazenar os valores atuais de column de id1 e id2
                $query = "SET @column_1 = (SELECT $column FROM " . $this->getTable() . " WHERE " . $this->getPrimaryKey() . " = ?)";
                $this->query($query, [$id1]);

                $query = "SET @column_2 = (SELECT $column FROM " . $this->getTable() . " WHERE " . $this->getPrimaryKey() . " = ?)";
                $this->query($query, [$id2]);

                // 2. Trocar os valores da coluna especificada
                $updateQuery = "UPDATE " . $this->getTable() . " 
                    SET $column = CASE 
                        WHEN " . $this->getPrimaryKey() . " = ? THEN @column_2
                        WHEN " . $this->getPrimaryKey() . " = ? THEN @column_1
                        ELSE $column
                    END 
                    WHERE " . $this->getPrimaryKey() . " IN (?, ?)";
                $this->query($updateQuery, [$id1, $id2, $id1, $id2]);
            }

            // 3. Atribuir um valor temporário (-99) ao ID id1 para evitar conflito
            $this->query("UPDATE " . $this->getTable() . " SET " . $this->getPrimaryKey() . " = -99 WHERE " . $this->getPrimaryKey() . " = ?", [$id1]);

            // 4. Trocar o ID id2 para o ID id1
            $this->query("UPDATE " . $this->getTable() . " SET " . $this->getPrimaryKey() . " = ? WHERE " . $this->getPrimaryKey() . " = ?", [$id1, $id2]);

            // 5. Trocar o valor temporário (-99) para o ID id2
            $this->query("UPDATE " . $this->getTable() . " SET " . $this->getPrimaryKey() . " = ? WHERE " . $this->getPrimaryKey() . " = -99", [$id2]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new \Exception("Erro ao trocar os IDs: " . $e->getMessage());
        }
    }



    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), '?'));
        $this->query("INSERT INTO " . $this->getTable() . " ($columns) VALUES ($placeholders)", array_values($data));
    }
    public function updateWhere($data, $conditions = [])
    {
        // Verificar se existem condições para a cláusula WHERE
        if (empty($conditions)) {
            throw new \Exception("É necessário fornecer condições para atualizar registros.");
        }

        // Montar a parte SET da consulta
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $set = implode(", ", $set);

        // Montar a parte WHERE da consulta
        $whereClauses = [];
        $params = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "$column = ?";
            $params[] = $value;
        }
        $where = implode(" AND ", $whereClauses);

        // Unir todos os parâmetros de data e conditions
        $params = array_merge(array_values($data), $params);

        // Executar a consulta
        return $this->query("UPDATE " . $this->getTable() . " SET $set WHERE $where", $params);
    }

    public function update($data, $id)
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $set = implode(", ", $set);
        return  $this->query("UPDATE " . $this->getTable() . " SET $set WHERE " . $this->getPrimaryKey() . " = ?", array_merge(array_values($data), [$id]));
    }
    public function updateWithoutWhere($data)
    {
        $set = [];
        foreach ($data as $column => $value) {
            $set[] = "$column = ?";
        }
        $set = implode(", ", $set);
        return $this->query("UPDATE " . $this->getTable() . " SET $set", array_values($data));
    }


    public function insertOrUpdate($data)
    {
        if (isset($data[$this->getPrimaryKey()]) && $this->find($data[$this->getPrimaryKey()])) {
            $this->update($data, $data[$this->getPrimaryKey()]);
        } else {
            $this->insert($data);
        }
    }

    public function delete($id)
    {
        $this->query("DELETE FROM " . $this->getTable() . " WHERE " . $this->getPrimaryKey() . " = ?", [$id]);
    }
    public function deleteWhere($conditions = [])
    {
        // Inicializamos a query base
        $sql = "DELETE FROM " . $this->getTable();

        // Se houver condições, adicionamos a cláusula WHERE
        if (!empty($conditions)) {
            $whereClauses = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        } else {
            throw new \Exception("É necessário fornecer condições para excluir registros.");
        }

        // Executamos a query para deletar os registros
        return $this->query($sql, $params);
    }


    public function createTable(string $tableName, array $columns)
    {
        // Implementação para criar tabela no banco de dados
        // Aqui você deve adicionar a lógica para executar a instrução SQL de criação da tabela
        $columnsString = implode(", ", $columns);
        $sql = "CREATE TABLE IF NOT EXISTS $tableName ($columnsString)";
        $this->query($sql);
    }

    public function truncateTable($tableName)
    {
        $this->query("TRUNCATE TABLE $tableName");
    }

    public function dropTable($tableName)
    {
        $this->query("DROP TABLE IF EXISTS $tableName");
    }

    public function deleteAll()
    {
        $this->query("DELETE FROM " . $this->getTable());
    }

    public static function getInstance($tableName)
    {
        // Cria uma instância da classe com base no nome da tabela
        $className = 'Models\\' . ucfirst($tableName);
        if (class_exists($className)) {
            return new $className();
        } else {
            throw new \Exception("Class $className not found.");
        }
    }

    public function getAllTables()
    {
        // Consulta para obter todas as tabelas do banco de dados
        $sql = "SELECT table_name FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = DATABASE()";
        return $this->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function dropTables(array $tables)
    {
        foreach ($tables as $table) {
            $this->dropTable($table);
        }
    }

    public function where($conditions = [], $columns = '*')
    {
        // Inicializamos a query base
        $sql = "SELECT $columns FROM " . $this->getTable();

        // Se houver condições, adicionamos a cláusula WHERE
        if (!empty($conditions)) {
            $whereClauses = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        } else {
            // Se não houver condições, apenas selecionamos todos os registros
            $params = [];
        }

        // Executamos a query e retornamos os resultados
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function contWhere($conditions = [])
    {
        // Inicializamos a query base
        $sql = "SELECT COUNT(*) AS total FROM " . $this->getTable();

        // Se houver condições, adicionamos a cláusula WHERE
        if (!empty($conditions)) {
            $whereClauses = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        } else {
            // Se não houver condições, apenas contamos todos os registros
            $params = [];
        }

        // Executamos a query e retornamos o resultado
        $result = $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);

        return $result['total'];
    }

    public function whereOne($conditions = [], $columns = '*')
    {
        // Inicializamos a query base
        $sql = "SELECT $columns FROM " . $this->getTable();

        // Se houver condições, adicionamos a cláusula WHERE
        if (!empty($conditions)) {
            $whereClauses = [];
            $params = [];

            foreach ($conditions as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = $value;
            }

            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        } else {
            // Se não houver condições, apenas selecionamos todos os registros
            $params = [];
        }

        // Executamos a query e retornamos os resultados
        return $this->query($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    // ... outros métodos existentes ...

    /**
     * Função genérica para acessar um endpoint JSON e retornar os dados.
     *
     * @param string $url URL do endpoint a ser consumido.
     * @return array Dados decodificados em formato de array.
     * @throws \Exception Em caso de falha ao acessar o endpoint.
     */
    public function fetchJsonData($url)
    {
        // Usando cURL para acessar o endpoint
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a resposta como string
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Segue redirecionamentos, se houver

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('Erro ao acessar o endpoint: ' . curl_error($ch));
        }

        curl_close($ch);

        // Decodifica o JSON e retorna
        $data = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Erro ao decodificar JSON: ' . json_last_error_msg());
        }

        return $data;
    }
    public function like($column, $searchTerm, $columns = '*')
    {
        // Inicializamos a query base
        $sql = "SELECT $columns FROM " . $this->getTable() . " WHERE $column LIKE ?";

        // Adicionamos os wildcards '%' ao termo de busca
        $params = ['%' . $searchTerm . '%'];

        // Executamos a query e retornamos os resultados
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
