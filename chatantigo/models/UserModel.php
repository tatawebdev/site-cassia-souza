<?php
// src/Models/UserModel.php

namespace Models;

class UserModel extends Model
{
    protected $table = 'users'; // Define o nome da tabela

    public function insertTable()
    {
        $columns = [
            "id INT(11) AUTO_INCREMENT PRIMARY KEY",
            "username VARCHAR(50) NOT NULL UNIQUE",
            "password VARCHAR(255) NOT NULL",
            "email VARCHAR(100) NOT NULL UNIQUE",
            "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
        ];
        $this->createTable($this->getTable(), $columns);
    }

    public function register($username, $password, $email)
    {
        // Gera um hash da senha
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insere o novo usuário na tabela
        $this->insert([
            'username' => $username,
            'password' => $hashedPassword,
            'email' => $email
        ]);
    }

    public function login($username, $password)
    {
        // Busca o usuário pelo nome de usuário
        $user = $this->query("SELECT * FROM " . $this->getTable() . " WHERE username = ?", [$username])->fetch();


        // Verifica se o usuário existe e a senha está correta
        if ($user && password_verify($password, $user['password'])) {
            // Inicia a sessão e armazena o usuário na sessão
            $_SESSION['user'] = $user; // Armazena as informações do usuário na sessão
            return $_SESSION['user'] ; // Retorna verdadeiro em caso de sucesso
        }
        return false; // Retorna false em caso de falha
    }

    public function logout()
    {
        // Remove as informações do usuário da sessão
        unset($_SESSION['user']);
        session_destroy(); // Encerra a sessão
    }

    public function isLoggedIn()
    {
        // Verifica se o usuário está logado
        return isset($_SESSION['user']);
    }

    public function getUser($id)
    {
        // Busca o usuário pelo ID
        $user = $this->query("SELECT * FROM " . $this->getTable() . " WHERE id = ?", [$id])->fetch();

        // Retorna o usuário ou null se não encontrado
        return $user ?: null;
    }

    public function CurrentUser()
    {
        // Retorna o usuário atual se estiver logado, caso contrário retorna null
        return $this->isLoggedIn() ? $_SESSION['user'] : null;
    }
}
