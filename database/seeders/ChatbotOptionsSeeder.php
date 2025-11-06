<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ChatbotOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('app/Models/chatbot_options.json');
        if (!File::exists($path)) {
            $this->command->info("File not found: {$path}");
            return;
        }

        $content = File::get($path);
        $json = $this->extractJsonArray($content);
        $items = json_decode($json, true);

        if (!is_array($items)) {
            $this->command->error('Invalid JSON in chatbot_options.json');
            return;
        }

        foreach ($items as $item) {
            // Insere apenas as colunas esperadas pela tabela; algumas instalações podem não ter todas as colunas
            $data = [
                'id_step' => $item['id_step'] ?? null,
                'resposta_opcional' => $item['resposta_opcional'] ?? null,
                'id_step_proximo' => $item['id_step_proximo'] ?? null,
                'titulo_interacao' => $item['titulo_interacao'] ?? null,
                'descricao_interacao' => $item['descricao_interacao'] ?? null,
                'tipo_interacao' => $item['tipo_interacao'] ?? null,
            ];

            DB::table('chatbot_options')->updateOrInsert(['id' => $item['id']], $data);
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
