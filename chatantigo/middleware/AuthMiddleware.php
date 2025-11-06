<?php

namespace Middleware;

class AuthMiddleware
{
    public function handle()
    {

        // Aqui você pode adicionar a lógica de autenticação
        // Exemplo: Verificar se o usuário está logado ou se um token é válido

        if (!isset($_SESSION['user'])) {
            // Se o usuário não estiver autenticado, redireciona ou retorna um erro
            header('Location: /login');
            exit();
        }


        define('CURRENT_USER', $_SESSION['user']);

        // Se tudo estiver correto, permite o acesso
        return true;
    }
}
