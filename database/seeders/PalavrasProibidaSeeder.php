<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PalavrasProibidaSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('app/Models/palavras_proibidas.json');
        if (!File::exists($path)) {
            $this->command->info("File not found: {$path}");
            return;
        }

        $content = File::get($path);
        $json = $this->extractJsonArray($content);
        $items = json_decode($json, true);

        if (!is_array($items)) {
            $this->command->error('Invalid JSON in palavras_proibidas.json');
            return;
        }

        foreach ($items as $item) {
            DB::table('palavras_proibidas')->updateOrInsert(
                ['id' => $item['id']],
                [
                    'palavra' => $item['palavra'] ?? null,
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
