<?php

namespace Controllers;

use Models\UserModel;

class LoginController
{
    public function index()
    {
        include PATH_VIEWS . 'login.php';
    }
    public function realizarLogin()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Coleta os dados do formulário
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Tenta fazer login
            $userModel = new UserModel();
            $user = $userModel->login($username, $password); // Tenta fazer login

            if ($user) {
                redirect("/");
            } else {
                flashMessage("Usuário não encontrado. Verifique suas credenciais.", "error");
                redirect("/login");
            }
        }
    }
}
