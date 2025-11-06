<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatbotFlowsSeeder extends Seeder
{
    public function run(): void
    {
        // Inserir flows mínimos necessários para satisfazer as chaves estrangeiras dos steps
        $flows = [
            [
                'id' => 1,
                'nome' => 'Default Flow 1',
                'descricao' => 'Fluxo padrão 1',
                'atual' => 1,
                'id_step_inicial' => null,
                'processo_de_loop' => 0,
                'teste' => 0,
            ],
            [
                'id' => 6,
                'nome' => 'Flow 6',
                'descricao' => 'Fluxo 6 (gerado pelo seeder)',
                'atual' => 0,
                'id_step_inicial' => null,
                'processo_de_loop' => 0,
                'teste' => 0,
            ],
        ];

        foreach ($flows as $flow) {
            DB::table('chatbot_flows')->updateOrInsert(
                ['id' => $flow['id']],
                [
                    'nome' => $flow['nome'],
                    'descricao' => $flow['descricao'],
                    'atual' => $flow['atual'],
                    'id_step_inicial' => $flow['id_step_inicial'],
                    'processo_de_loop' => $flow['processo_de_loop'],
                    'teste' => $flow['teste'],
                ]
            );
        }
    }
}
