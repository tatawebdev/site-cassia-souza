<?php

namespace App\Services;

use App\Models\IndexedPage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * Envio de páginas para a Google Indexing API com registro em indexed_pages.
 * Usado pelo site (middleware IndexarNoGoogle, ao abrir a página) e pelo comando
 * google:indexing-sync (todas as páginas do sitemap de uma vez).
 *
 * Quando a cota diária da API acaba, todos os envios param por PAUSA_HORAS.
 */
class IndexacaoGoogle
{
    public const PAUSA = 'google-indexing:pausado-ate';

    public const PAUSA_HORAS = 36;

    public const OK = 'ok';

    public const LIMITE = 'limite';

    public const ERRO = 'erro';

    public function __construct(private GoogleIndexingService $indexing) {}

    public function url(string $url): string
    {
        return $this->indexing->toProductionUrl($url);
    }

    /** Até quando os envios estão pausados pelo limite diário (null = liberado) */
    public function pausadoAte(): ?Carbon
    {
        $ate = Cache::get(self::PAUSA);

        return $ate && now()->lt($ate) ? Carbon::parse($ate) : null;
    }

    public function liberarPausa(): void
    {
        Cache::forget(self::PAUSA);
    }

    public function jaIndexada(string $url): bool
    {
        return IndexedPage::where('url', $url)->whereNotNull('indexed_at')->exists();
    }

    /** Envia uma URL (já no domínio de produção) e registra o resultado: OK, LIMITE ou ERRO */
    public function enviar(string $url): string
    {
        $pagina = IndexedPage::firstOrNew(['url' => $url]);

        if ($this->indexing->notifyUrlUpdate($url)) {
            $pagina->fill(['indexed_at' => now(), 'last_error' => null])->save();

            return self::OK;
        }

        if ($this->indexing->ultimoErroFoiLimite()) {
            $ate = now()->addHours(self::PAUSA_HORAS);
            Cache::put(self::PAUSA, $ate, $ate);
            $pagina->fill(['last_error' => 'Limite diário da Indexing API atingido; envios pausados até '.$ate->format('d/m/Y H:i')])->save();

            return self::LIMITE;
        }

        $erro = $this->indexing->ultimoErro?->getMessage() ?? 'Falha ao notificar o Google Indexing API (ver storage/logs/laravel.log)';
        $pagina->fill(['last_error' => mb_substr($erro, 0, 1000)])->save();

        return self::ERRO;
    }
}
