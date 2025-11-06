<?php

namespace Models;

class FunctionModel extends Model
{
    protected $table = 'chatbot_functions'; // Defina a tabela que esta classe manipulará

    public function popularLista()
    {
        $url = 'https://chatbot.cassiasouzaadvocacia.com.br/update-functions.php';

        $data = $this->fetchJsonData($url);
        foreach ($data['functions'] as $functionName) {
            $this->insertFunction($functionName);
        }
    }

    private function insertFunction($functionName)
    {
        if (!$this->functionExists($functionName)) {
            $data = ['name' => $functionName];
            return $this->insert($data);
        }
    }

    // Método para verificar se a função já existe no banco de dados
    private function functionExists($functionName)
    {
        $result = $this->whereOne(['name' => $functionName]);
        return !empty($result);
    }
}
