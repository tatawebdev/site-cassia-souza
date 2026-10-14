<?php

namespace Tests\Feature;

use Tests\TestCase;

class PaginasServicoTest extends TestCase
{
    public function test_cada_servico_tem_titulo_seo_secoes_e_faq(): void
    {
        foreach (config('servicos') as $servico) {
            $resposta = $this->get(route($servico['route']));
            $resposta->assertOk();

            $resposta->assertSee('<title>'.e($servico['titulo_seo']).'</title>', false);
            foreach ($servico['secoes'] as $secao) {
                $resposta->assertSee($secao['pergunta']);
            }
            foreach ($servico['fontes'] ?? [] as $fonte) {
                $resposta->assertSee($fonte['url'], false);
            }

            $this->assertNotEmpty(
                collect(config('faqs'))->whereIn('tema', $servico['faq'])->all(),
                "Serviço {$servico['slug']} sem perguntas frequentes"
            );
        }
    }

    public function test_textos_novos_sem_travessao_e_sem_acento_no_nome(): void
    {
        $texto = json_encode([config('servicos'), config('faqs')], JSON_UNESCAPED_UNICODE);

        $this->assertStringNotContainsString('—', $texto);
        $this->assertStringNotContainsString('Cássia', $texto);
    }

    public function test_avaliacoes_saem_uma_vez_so_no_html(): void
    {
        $html = $this->get(route('servicos.planejamento.tributario'))->getContent();
        $reviews = array_filter(config('avaliacoes.reviews', []), fn ($r) => $r['rating'] >= 4 && $r['text'] !== '');

        $this->assertSame(count($reviews), substr_count($html, 'aria-roledescription="avaliação"'));
    }
}
