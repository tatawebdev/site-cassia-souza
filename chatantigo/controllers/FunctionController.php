<?php

namespace Controllers;


use Models\Flow;
use Models\FlowModel;
use Models\FunctionModel;
use Models\OptionModel;
use Models\StepModel;

class FunctionController
{
    public function listaJson()
    {
        header('Content-Type: application/json');

        // Inicializa o modelo que contém a função 'like'
        $FunctionModel = new FunctionModel();

        // Captura a consulta do usuário
        $query = isset($_GET['q']) ? $_GET['q'] : '';

        // Verifica se a query não está vazia antes de realizar a busca no banco
        if (!empty($query)) {
            // Realiza a busca no banco de dados com base na consulta
            $results = $FunctionModel->like('name', $query);
        } else {
            // Se não houver consulta, define um array vazio para os resultados
            $results = [];
        }

        // Retorna os resultados do banco de dados em formato JSON
        echo json_encode($results);
    }
}
