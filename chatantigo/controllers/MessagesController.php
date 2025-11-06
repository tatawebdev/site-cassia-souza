<?php

namespace Controllers;

class MessagesController
{
    public function index()
    {
        // Lógica que será executada ao acessar a rota de mensagens
        
        // Renderiza a view 'messages'
        template(['messages']);
    }
}
