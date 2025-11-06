<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChatbotStepsSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('app/Models/chatbot_steps.json');
        if (!File::exists($path)) {
            $this->command->info("File not found: {$path}");
            return;
        }

        $content = File::get($path);
        $json = $this->extractJsonArray($content);
        $items = json_decode($json, true);

        if (!is_array($items)) {
            $this->command->error('Invalid JSON in chatbot_steps.json');
            return;
        }

        foreach ($items as $item) {
            DB::table('chatbot_steps')->updateOrInsert(
                ['id' => $item['id']],
                [
                    'id_flow' => $item['id_flow'] ?? null,
                    'pergunta' => $item['pergunta'] ?? null,
                    'tipo_resposta' => $item['tipo_resposta'] ?? null,
                    'tipo_interacao' => $item['tipo_interacao'] ?? null,
                    'nome_da_funcao' => $item['nome_da_funcao'] ?? null,
                    'id_step_proximo' => $item['id_step_proximo'] ?? null,
                    'parent' => $item['parent'] ?? null,
                    'nome_campo' => $item['nome_campo'] ?? null,
                ]
            );
        }
    }

    private function extractJsonArray(string $content): string
    {
        $start = strpos($content, '[');
        $end = strrpos($content, ']');
        if ($start === false || $end === false) {
            return '[]';
        }
        return substr($content, $start, $end - $start + 1);
    }
}
