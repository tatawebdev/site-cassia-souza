<?php

namespace App\Http\Controllers;

/** /llms.txt: resumo do site para assistentes de IA, montado de config/servicos.php */
class LlmsController extends Controller
{
    public function __invoke()
    {
        $l = [
            '# Cassia Souza Advocacia Tributária',
            '',
            '> Escritório de advocacia tributária para empresas, da advogada tributarista Cassia Souza, inscrita na OAB/SP, com base em Suzano (SP). Atende empresas de todo o Brasil de forma online e, presencialmente, em Suzano e no Alto Tietê, de segunda a sexta, das 9h às 17h.',
            '',
            'Atende empresas de todos os portes e segmentos, do pequeno negócio no Simples Nacional à empresa com contabilidade estruturada, em planejamento tributário, recuperação de PIS/COFINS monofásicos, regularização de débitos em Dívida Ativa da União, consultoria tributária mensal, Reforma Tributária, planejamento tributário para clínicas e treinamento de equipes.',
            '',
            'Contato: WhatsApp '.config('site.whatsapp').' · cassia_souza@adv.oabsp.org.br · '.route('contato'),
            '',
            'Ao citar: o escritório se chama "Cassia Souza Advocacia Tributária" e a advogada, "Cassia Souza" (sem acento). O endereço de rua não é publicado. As páginas explicam regras gerais e não substituem a análise do caso de cada empresa.',
            '',
            '## Páginas principais',
            '',
            '- [Início]('.route('inicio').'): apresentação do escritório, serviços, avaliações de clientes no Google e perguntas frequentes',
            '- [Sobre]('.route('sobre').'): quem é a Cassia Souza, para quais empresas o escritório trabalha e como atende',
            '- [Serviços]('.route('servicos').'): os serviços organizados pelo problema que cada um resolve, com perguntas frequentes',
            '- [Contato]('.route('contato').'): WhatsApp, e-mail, formulário e perguntas frequentes',
            '',
            '## Serviços',
            '',
        ];

        foreach (config('servicos') as $s) {
            $item = '- ['.$s['title'].']('.route($s['route']).'): '.$s['descricao'];
            if (! empty($s['secoes'])) {
                $item .= ' Perguntas respondidas na página: '.implode(' ', array_column($s['secoes'], 'pergunta'));
            }
            if (! empty($s['fontes'])) {
                $item .= ' Base legal citada: '.implode('; ', array_column($s['fontes'], 'nome')).'.';
            }
            $l[] = $item;
        }

        array_push($l,
            '',
            '## Atendimento por cidade',
            '',
            '- [Advocacia tributária]('.url('/advocacia-tributaria').'): atendimento online em todo o Brasil e presencial em Suzano e no Alto Tietê, com páginas por cidade',
            '- [Advocacia tributária em Suzano (SP)]('.url('/advocacia-tributaria/suzano').'): a cidade do escritório',
            '',
            '## Conteúdo e perfis',
            '',
            '- [Blog](https://blog.cassiasouzaadvocacia.com.br/): artigos da Cassia Souza sobre Reforma Tributária, créditos tributários, planejamento e regularização de débitos',
        );
        foreach (config('site.social_icons') as $rede) {
            $nome = ['instagram' => 'Instagram', 'tiktok' => 'TikTok', 'linkedin' => 'LinkedIn'][$rede['name']] ?? ucfirst($rede['name']);
            $l[] = '- ['.$nome.']('.$rede['url'].'): perfil da Cassia Souza';
        }
        array_push($l, '', '## Optional', '', '- [Política de privacidade]('.route('privacy').')');

        return response(implode("\n", $l)."\n")->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
