<?php

namespace Controllers;

class HelpController
{
    public function index()
    {
        // Aqui você pode incluir a lógica que deseja executar
        // ao acessar a rota "home". Por exemplo, renderizar uma view.

        // Incluindo a view

        template(['home']);
    }
}
