<?php

namespace App\Console\Commands;

use App\Services\GoogleReviewsImporter;
use Illuminate\Console\Command;

class AvaliacoesImportarCommand extends Command
{
    protected $signature = 'avaliacoes:importar {arquivo : HTML salvo da tela "Ler avaliações" do Perfil da Empresa no Google}';

    protected $description = 'Converte as avaliações do Google em config/avaliacoes.php e baixa as fotos dos autores';

    public function handle(GoogleReviewsImporter $importer): int
    {
        $path = $this->argument('arquivo');

        if (! is_file($path)) {
            $this->error("Arquivo não encontrado: {$path}");

            return self::FAILURE;
        }

        $data = $importer->import(file_get_contents($path));
        $reviews = collect($data['reviews']);

        $this->info(sprintf(
            '%d avaliações de 4+ estrelas (média %s): %d com texto, %d fotos baixadas.',
            $reviews->count(),
            $data['rating'],
            $reviews->where('text', '!=', '')->count(),
            $reviews->whereNotNull('photo')->count(),
        ));
        $this->line('Gerado config/avaliacoes.php e public/'.GoogleReviewsImporter::PHOTOS_DIR.'. Rode "php artisan config:clear" se o cache de config estiver ativo.');

        return self::SUCCESS;
    }
}
