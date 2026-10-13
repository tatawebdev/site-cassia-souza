<?php

/*
 * Serviços do escritório, usados pelo tema novo (menu, home, rodapé).
 * Cada serviço é apresentado pelo problema que o visitante reconhece em si
 * ("problem"), seguido do nome do serviço que o resolve.
 * "image" é a pasta em public/assets/servicos/detalhes.
 */

return [
    [
        'problem' => 'Não sei se estou no regime tributário mais vantajoso',
        'title' => 'Planejamento Tributário',
        'text' => 'Da escolha do regime mais vantajoso, inclusive para novos CNPJs, à reestruturação de empresas em operação, para pagar apenas o devido.',
        'route' => 'servicos.planejamento.tributario',
        'image' => 'planejamento-tributario',
    ],
    [
        'problem' => 'Vendo produtos monofásicos e recolho tudo pelo Simples Nacional',
        'title' => 'Recuperação de PIS/COFINS monofásicos',
        'text' => 'Analisamos operações, identificamos créditos legítimos dos últimos 5 anos e recuperamos os valores de forma legal.',
        'route' => 'servicos.recuperacao.pis.cofins.monofasicos',
        'image' => 'recuperacao-piscofins',
    ],
    [
        'problem' => 'Minha empresa tem débitos inscritos em Dívida Ativa da União',
        'title' => 'Regularização de débitos (PGFN)',
        'text' => 'Negociamos com a PGFN descontos em juros e multas e parcelamentos especiais, inclusive com revisão da CAPAG, para evitar execução fiscal, bloqueio de conta e penhora de bens.',
        'route' => 'servicos.regularizacao.debitos.pgfn',
        'image' => 'regularizacao-debitos-pgfn',
    ],
    [
        'problem' => 'Quero saber o que a Reforma Tributária muda para mim',
        'title' => 'Assessoria para Reforma Tributária',
        'text' => 'Analisamos os efeitos da Reforma na sua carga tributária e no fluxo de caixa e planejamos a transição para o novo modelo, com riscos e oportunidades mapeados.',
        'route' => 'servicos.assessoria.reforma.tributaria',
        'image' => 'assessoria-reforma-tributaria',
    ],
    [
        'problem' => 'Tenho uma clínica médica ou odontológica',
        'title' => 'Planejamento Tributário para Clínicas',
        'text' => 'Clínicas médicas e odontológicas podem reduzir a carga tributária com enquadramentos previstos em lei, como a equiparação hospitalar no Lucro Presumido.',
        'route' => 'servicos.planejamento.tributario.clinicas',
        'image' => 'planejamento-clinicas',
    ],
    [
        'problem' => 'Preciso de acompanhamento tributário todo mês',
        'title' => 'Consultoria Tributária',
        'text' => 'Revisamos suas movimentações fiscais mês a mês, corrigimos falhas antes que virem autuações e apontamos oportunidades de economia.',
        'route' => 'servicos.consultoria.tributaria',
        'image' => 'consultoria-tributaria',
    ],
    [
        'problem' => 'Minha equipe precisa dominar a rotina tributária',
        'title' => 'Treinamento Tributário para Empresas',
        'text' => 'Turmas presenciais ou online, com exemplos e exercícios da realidade do seu departamento fiscal e financeiro, para evitar erros que geram autuações.',
        'route' => 'servicos.treinamento.tributario',
        'image' => 'treinamento-tributario',
    ],
];
