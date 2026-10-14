<?php

/*
 * Serviços do escritório, usados pelo tema novo (menu, home, rodapé e as
 * páginas /servicos/<slug>, montadas por resources/views/novo/servico.blade.php).
 *
 * - problem: o problema que o visitante reconhece em si (home, listagem)
 * - text: resumo curto (cards)
 * - image: pasta em public/assets/servicos/detalhes (imagem1.jpg, imagem2.jpg)
 * - banner: foto de fundo do banner da página (public/assets/images)
 * - abertura/destaque/como/lista/fechamento: conteúdo da página do serviço,
 *   o mesmo das páginas antigas (sem inventar fatos)
 * - faq: temas de config/faqs.php mostrados na página
 */

return [
    [
        'slug' => 'planejamento-tributario',
        'problem' => 'Não sei se estou no regime tributário mais vantajoso',
        'title' => 'Planejamento Tributário',
        'text' => 'Da escolha do regime mais vantajoso, inclusive para novos CNPJs, à reestruturação de empresas em operação, para pagar apenas o devido.',
        'route' => 'servicos.planejamento.tributario',
        'image' => 'planejamento-tributario',
        'banner' => 'banner-planejamento-tributario.jpg',
        'descricao' => 'Estratégias tributárias sob medida para reduzir a carga fiscal, garantir previsibilidade e apoiar o crescimento seguro da empresa.',
        'abertura' => [
            'Pagar tributos de forma inteligente não é apenas reduzir custos: é ganhar segurança, previsibilidade e liberdade para crescer.',
            'Nosso planejamento tributário é estruturado sob medida para que sua empresa pague apenas o que é devido, sem riscos de autuações e com total conformidade legal.',
        ],
        'destaque' => 'Segurança e previsibilidade tributária para decisões confiantes.',
        'como_titulo' => 'Do regime certo à reestruturação',
        'como' => [
            'Apoiamos desde a escolha do regime tributário mais vantajoso, inclusive para novos CNPJs, até a reestruturação de empresas em operação, identificando oportunidades de economia e fortalecendo a saúde financeira do negócio.',
            'Com a estratégia certa, você transforma os tributos em aliados do crescimento.',
        ],
        'lista' => [],
        'fechamento' => 'Fale conosco e descubra como otimizar sua carga tributária com inteligência e segurança.',
        'faq' => ['regime'],
    ],
    [
        'slug' => 'recuperacao-pis-cofins-monofasicos',
        'problem' => 'Vendo produtos monofásicos e recolho tudo pelo Simples Nacional',
        'title' => 'Recuperação de PIS/COFINS monofásicos',
        'text' => 'Analisamos operações, identificamos créditos legítimos dos últimos 5 anos e recuperamos os valores de forma legal.',
        'route' => 'servicos.recuperacao.pis.cofins.monofasicos',
        'image' => 'recuperacao-piscofins',
        'banner' => 'banner-recuperacao-pis-cofins.jpg',
        'descricao' => 'Analisamos operações, identificamos créditos legítimos e recuperamos valores de PIS/COFINS monofásicos de forma legal, devolvendo recursos importantes ao caixa.',
        'abertura' => [
            'Muitas empresas acabam pagando PIS e COFINS monofásicos além do necessário, sem perceber que esses valores podem ser recuperados de forma legal e estratégica.',
        ],
        'destaque' => 'Recupere créditos e melhore seu fluxo de caixa.',
        'como_titulo' => 'Pagamentos indevidos que voltam para o caixa',
        'como' => [
            'Analisamos as operações, identificamos créditos tributários legítimos e aplicamos a legislação vigente para transformar pagamentos indevidos em recursos que fortalecem o caixa da sua empresa.',
            'Com segurança jurídica e atuação especializada, ajudamos sua empresa a reduzir custos, ganhar fôlego financeiro e investir no que realmente importa: o crescimento do seu negócio.',
        ],
        'lista' => [],
        'fechamento' => 'Fale conosco e descubra quanto sua empresa pode recuperar.',
        'faq' => ['pis-cofins'],
    ],
    [
        'slug' => 'regularizacao-debitos-pgfn',
        'problem' => 'Minha empresa tem débitos inscritos em Dívida Ativa da União',
        'title' => 'Regularização de débitos (PGFN)',
        'text' => 'Negociamos com a PGFN descontos em juros e multas e parcelamentos especiais, inclusive com revisão da CAPAG, para evitar execução fiscal, bloqueio de conta e penhora de bens.',
        'route' => 'servicos.regularizacao.debitos.pgfn',
        'image' => 'regularizacao-debitos-pgfn',
        'banner' => 'banner-regularizacao-pgfn.jpg',
        'descricao' => 'Negociamos débitos inscritos em Dívida Ativa com descontos, parcelamentos prolongados e pedido de revisão da CAPAG, gerando fôlego financeiro e evitando bloqueios.',
        'abertura' => [
            'Dívidas com a União não precisam ser um peso permanente no seu negócio.',
        ],
        'destaque' => 'Negociação e soluções para dívidas ativas.',
        'como_titulo' => 'Negociação com a PGFN',
        'como' => [
            'Atuamos na negociação de débitos inscritos em Dívida Ativa junto à PGFN, buscando descontos nos juros e multas e parcelamentos especiais, inclusive com revisão da CAPAG para adequar a capacidade de pagamento à realidade da sua empresa.',
            'Com isso, sua empresa evita execuções fiscais, bloqueios da conta bancária e penhora de bens, recuperando credibilidade e fôlego financeiro.',
        ],
        'lista' => [],
        'fechamento' => 'Não deixe que a Dívida Ativa comprometa o futuro do seu negócio: inicie a regularização com segurança e apoio jurídico especializado.',
        'faq' => ['pgfn'],
    ],
    [
        'slug' => 'assessoria-reforma-tributaria',
        'problem' => 'Quero saber o que a Reforma Tributária muda para mim',
        'title' => 'Assessoria para Reforma Tributária',
        'text' => 'Analisamos os efeitos da Reforma na sua carga tributária e no fluxo de caixa e planejamos a transição para o novo modelo, com riscos e oportunidades mapeados.',
        'route' => 'servicos.assessoria.reforma.tributaria',
        'image' => 'assessoria-reforma-tributaria',
        'banner' => 'banner-assessoria-reforma.jpg',
        'descricao' => 'Assessoria especializada para entender impactos da reforma, reduzir riscos e adaptar processos com segurança.',
        'abertura' => [
            'A Reforma Tributária está transformando o sistema tributário brasileiro. A questão é: sua empresa está preparada para as mudanças?',
            'Oferecemos assessoria jurídica especializada para ajudar empresários a compreender os impactos da Reforma e a se adaptar com segurança, clareza e orientações estratégicas.',
        ],
        'destaque' => 'Antecipe-se às mudanças e transforme a Reforma Tributária em oportunidade.',
        'como_titulo' => 'Com nossa assessoria, você terá apoio em',
        'como' => [],
        'lista' => [
            'Análise dos principais pontos da Reforma Tributária e seus efeitos diretos na sua empresa',
            'Avaliação dos impactos na carga tributária e no fluxo financeiro',
            'Estratégias de transição para o novo modelo tributário',
            'Identificação de riscos e oportunidades no novo cenário',
            'Treinamentos e materiais práticos para gestores e equipes',
        ],
        'fechamento' => 'Fale conosco e garanta que sua empresa avance com confiança.',
        'faq' => ['reforma'],
    ],
    [
        'slug' => 'planejamento-tributario-clinicas',
        'problem' => 'Tenho uma clínica médica ou odontológica',
        'title' => 'Planejamento Tributário para Clínicas',
        'text' => 'Clínicas médicas e odontológicas podem reduzir a carga tributária com enquadramentos previstos em lei, como a equiparação hospitalar no Lucro Presumido.',
        'route' => 'servicos.planejamento.tributario.clinicas',
        'image' => 'planejamento-clinicas',
        'banner' => 'banner-planejamento-clinicas.jpg',
        'descricao' => 'Planejamento tributário especializado para clínicas médicas e odontológicas, buscando economia legal, previsibilidade e maior rentabilidade.',
        'abertura' => [
            'Muitos gestores da área da saúde pagam mais impostos do que deveriam simplesmente por desconhecer oportunidades previstas em lei.',
            'Para as clínicas médicas e odontológicas existe a possibilidade de reduzir de forma significativa a carga tributária por meio de enquadramentos específicos, como a equiparação hospitalar no Lucro Presumido.',
        ],
        'destaque' => 'Soluções tributárias para o setor da saúde com foco em resultados.',
        'como_titulo' => 'Planejamento feito para a realidade da saúde',
        'como' => [
            'Nosso papel é estruturar um planejamento tributário personalizado, que garanta economia real, segurança jurídica e previsibilidade financeira, sempre com ética e dentro da legalidade.',
        ],
        'lista' => [],
        'fechamento' => 'Se a sua clínica busca pagar apenas o justo e aumentar a rentabilidade sem riscos, fale conosco.',
        'faq' => ['regime'],
    ],
    [
        'slug' => 'consultoria-tributaria',
        'problem' => 'Preciso de acompanhamento tributário todo mês',
        'title' => 'Consultoria Tributária',
        'text' => 'Revisamos suas movimentações fiscais mês a mês, corrigimos falhas antes que virem autuações e apontamos oportunidades de economia.',
        'route' => 'servicos.consultoria.tributaria',
        'image' => 'consultoria-tributaria',
        'banner' => 'banner-consultoria-tributaria.jpg',
        'descricao' => 'Consultoria mensal que revisa movimentações fiscais, previne riscos e identifica oportunidades para garantir conformidade e economia.',
        'abertura' => [
            'A rotina de um empresário já é cheia de desafios, e a área tributária não precisa ser mais um deles.',
            'Nossa consultoria acompanha sua empresa de forma contínua, garantindo que cada operação seja realizada com segurança e dentro da lei.',
        ],
        'destaque' => 'Tranquilidade fiscal para sua empresa crescer com segurança e sem surpresas.',
        'como_titulo' => 'Acompanhamento mês a mês',
        'como' => [
            'Revisamos suas movimentações fiscais, identificamos riscos, corrigimos falhas e apontamos oportunidades de economia. Assim, você evita autuações, mantém regularidade e toma decisões mais seguras para o crescimento do negócio.',
            'Com esse suporte, sua empresa ganha tranquilidade e resultados consistentes mês a mês.',
        ],
        'lista' => [],
        'fechamento' => 'Fale conosco e descubra como podemos ser o parceiro tributário que acompanha o seu crescimento.',
        'faq' => ['consultoria'],
    ],
    [
        'slug' => 'treinamento-tributario',
        'problem' => 'Minha equipe precisa dominar a rotina tributária',
        'title' => 'Treinamento Tributário para Empresas',
        'text' => 'Turmas presenciais ou online, com exemplos e exercícios da realidade do seu departamento fiscal e financeiro, para evitar erros que geram autuações.',
        'route' => 'servicos.treinamento.tributario',
        'image' => 'treinamento-tributario',
        'banner' => 'banner-treinamento-tributario.jpg',
        'descricao' => 'Treinamentos práticos para equipes fiscais: reduzir riscos, evitar autuações e otimizar rotinas, presencial ou online.',
        'abertura' => [
            'Treinamos sua equipe em gestão tributária com clareza e exemplos práticos.',
            'Capacitação personalizada para reduzir riscos, evitar autuações e otimizar rotinas fiscais, presencial ou online.',
        ],
        'destaque' => 'Transforme conhecimento em segurança e resultados.',
        'como_titulo' => 'Treinamentos práticos e aplicáveis',
        'como' => [
            'Nossos treinamentos têm materiais e exercícios pensados para a realidade do seu departamento fiscal e financeiro.',
            'Podemos oferecer turmas presenciais ou programas online adaptados à sua empresa.',
        ],
        'lista' => [],
        'fechamento' => 'Capacite sua equipe e minimize erros operacionais que geram autuações e custos desnecessários. Solicite nossa proposta de treinamento.',
        'faq' => [],
    ],
];
