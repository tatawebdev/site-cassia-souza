<?php

/*
 * Conteúdo inicial das páginas de SEO /{termo}/{localidade}. O comando
 * `php artisan seo:importar` grava isto no banco só quando o termo ou o bloco
 * ainda não existe: depois disso, o texto é editado no banco (seo_termos,
 * seo_blocos, seo_paginas), não aqui.
 *
 * Marcadores trocados em cada página:
 *   {local}      Suzano · Jundiapeba · Jardim Suzano
 *   {local_uf}   Suzano (SP) · Jundiapeba (SP) · Jardim Suzano
 *   {estado}     São Paulo            {do_estado}  de São Paulo · do Paraná · da Bahia
 *   {regiao}     microrregião do IBGE (Mogi das Cruzes)
 *   {termo}      nome do termo
 *   {atendimento} "atendimento presencial ou online" (Alto Tietê) ou "atendimento online"
 *
 * Tom: o mesmo do site. Explica, não promete resultado, não assusta e não
 * inventa números, prêmios ou casos.
 */

$tributarista = [
    [
        'Em {local}, como em qualquer lugar do país, a pergunta de quem empreende costuma ser a mesma: estou pagando o tributo certo, no regime certo? A resposta depende das atividades, do faturamento e da forma como a empresa está organizada.',
        'A Cassia Souza é advogada tributarista inscrita na OAB/SP e atende empresas de todos os portes e segmentos. O trabalho começa entendendo a operação da empresa para indicar o caminho tributário que faz sentido para ela.',
    ],
    [
        'Para quem empreende em {local_uf}, os tributos são um dos maiores custos do negócio, e boa parte das dúvidas só aparece quando algo já deu errado: um débito, uma cobrança, uma mudança de regime.',
        'Com uma advogada tributarista acompanhando a empresa, essas questões são vistas antes: o enquadramento, os créditos que podem ser recuperados e o que a Reforma Tributária muda na rotina.',
    ],
    [
        'A Cassia Souza atende empresas de {local} que querem entender a própria carga tributária e tomar decisões com segurança jurídica, sem juridiquês.',
        'Do planejamento do regime à regularização de débitos com a União, cada caso é analisado a partir dos documentos e da realidade da empresa, e não de fórmulas prontas.',
    ],
];

$advocacia = [
    [
        'A advocacia tributária cuida da relação entre a empresa e o Fisco: o regime em que ela está, os tributos que recolhe, os créditos que pode recuperar e as dívidas que precisa resolver.',
        'Para empresas de {local_uf}, a Cassia Souza Advocacia Tributária faz esse acompanhamento de forma consultiva e preventiva, com linguagem simples e decisões explicadas passo a passo.',
    ],
    [
        'Pagar apenas o que é devido exige conhecer bem a legislação e a operação da empresa. É nesse ponto que a advocacia tributária ajuda quem empreende em {local}.',
        'O escritório analisa o enquadramento, revisa o que já foi pago, identifica riscos e organiza a empresa para as mudanças da Reforma Tributária.',
    ],
    [
        'Comércio, serviços, indústria e saúde têm desafios tributários diferentes, mas, para qualquer empresa de {local}, o ponto de partida é o mesmo: saber onde ela está hoje e para onde pode ir dentro da lei.',
        'A Cassia Souza Advocacia Tributária atende esses negócios com consultoria contínua ou em frentes específicas, como planejamento, recuperação de créditos e regularização de débitos.',
    ],
];

$escritorio = [
    [
        'Procurar um escritório de advocacia tributária é, quase sempre, procurar alguém que entenda a sua empresa antes de propor qualquer mudança.',
        'O escritório Cassia Souza Advocacia Tributária atende empresas de {local_uf} com análise do regime tributário, recuperação de créditos, regularização de débitos e acompanhamento mensal.',
    ],
    [
        'Empresários de {local} chegam ao escritório com perguntas diferentes: se o Simples Nacional ainda compensa, se há tributo pago a mais, como negociar uma dívida com a União.',
        'Cada pergunta começa com uma conversa e com a análise dos documentos da empresa. Só depois vem a recomendação, explicada sem juridiquês.',
    ],
    [
        'O escritório Cassia Souza Advocacia Tributária trabalha só com direito tributário, para empresas de todos os portes e segmentos, inclusive de {local}.',
        'O foco é prevenção: acompanhar a empresa para que ela pague o que é devido, aproveite o que a lei permite e não seja surpreendida por autuações.',
    ],
];

