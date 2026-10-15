<?php

namespace Tests\Feature;

use Tests\TestCase;

class LlmsTest extends TestCase
{
    public function test_llms_txt_sai_da_config_de_servicos(): void
    {
        $resposta = $this->get('/llms.txt')->assertOk();

        $this->assertStringStartsWith('text/plain', $resposta->headers->get('Content-Type'));
        $texto = $resposta->getContent();

        $this->assertStringStartsWith('# Cassia Souza Advocacia Tributária', $texto);
        foreach (config('servicos') as $servico) {
            $this->assertStringContainsString('['.$servico['title'].']('.route($servico['route']).')', $texto);
        }
        $this->assertStringNotContainsString('—', $texto);
        $this->assertStringNotContainsString('Cássia', $texto);
    }
}
