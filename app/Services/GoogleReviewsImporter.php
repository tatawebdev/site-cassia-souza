<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;

/**
 * Converte o HTML salvo da tela "Ler avaliações" do Perfil da Empresa no
 * Google em um array (config/avaliacoes.php) e baixa as fotos dos autores
 * para public/assets/avaliacoes — o site não chama o Google em produção.
 */
class GoogleReviewsImporter
{
    public const PHOTOS_DIR = 'assets/avaliacoes';

    public const MIN_RATING = 4;

    /** @return array<int, array{id: ?string, rating: int, text: string, author: ?string, photo_url: ?string, date: ?string, reply: ?string}> */
    public function parse(string $html): array
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="UTF-8">'.$html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();
        $xpath = new \DOMXPath($dom);

        $class = fn (string $name) => "contains(concat(' ', normalize-space(@class), ' '), ' {$name} ')";
        $first = fn (string $query, \DOMNode $context) => $xpath->query($query, $context)->item(0);

        $reviews = [];
        // Cada avaliação (e a resposta da proprietária) fica num div.kx2i0d
        foreach ($xpath->query("//div[{$class('kx2i0d')}]") as $block) {
            $article = $first(".//article[{$class('VaHEVc')}]", $block);
            if (! $article) {
                continue;
            }

            $author = $first(".//a[{$class('PskQHd')}][contains(@href, '/contrib/')]", $article);
            $stars = $first(".//span[@role='img'][contains(@aria-label, 'estrela')]", $article);
            $when = $this->inlineText($first(".//span[{$class('KEfuhb')}]", $article));
            // Texto longo: versão completa (escondida); curto: direto no div
            $text = $first(".//div[@jsname='PBWx0c']", $article)
                ?? $first(".//div[{$class('Fv38Af')}][{$class('JhRJje')}]", $article);

            $reviews[] = [
                'id' => $first('.//*[@data-review-id]', $article)?->getAttribute('data-review-id'),
                'rating' => $stars && preg_match('/(\d)\s+de\s+5/', $stars->getAttribute('aria-label'), $m) ? (int) $m[1] : 0,
                'text' => $this->nodeText($text),
                // O <a> do autor termina com o ícone "open_in_new"
                'author' => $author ? $this->inlineText($author->firstChild) : null,
                'photo_url' => $first(".//img[{$class('ooGZkf')}]", $article)?->getAttribute('src'),
                'date' => $when ? $this->relativeToDate($when)?->toDateString() : null,
                'reply' => $this->nodeText($first(".//div[{$class('uZ1mGe')}]", $block)) ?: null,
            ];
        }

        if (! $reviews) {
            throw new RuntimeException('Nenhuma avaliação encontrada. Salve a página "Ler avaliações" do Perfil da Empresa depois de rolar até carregar todas.');
        }

        return $reviews;
    }

    /**
     * Baixa as fotos, grava config/avaliacoes.php e devolve o array gravado.
     * Fotos que falharem ficam sem imagem (o site mostra a inicial do nome).
     */
    public function import(string $html): array
    {
        // Só guardamos avaliações de 4 ou 5 estrelas
        $reviews = array_values(array_filter($this->parse($html), fn ($review) => $review['rating'] >= self::MIN_RATING));

        $dir = public_path(self::PHOTOS_DIR);
        File::ensureDirectoryExists($dir);
        File::cleanDirectory($dir);

        foreach ($reviews as &$review) {
            $review['photo'] = $this->downloadPhoto($review, $dir);
            // O site mostra só o que os clientes escreveram, não as respostas
            unset($review['photo_url'], $review['reply']);
        }
        unset($review);

        $rated = array_filter(array_column($reviews, 'rating'));
        $data = [
            'imported_at' => now()->toDateString(),
            'rating' => $rated ? round(array_sum($rated) / count($rated), 1) : null,
            'reviews' => $reviews,
        ];

        File::put(config_path('avaliacoes.php'), implode("\n", [
            '<?php',
            '',
            '// Avaliações do perfil da Cassia no Google. Gerado por',
            '// "php artisan avaliacoes:importar <html>" — não editar à mão.',
            '',
            'return '.$this->export($data).';',
            '',
        ]));

        return $data;
    }

    private function downloadPhoto(array $review, string $dir): ?string
    {
        if (! $review['photo_url']) {
            return null;
        }

        // A foto do painel vem em 50px; pedimos 120px para telas de alta densidade
        $url = preg_replace('/=s\d+-/', '=s120-', $review['photo_url']);

        try {
            $response = Http::timeout(20)->get($url);
        } catch (\Throwable) {
            return null;
        }

        if ($response->failed() || ! str_starts_with($response->header('Content-Type'), 'image/')) {
            return null;
        }

        $extension = match ($response->header('Content-Type')) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            default => 'jpg',
        };
        $name = substr(md5($review['id'] ?? $review['photo_url']), 0, 12).'.'.$extension;
        File::put($dir.'/'.$name, $response->body());

        return self::PHOTOS_DIR.'/'.$name;
    }

    /** var_export com sintaxe curta e indentação de 4 espaços. */
    private function export(mixed $value, int $level = 0): string
    {
        if ($value === null) {
            return 'null';
        }

        if (! is_array($value)) {
            return var_export($value, true);
        }

        $pad = str_repeat('    ', $level + 1);
        $list = array_is_list($value);
        $lines = array_map(
            fn ($key, $item) => $pad.($list ? '' : var_export($key, true).' => ').$this->export($item, $level + 1).',',
            array_keys($value),
            $value
        );

        return "[\n".implode("\n", $lines)."\n".str_repeat('    ', $level).']';
    }

    /** Texto do nó preservando só as quebras de linha reais (<br>). */
    private function nodeText(?\DOMNode $node): string
    {
        if (! $node) {
            return '';
        }

        // Quebras e indentação do código-fonte viram espaço
        $html = preg_replace('/<br\s*\/?>/i', '{{BR}}', $node->ownerDocument->saveHTML($node));
        $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);
        $text = preg_replace('/\s*\{\{BR\}\}\s*/', "\n", $text);

        return trim($text);
    }

    private function inlineText(?\DOMNode $node): ?string
    {
        return $node ? trim(preg_replace('/\s+/u', ' ', $node->textContent)) : null;
    }

    /** "Há 11 semanas" → data aproximada, para a idade continuar certa com o tempo. */
    private function relativeToDate(string $text): ?Carbon
    {
        $text = mb_strtolower($text);

        if (str_contains($text, 'hoje') || str_contains($text, 'agora')) {
            return now();
        }

        if (! preg_match('/(\d+|um|uma)\s+(minuto|hora|dia|semana|m[eê]s|meses|ano)/u', $text, $m)) {
            return null;
        }

        $n = is_numeric($m[1]) ? (int) $m[1] : 1;

        return match (true) {
            str_starts_with($m[2], 'minuto') => now()->subMinutes($n),
            str_starts_with($m[2], 'hora') => now()->subHours($n),
            str_starts_with($m[2], 'dia') => now()->subDays($n),
            str_starts_with($m[2], 'semana') => now()->subWeeks($n),
            str_starts_with($m[2], 'ano') => now()->subYears($n),
            default => now()->subMonths($n),
        };
    }
}