$planejamento = [
    [
        'O planejamento tributário começa por uma pergunta simples: a sua empresa está no regime que faz mais sentido para ela? Simples Nacional, Lucro Presumido e Lucro Real têm regras diferentes, e a escolha muda o quanto se paga.',
        'Para empresas de {local_uf}, a Cassia Souza faz esse estudo com base no faturamento, nas atividades e nas despesas da empresa, inclusive para quem ainda vai abrir o CNPJ.',
    ],
    [
        'Muitas empresas de {local} continuam no mesmo regime tributário desde a abertura, mesmo depois de crescer ou mudar de atividade.',
        'Um planejamento tributário revisa esse enquadramento e a organização da empresa, sempre dentro da lei, para que ela pague apenas o que é devido e ganhe previsibilidade.',
    ],
    [
        'Com a Reforma Tributária em andamento, o planejamento tributário deixou de ser uma decisão tomada uma vez só. As regras mudam até 2033, e a empresa precisa acompanhar.',
        'A Cassia Souza ajuda empresários de {local} a entender o efeito dessas mudanças no próprio negócio e a planejar a transição com antecedência.',
    ],
];

$consultoria = [
    [
        'Consultoria tributária é ter alguém acompanhando a parte fiscal da empresa todo mês: revisando movimentações, apontando riscos e respondendo dúvidas antes que virem problema.',
        'A Cassia Souza oferece esse acompanhamento para empresas de {local_uf}, em conjunto com a contabilidade da empresa.',
    ],
    [
        'Uma dúvida tributária não espera o fim do ano. Empresas de {local} tomam decisões todos os dias que mudam o tributo a pagar: um novo produto, um novo contrato, uma nova filial.',
        'Na consultoria tributária, essas decisões passam por uma análise jurídica antes de serem tomadas, o que reduz o risco de autuação e mostra oportunidades previstas em lei.',
    ],
    [
        'Para empresas de {local} que já têm contabilidade estruturada, a consultoria tributária soma uma visão jurídica sobre os tributos: o que a lei permite, o que ela exige e o que está mudando.',
        'O trabalho é contínuo e personalizado, com reuniões periódicas e contato direto com a advogada.',
    ],
];

$defesa = [
    [
        'Diante de uma cobrança do Fisco ou de débitos inscritos em Dívida Ativa, o primeiro passo é entender exatamente o que está sendo cobrado e quais caminhos a lei oferece.',
        'A Cassia Souza atende empresas de {local_uf} na análise desses débitos e na negociação com a Procuradoria-Geral da Fazenda Nacional (PGFN).',
    ],
    [
        'Débitos com a União podem ser regularizados por caminhos previstos em lei, com descontos e parcelamentos, o que evita execução fiscal, bloqueio de contas e penhora de bens.',
        'Para empresas de {local}, o escritório analisa a dívida, verifica as modalidades de negociação disponíveis e, quando cabe, pede a revisão da capacidade de pagamento (CAPAG).',
    ],
    [
        'Uma pendência fiscal não precisa travar a empresa. Com a análise certa, é possível entender o tamanho real do débito e negociar condições compatíveis com o caixa.',
        'A Cassia Souza atende empresas de {local} nessa regularização, com explicações claras sobre cada etapa.',
    ],
];

// Modelo de um termo: os sinônimos reaproveitam o texto do principal e apontam
// para ele (canonical), para o Google não ver páginas duplicadas.
$termo = fn (string $nome, string $h1, string $servico, array $introducoes, string $subtitulo, string $descricao, bool $indexar = false, ?string $canonical = null) => [
    'nome' => $nome,
    'servico' => $servico,
    'h1' => $h1,
    'titulo_seo' => $nome.' em {local_uf} | Cassia Souza Advocacia Tributária',
    'descricao_seo' => $descricao,
    'subtitulo' => $subtitulo,
    'introducoes' => $introducoes,
    'indexar' => $indexar,
    'canonical' => $canonical,
];

