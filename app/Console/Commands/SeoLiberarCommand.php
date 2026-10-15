<?php

namespace App\Console\Commands;

use App\Models\SeoLocalidade;
use App\Models\SeoPagina;
use App\Models\SeoTermo;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

/**
 * Libera para o Google, aos poucos e em ordem aleatória, combinações termo + localidade
 * que ainda estão com noindex. Prioridade: Alto Tietê (cidades e distritos), depois os
 * bairros do site antigo, depois as outras cidades de SP e por fim os outros estados;
 * só passa ao grupo seguinte quando o anterior acaba.
 *
 * Usa só os termos principais (indexar = true, sem canonical) e grava a decisão em
 * seo_paginas.indexar = true, então a página entra no sitemap e no envio ao Google.
 * Combinações com decisão manual em seo_paginas (liberada ou bloqueada) são respeitadas.
 */
class SeoLiberarCommand extends Command
{
    protected $signature = 'seo:liberar
        {--quantidade=20 : Quantas combinações liberar nesta rodada}
        {--simular : Só mostra o que seria liberado, sem gravar}
        {--enviar : Depois de liberar, envia as páginas novas ao Google (google:indexing-sync)}';

    protected $description = 'Libera aos poucos (aleatório, Alto Tietê primeiro) páginas de SEO termo + cidade para o Google';

    public function handle(): int
    {
        $termos = SeoTermo::where('ativo', true)->where('indexar', true)->whereNull('canonical')->get();
        if ($termos->isEmpty()) {
            $this->warn('Nenhum termo principal ativo.');

            return self::SUCCESS;
        }

        $quantidade = max(1, (int) $this->option('quantidade'));
        // Combinações que já têm decisão manual (liberadas ou bloqueadas)
        $decididas = SeoPagina::whereNotNull('indexar')->get(['seo_termo_id', 'seo_localidade_id'])
            ->map(fn ($p) => $p->seo_termo_id.'-'.$p->seo_localidade_id)->flip();

        $escolhidas = collect();
        foreach ($this->grupos() as $nome => $consulta) {
            $locais = $consulta->get()->shuffle();
            // Várias passadas pelo grupo: em cada uma, no máximo um termo (sorteado) por
            // localidade, para espalhar entre as cidades; só sai do grupo quando ele acaba
            do {
                $achou = false;
                foreach ($locais as $local) {
                    foreach ($termos->shuffle() as $termo) {
                        $chave = $termo->id.'-'.$local->id;
                        if (($termo->indexar && $local->indexar) || isset($decididas[$chave])) {
                            continue; // já está no Google pela regra geral, ou tem decisão manual
                        }
                        $escolhidas->push(['grupo' => $nome, 'termo' => $termo, 'local' => $local]);
                        $decididas[$chave] = true;
                        $achou = true;
                        break;
                    }
                    if ($escolhidas->count() >= $quantidade) {
                        break 3;
                    }
                }
            } while ($achou);
        }

        if ($escolhidas->isEmpty()) {
            $this->info('Não há mais combinações para liberar.');

            return self::SUCCESS;
        }

        $this->table(['Grupo', 'Endereço'], $escolhidas->map(fn ($e) => [$e['grupo'], '/'.$e['termo']->slug.'/'.$e['local']->slug]));

        if ($this->option('simular')) {
            $this->warn('Simulação: nada foi gravado.');

            return self::SUCCESS;
        }

        foreach ($escolhidas as $e) {
            SeoPagina::updateOrCreate(
                ['seo_termo_id' => $e['termo']->id, 'seo_localidade_id' => $e['local']->id],
                ['indexar' => true, 'notas' => 'Liberada pelo seo:liberar em '.now()->format('d/m/Y H:i')]
            );
        }
        $this->info($escolhidas->count().' páginas liberadas. Restantes por grupo: '.$this->restantes($termos));

        if ($this->option('enviar')) {
            $this->call('google:indexing-sync');
        } else {
            $this->line('Para enviar ao Google agora: php artisan google:indexing-sync');
        }

        return self::SUCCESS;
    }

    /** Grupos em ordem de prioridade (consultas de localidades, sem homônimos) */
    private function grupos(): array
    {
        $base = fn () => SeoLocalidade::query()->where('tipo', '!=', 'homonimo');

        return [
            'Alto Tietê' => $base()->where('presencial', true),
            'Bairros' => $base()->where('tipo', 'bairro'),
            'Estado de SP' => $base()->where('presencial', false)->where('tipo', '!=', 'bairro')->where('uf', 'SP'),
            'Outros estados' => $base()->where('presencial', false)->where('tipo', '!=', 'bairro')
                ->where(fn ($q) => $q->where('uf', '!=', 'SP')->orWhereNull('uf')),
        ];
    }

    /** Resumo de quantas localidades de cada grupo ainda têm termo a liberar */
    private function restantes(Collection $termos): string
    {
        $liberadas = SeoPagina::where('indexar', true)->whereIn('seo_termo_id', $termos->pluck('id'))
            ->selectRaw('seo_localidade_id, count(*) as n')->groupBy('seo_localidade_id')->pluck('n', 'seo_localidade_id');
        $total = $termos->count();

        return collect($this->grupos())->map(function ($consulta, $nome) use ($liberadas, $total) {
            $faltam = 0;
            foreach ($consulta->get(['id', 'indexar']) as $l) {
                $faltam += $l->indexar ? 0 : $total - ($liberadas[$l->id] ?? 0);
            }

            return "{$nome}: {$faltam}";
        })->implode(' · ');
    }
}
