<?php

namespace App\Services;

class ServicoService
{
    public static function getServicos()
    {
        
        return [
            'regularizacao_pgfn' => [
                'titulo' => 'REGULARIZAÇÃO DE DÉBITOS FEDERAIS - PGFN',
                'short_titulo' => 'Regularização PGFN',
                'numero' => '2.2',
                'descricao_short' => 'Negociação de débitos federais junto à PGFN com descontos e parcelamentos especiais.',
                'descricao' => 'Dívidas com a União não precisam ser um peso permanente no seu negócio.\n\nAtuamos na negociação de débitos inscritos em Dívida Ativa junto à PGFN, buscando descontos nos juros e multas e parcelamentos especiais, inclusive com revisão da CAPAG para adequar a capacidade de pagamento à realidade da sua empresa.\n\nCom isso, sua empresa evita execuções fiscais, bloqueios da conta bancária e penhora de bens, recuperando credibilidade e fôlego financeiro.\n\nNão deixe que a Dívida Ativa comprometa o futuro do seu negócio.\n\nFale conosco e inicie a regularização com segurança e apoio jurídico especializado.',
                'icone' => 'fa-solid fa-scale-balanced',
                'images' => ''
            ],
            'planejamento_tributario' => [
                'titulo' => '2.3 PLANEJAMENTO TRIBUTÁRIO',
                'short_titulo' => 'Planejamento Tributário',
                'descricao_short' => 'Estratégias para pagar apenas o devido, com segurança e economia.',
                'descricao' => 'Pagar tributos de forma inteligente não é apenas reduzir custos — é ganhar segurança, previsibilidade e liberdade para crescer.\n\nNosso planejamento tributário é estruturado sob medida para que sua empresa pague apenas o que é devido, sem riscos de autuações e com total conformidade legal.\n\nApoiamos desde a escolha do regime tributário mais vantajoso (inclusive para novos CNPJs) até a reestruturação de empresas em operação, identificando oportunidades de economia e fortalecendo a saúde financeira do negócio.\n\nCom a estratégia certa, você transforma os tributos em aliados do crescimento.\n\nFale conosco e descubra como otimizar sua carga tributária com inteligência e segurança.',
                'icone' => 'fa-solid fa-chart-line',
            ],
            'planejamento_clinicas' => [
                'titulo' => '2.4 PLANEJAMENTO TRIBUTÁRIO PARA CLÍNICAS MÉDICAS E ODONTOLÓGICAS',
                'short_titulo' => 'Planejamento Clínicas',
                'descricao_short' => 'Redução de impostos para clínicas médicas e odontológicas com enquadramento correto.',
                'descricao' => 'Muitos gestores da área da saúde pagam mais impostos do que deveriam simplesmente por desconhecer oportunidades previstas em lei.\n\nPara as clínicas médicas e odontológicas existe a possibilidade de reduzir de forma significativa a carga tributária por meio de enquadramentos específicos, como a equiparação hospitalar no Lucro Presumido.\n\nNosso papel é estruturar um planejamento tributário personalizado, que garanta economia real, segurança jurídica e previsibilidade financeira, sempre com ética e dentro da legalidade.\n\nSe a sua clínica busca pagar apenas o justo e aumentar a rentabilidade sem riscos, fale conosco.',
                'icone' => 'fa-solid fa-stethoscope',
            ],
            'assessoria_reforma_tributaria' => [
                'titulo' => '2.5 ASSESSORIA PARA A REFORMA TRIBUTÁRIA',
                'short_titulo' => 'Assessoria Reforma',
                'descricao_short' => 'Preparação e adaptação estratégica para a Reforma Tributária.',
                'descricao' => 'A Reforma Tributária está transformando o sistema tributário brasileiro.\n\nA questão é: sua empresa está preparada para as mudanças?\n\nOferecemos assessoria jurídica especializada para ajudar empresários a compreender os impactos da Reforma e a se adaptar com segurança, clareza e orientações estratégicas.\n\nCom nossa assessoria, você terá apoio em:\n\nAnálise dos principais pontos da Reforma Tributária e seus efeitos diretos na sua empresa;\n\nAvaliação dos impactos na carga tributária e no fluxo financeiro;\n\nEstratégias de transição para o novo modelo tributário;\n\nIdentificação de riscos e oportunidades no novo cenário;\n\nTreinamentos e materiais práticos para gestores e equipes.\n\nAntecipe-se às mudanças e transforme a Reforma Tributária em oportunidade.\n\nFale conosco e garanta que sua empresa avance com confiança.',
                'icone' => 'fa-solid fa-gavel',
            ],
            'treinamento_tributario' => [
                'titulo' => '2.7 TREINAMENTO TRIBUTÁRIO PARA EMPRESAS',
                'short_titulo' => 'Treinamento Tributário',
                'descricao_short' => 'Capacitação empresarial para gestão tributária eficiente e segura.',
                'descricao' => 'Prepare sua equipe para enfrentar os desafios tributários do dia a dia com segurança, clareza e eficiência.\n\nOferecemos treinamentos personalizados em gestão tributária, desenhados para empresas que querem reduzir riscos, evitar autuações e otimizar rotinas fiscais.\n\nNossos treinamentos são realizados presencialmente ou online, sempre com linguagem simples, exemplos práticos e foco na realidade da sua empresa.\n\nFale conosco e descubra como capacitar sua equipe para transformar conhecimento tributário em segurança e resultados.',
                'icone' => 'fa-solid fa-chalkboard-teacher',
            ],
            'recuperacao_pis_cofins' => [
                'titulo' => '2.8 RECUPERAÇÃO DE PIS E COFINS MONOFÁSICOS',
                'short_titulo' => 'Recuperação PIS/COFINS',
                'descricao_short' => 'Recuperação de valores pagos indevidamente em PIS e COFINS monofásicos.',
                'descricao' => 'Muitas empresas acabam pagando PIS e COFINS monofásicos além do necessário, sem perceber que esses valores podem ser recuperados de forma legal e estratégica.\n\nNós analisamos as operações, identificamos créditos tributários legítimos e aplicamos a legislação vigente para transformar pagamentos indevidos em recursos que fortalecem o caixa da sua empresa.\n\nCom segurança jurídica e atuação especializada, ajudamos sua empresa a reduzir custos, ganhar fôlego financeiro e investir no que realmente importa: o crescimento do seu negócio.\n\nFale conosco e descubra quanto sua empresa pode recuperar.',
                'icone' => 'fa-solid fa-money-bill-wave',
            ],
        ];
    }
}