$subAdvocacia = 'Planejamento tributário, recuperação de créditos e regularização de débitos para empresas de {local}, com {atendimento}.';
$descAdvocacia = 'Advocacia tributária para empresas de {local_uf}: planejamento tributário, recuperação de PIS/COFINS, regularização de débitos na PGFN e Reforma Tributária.';
$subTributarista = 'A Cassia Souza é advogada tributarista (OAB/SP) e atende empresas de {local}, com {atendimento}.';
$descTributarista = 'Advogada tributarista para empresas de {local_uf}: regime tributário, créditos de PIS/COFINS, débitos com a União e Reforma Tributária.';

return [
    'termos' => [
        'advocacia-tributaria' => $termo('Advocacia tributária', 'Advocacia tributária em {local_uf}', 'consultoria-tributaria', $advocacia, $subAdvocacia, $descAdvocacia, true),
        'cassia-souza-advocacia' => $termo('Cassia Souza Advocacia Tributária', 'Cassia Souza Advocacia Tributária em {local_uf}', 'consultoria-tributaria', $advocacia, $subAdvocacia, $descAdvocacia, false, 'advocacia-tributaria'),
        'direito-tributario-advocacia' => $termo('Direito tributário', 'Direito tributário para empresas de {local_uf}', 'consultoria-tributaria', $advocacia, $subAdvocacia, $descAdvocacia, false, 'advocacia-tributaria'),
        'advocacia-tributaria-empresarial' => $termo('Advocacia tributária empresarial', 'Advocacia tributária empresarial em {local_uf}', 'consultoria-tributaria', $advocacia, $subAdvocacia, $descAdvocacia, false, 'advocacia-tributaria'),
        'advocacia-empresarial-e-tributaria' => $termo('Advocacia empresarial e tributária', 'Advocacia tributária para empresas de {local_uf}', 'consultoria-tributaria', $advocacia, $subAdvocacia, $descAdvocacia, false, 'advocacia-tributaria'),

        'advogada-tributarista' => $termo('Advogada tributarista', 'Advogada tributarista em {local_uf}', 'consultoria-tributaria', $tributarista, $subTributarista, $descTributarista, true),
        'tributarista' => $termo('Tributarista', 'Tributarista para empresas de {local_uf}', 'consultoria-tributaria', $tributarista, $subTributarista, $descTributarista, false, 'advogada-tributarista'),
        'advogados-tributarios' => $termo('Advogados tributários', 'Advocacia tributária para empresas de {local_uf}', 'consultoria-tributaria', $tributarista, $subTributarista, $descTributarista, false, 'advogada-tributarista'),
        'advogado-area-tributaria' => $termo('Advogado na área tributária', 'Advogada na área tributária em {local_uf}', 'consultoria-tributaria', $tributarista, $subTributarista, $descTributarista, false, 'advogada-tributarista'),
        'direito-tributario-advogado' => $termo('Advogado de direito tributário', 'Advogada de direito tributário em {local_uf}', 'consultoria-tributaria', $tributarista, $subTributarista, $descTributarista, false, 'advogada-tributarista'),

        'escritorio-advocacia-tributaria' => $termo('Escritório de advocacia tributária', 'Escritório de advocacia tributária para empresas de {local_uf}', 'consultoria-tributaria', $escritorio, $subAdvocacia, $descAdvocacia, true),
        'escritorio-de-advocacia-tributaria' => $termo('Escritório de advocacia tributária', 'Escritório de advocacia tributária para empresas de {local_uf}', 'consultoria-tributaria', $escritorio, $subAdvocacia, $descAdvocacia, false, 'escritorio-advocacia-tributaria'),

        'advogado-planejamento-tributario' => $termo('Planejamento tributário', 'Planejamento tributário para empresas de {local_uf}', 'planejamento-tributario', $planejamento,
            'Escolha do regime tributário e reorganização da empresa dentro da lei, para empresas de {local}, com {atendimento}.',
            'Planejamento tributário para empresas de {local_uf}: escolha do regime (Simples, Presumido ou Real), novos CNPJs e transição para a Reforma Tributária.', true),
        'planejamento-tributario-advogado' => $termo('Planejamento tributário', 'Planejamento tributário para empresas de {local_uf}', 'planejamento-tributario', $planejamento,
            'Escolha do regime tributário e reorganização da empresa dentro da lei, para empresas de {local}, com {atendimento}.',
            'Planejamento tributário para empresas de {local_uf}: escolha do regime (Simples, Presumido ou Real), novos CNPJs e transição para a Reforma Tributária.', false, 'advogado-planejamento-tributario'),

        'advogado-consultoria-tributaria' => $termo('Consultoria tributária', 'Consultoria tributária para empresas de {local_uf}', 'consultoria-tributaria', $consultoria,
            'Acompanhamento tributário mês a mês para empresas de {local}, junto com a sua contabilidade.',
            'Consultoria tributária mensal para empresas de {local_uf}: revisão de movimentações fiscais, prevenção de autuações e oportunidades previstas em lei.', true),

        // Sem página de serviço própria no site: o texto se apoia na regularização de débitos
        'defesa-fiscal' => $termo('Defesa fiscal', 'Débitos e cobranças fiscais de empresas de {local_uf}', 'regularizacao-debitos-pgfn', $defesa,
            'Análise de débitos e negociação com a PGFN para empresas de {local}, com {atendimento}.',
            'Empresas de {local_uf} com débitos na Dívida Ativa da União: análise da cobrança, negociação com a PGFN, descontos, parcelamento e revisão da CAPAG.'),
        'advocacia-administrativa-tributaria' => $termo('Advocacia administrativa tributária', 'Regularização de débitos fiscais para empresas de {local_uf}', 'regularizacao-debitos-pgfn', $defesa,
            'Análise de débitos e negociação com a PGFN para empresas de {local}, com {atendimento}.',
            'Empresas de {local_uf} com débitos na Dívida Ativa da União: análise da cobrança, negociação com a PGFN, descontos, parcelamento e revisão da CAPAG.'),
    ],

    'blocos' => [
        // Alto Tietê (localidades com presencial = true)
        'atendimento_presencial' => [
            'titulo' => 'Atendimento em {local} e no Alto Tietê',
            'paragrafos' => [
                'O escritório fica em Suzano, e empresas de {local} e das cidades vizinhas podem ser atendidas presencialmente ou online, como preferirem.',
                'O primeiro contato pode ser pelo WhatsApp, pelo e-mail ou pelo formulário desta página.',
            ],
        ],
        'atendimento_online' => [
            'titulo' => 'Atendimento online para empresas de {local}',
            'paragrafos' => [
                'A Cassia Souza atende empresas de todo o Brasil de forma online, com reuniões por videochamada e contato direto pelo WhatsApp e pelo e-mail, sem precisar ir até o escritório, em Suzano (SP).',
                'O primeiro contato pode ser pelo WhatsApp, pelo e-mail ou pelo formulário desta página.',
            ],
        ],
        // Seções do meio da página quando o termo e a página não têm as suas
        'secoes' => [
            [
                'titulo' => 'O que a Reforma Tributária muda para empresas de {local}',
                'paragrafos' => [
                    'Hoje, conforme a atividade e o regime, uma empresa de {local} recolhe o ICMS {do_estado}, o ISS do município e tributos federais como PIS e COFINS.',
                    'Com a Reforma Tributária, ICMS e ISS serão substituídos aos poucos pelo IBS, e PIS e COFINS pela CBS. A transição começou em 2026 e vai até 2033, e durante esse período as regras antigas e as novas convivem.',
                    'Entender o efeito disso no seu setor ajuda a revisar preços, contratos e o regime tributário com antecedência.',
                ],
            ],
            [
                'titulo' => 'Por onde começar',
                'paragrafos' => [
                    'O primeiro passo é uma conversa sobre a empresa: atividade, faturamento, regime atual e o que está preocupando. A partir disso, a Cassia indica se o caso pede planejamento, recuperação de créditos, regularização de débitos ou acompanhamento mensal.',
                ],
            ],
        ],
    ],
];
