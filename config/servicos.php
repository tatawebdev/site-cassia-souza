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
 * - titulo_seo: título da aba e do resultado no Google (o H1 continua o "title")
 * - secoes: perguntas respondidas na página, com a resposta direta primeiro
 *   (pergunta, resposta, e opcionalmente paragrafos, lista e tabela [[rótulo, texto]])
 * - fontes: base legal citada nas seções (nome, url), sempre de fonte oficial
 * - atualizado: mês em que as seções foram conferidas com a legislação (AAAA-MM)
 *
 * Textos jurídicos das seções: conferidos na legislação em outubro de 2026.
 * Nada de promessa de resultado, números de clientes ou casos.
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
        'titulo_seo' => 'Planejamento tributário para empresas | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'O que é planejamento tributário?',
                'resposta' => 'É a análise das operações da empresa para escolher, dentro do que a lei permite, a forma de tributação com menor custo e menor risco. O ponto de partida é comparar o Simples Nacional, o Lucro Presumido e o Lucro Real com os números reais do negócio.',
                'paragrafos' => [
                    'O planejamento também olha para a forma de organizar as atividades e as receitas. Não se trata de deixar de pagar o que é devido: o objetivo é não pagar além disso, com cada escolha apoiada na lei.',
                ],
            ],
            [
                'pergunta' => 'Quando revisar o regime tributário?',
                'resposta' => 'O melhor momento é antes do início do ano, porque a escolha do regime vale para o ano inteiro. No Lucro Presumido, ela é feita com o pagamento do imposto do primeiro período de apuração; no Simples Nacional, a empresa que já está em atividade faz a opção em janeiro.',
                'lista' => [
                    'Abertura de um novo CNPJ',
                    'Crescimento ou queda relevante do faturamento',
                    'Mudança de atividade ou início de uma nova linha de negócio',
                    'Aumento da folha de pagamento',
                    'Mudanças da Reforma Tributária, que ganham força a partir de 2027',
                ],
            ],
            [
                'pergunta' => 'Advogado tributarista ou contador: quem faz o planejamento?',
                'resposta' => 'Os dois trabalham juntos. O contador cuida da escrituração e das obrigações do dia a dia; o advogado tributarista analisa a base legal de cada alternativa, os riscos de autuação e, quando necessário, defende a empresa perante o Fisco.',
            ],
        ],
        'fontes' => [
            ['nome' => 'Lei 9.430/1996, art. 26 (opção pelo Lucro Presumido)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/l9430.htm'],
            ['nome' => 'Lei Complementar 123/2006, art. 16 (opção pelo Simples Nacional)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/lcp/lcp123.htm'],
        ],
        'atualizado' => '2026-10',
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
        'titulo_seo' => 'Recuperação de PIS/COFINS monofásico no Simples | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'O que são produtos monofásicos?',
                'resposta' => 'São produtos em que o PIS e a COFINS são cobrados de uma vez só, no fabricante ou no importador. Quem revende esses produtos depois não deve pagar essas contribuições de novo.',
                'paragrafos' => [
                    'Estão nesse regime, por exemplo, medicamentos e produtos de perfumaria e higiene pessoal (Lei 10.147/2000), autopeças e pneus (Lei 10.485/2002) e bebidas frias, como cervejas e refrigerantes (Lei 13.097/2015). O que define se um item é monofásico é a classificação fiscal do produto, a NCM informada na nota.',
                ],
            ],
            [
                'pergunta' => 'Por que empresas do Simples Nacional pagam a mais?',
                'resposta' => 'O DAS reúne vários tributos, entre eles o PIS e a COFINS. A Lei Complementar 123/2006 manda separar, na apuração mensal, a receita da revenda de produtos com tributação monofásica, para que essas contribuições não sejam cobradas outra vez.',
                'paragrafos' => [
                    'Quando essa separação não é feita no PGDAS-D, a declaração mensal do Simples, a empresa recolhe PIS e COFINS sobre itens que já foram tributados no fabricante. Esse valor pago a mais pode ser recuperado.',
                ],
            ],
            [
                'pergunta' => 'Como funciona a recuperação?',
                'resposta' => 'O trabalho parte das notas fiscais de venda e chega ao pedido formal à Receita Federal, em etapas:',
                'lista' => [
                    'Levantamento das notas fiscais de venda do período',
                    'Identificação dos produtos monofásicos pela NCM',
                    'Cálculo do valor pago a mais, mês a mês',
                    'Retificação das declarações do Simples Nacional',
                    'Pedido de restituição ou compensação à Receita Federal',
                ],
            ],
            [
                'pergunta' => 'Qual é o prazo para pedir de volta?',
                'resposta' => 'O pedido alcança os valores pagos nos últimos 5 anos, contados da data de cada pagamento, como prevê o Código Tributário Nacional. Os pagamentos mais antigos que isso já não podem ser recuperados.',
            ],
        ],
        'fontes' => [
            ['nome' => 'Lei Complementar 123/2006, art. 18 (segregação das receitas no Simples Nacional)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/lcp/lcp123.htm'],
            ['nome' => 'Lei 10.147/2000 (medicamentos, perfumaria e higiene pessoal)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/l10147.htm'],
            ['nome' => 'Lei 10.485/2002 (autopeças e pneus)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/2002/l10485.htm'],
            ['nome' => 'Lei 13.097/2015 (bebidas frias)', 'url' => 'https://www.planalto.gov.br/ccivil_03/_ato2015-2018/2015/lei/l13097.htm'],
            ['nome' => 'Código Tributário Nacional, art. 168 (prazo de 5 anos)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/l5172compilado.htm'],
        ],
        'atualizado' => '2026-10',
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
        'titulo_seo' => 'Dívida Ativa da União: transação com a PGFN | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'O que é a transação tributária?',
                'resposta' => 'É um acordo com a Procuradoria-Geral da Fazenda Nacional (PGFN) para pagar débitos inscritos em Dívida Ativa da União com desconto em juros, multas e encargos e com prazo maior. Ela é regulada pela Lei 13.988/2020.',
            ],
            [
                'pergunta' => 'Quais são os limites de desconto e de prazo?',
                'resposta' => 'A lei não permite reduzir o valor principal da dívida, só os acréscimos. O desconto pode chegar a 65% do valor total, com até 120 meses para pagar. Para microempresas, empresas de pequeno porte e pessoas físicas, os limites sobem para 70% e 145 meses.',
                'paragrafos' => [
                    'As contribuições previdenciárias seguem o limite de parcelamento previsto na Constituição. As condições concretas dependem do edital aberto no momento e da capacidade de pagamento da empresa.',
                ],
            ],
            [
                'pergunta' => 'O que é a CAPAG e por que ela importa?',
                'resposta' => 'A CAPAG é a classificação da capacidade de pagamento que a PGFN atribui a cada contribuinte, e ela influencia o desconto e o prazo oferecidos na transação. Quando a classificação não reflete a situação real da empresa, é possível pedir a revisão pelo portal Regularize, com documentos que a comprovem.',
            ],
            [
                'pergunta' => 'Como funciona na prática?',
                'resposta' => 'A negociação segue um caminho previsível:',
                'lista' => [
                    'Levantamento das inscrições em Dívida Ativa no portal Regularize',
                    'Análise das modalidades e dos editais abertos',
                    'Pedido de revisão da CAPAG, quando cabível',
                    'Simulação do acordo e adesão',
                    'Acompanhamento das parcelas para manter a regularidade',
                ],
            ],
        ],
        'fontes' => [
            ['nome' => 'Lei 13.988/2020, art. 11 (limites de desconto e prazo)', 'url' => 'https://www.planalto.gov.br/ccivil_03/_ato2019-2022/2020/lei/l13988.htm'],
            ['nome' => 'gov.br: pedir revisão da capacidade de pagamento', 'url' => 'https://www.gov.br/pt-br/servicos/pedir-revisao-de-capacidade-pagamento'],
            ['nome' => 'Portal Regularize (PGFN)', 'url' => 'https://www.regularize.pgfn.gov.br/'],
        ],
        'atualizado' => '2026-10',
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
        'titulo_seo' => 'Reforma Tributária para empresas: assessoria | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'Quando a Reforma Tributária entra em vigor?',
                'resposta' => 'A transição começou em 2026 e vai até 2033. Nesse período, os tributos atuais e os novos convivem, com as alíquotas mudando ano a ano. O calendário está na Emenda Constitucional 132/2023:',
                'tabela' => [
                    ['2026', 'Ano de teste: CBS cobrada a 0,9% e IBS a 0,1%, com os valores compensados com o PIS e a COFINS.'],
                    ['2027', 'A CBS passa a valer de fato e o PIS e a COFINS são extintos. O IPI tem alíquota zerada, exceto para produtos com industrialização incentivada na Zona Franca de Manaus, e começa o Imposto Seletivo.'],
                    ['2027 e 2028', 'O IBS segue em fase inicial, com alíquota de 0,1% (metade estadual, metade municipal).'],
                    ['2029 a 2032', 'ICMS e ISS diminuem aos poucos: 90% das alíquotas atuais em 2029, 80% em 2030, 70% em 2031 e 60% em 2032.'],
                    ['2033', 'ICMS e ISS são extintos, e o novo modelo passa a valer por completo.'],
                ],
            ],
            [
                'pergunta' => 'Empresa do Simples Nacional é afetada pela Reforma?',
                'resposta' => 'Sim. O Simples Nacional continua, mas a Constituição passou a permitir que a empresa do Simples recolha o IBS e a CBS fora do DAS, pelo regime regular. A escolha muda o crédito que os clientes dela podem aproveitar.',
                'paragrafos' => [
                    'Quem recolhe pelo DAS não aproveita créditos de IBS e CBS, e o cliente que compra dela só aproveita crédito no valor recolhido pelo DAS. Por isso, a melhor opção depende de quem são os clientes: outras empresas que usam créditos ou o consumidor final.',
                ],
            ],
        ],
        'fontes' => [
            ['nome' => 'Emenda Constitucional 132/2023 (art. 146, §§ 2º e 3º, da Constituição e arts. 125 a 129 do ADCT)', 'url' => 'https://www.planalto.gov.br/ccivil_03/constituicao/emendas/emc/emc132.htm'],
        ],
        'atualizado' => '2026-10',
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
            'Para as clínicas médicas e odontológicas existe a possibilidade de reduzir a carga tributária, dentro do que a lei permite, por meio de enquadramentos específicos, como a equiparação hospitalar no Lucro Presumido.',
        ],
        'destaque' => 'Soluções tributárias para o setor da saúde com foco em resultados.',
        'como_titulo' => 'Planejamento feito para a realidade da saúde',
        'como' => [
            'Nosso papel é estruturar um planejamento tributário personalizado, que garanta economia real, segurança jurídica e previsibilidade financeira, sempre com ética e dentro da legalidade.',
        ],
        'lista' => [],
        'fechamento' => 'Se a sua clínica busca pagar apenas o justo e aumentar a rentabilidade sem riscos, fale conosco.',
        'faq' => ['clinicas', 'regime'],
        'titulo_seo' => 'Planejamento tributário para clínicas | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'O que é a equiparação hospitalar?',
                'resposta' => 'É a regra que permite à clínica que presta serviços hospitalares ou de auxílio diagnóstico e terapia apurar o IRPJ e a CSLL no Lucro Presumido com os percentuais menores dos hospitais: 8% para o IRPJ e 12% para a CSLL, no lugar de 32% para os dois.',
                'paragrafos' => [
                    'A Lei 9.249/1995 lista os serviços que podem ter esse tratamento: hospitalares, de auxílio diagnóstico e terapia, patologia clínica, imagenologia, anatomia patológica e citopatologia, medicina nuclear e análises e patologias clínicas.',
                    'A lei também exige que a clínica seja organizada como sociedade empresária e atenda às normas da Anvisa. O percentual menor vale para a receita desses serviços, por isso é preciso separar o que a clínica fatura com cada tipo de atendimento.',
                ],
            ],
            [
                'pergunta' => 'O que mudou para as clínicas em 2026?',
                'resposta' => 'A Lei Complementar 224/2025 acrescentou 10% aos percentuais de presunção do Lucro Presumido, mas só sobre a parte da receita bruta que passar de R$ 5 milhões no ano. Clínicas que faturam até esse valor não são atingidas por essa regra.',
                'paragrafos' => [
                    'Para as que passam de R$ 5 milhões, o acréscimo vale também para os percentuais da equiparação hospitalar, e a comparação entre os regimes precisa ser refeita com os números atuais.',
                ],
            ],
            [
                'pergunta' => 'Clínica no Simples Nacional ou no Lucro Presumido?',
                'resposta' => 'Depende do faturamento, da folha de pagamento e dos serviços prestados. No Simples, atividades como medicina e odontologia ficam no Anexo III quando a folha de salários chega a 28% da receita bruta (o chamado Fator R) e no Anexo V quando fica abaixo disso.',
                'paragrafos' => [
                    'A comparação só é segura com os números da própria clínica, simulando o custo de cada regime para o ano.',
                ],
            ],
        ],
        'fontes' => [
            ['nome' => 'Lei 9.249/1995, arts. 15 e 20 (percentuais de presunção do IRPJ e da CSLL)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/l9249.htm'],
            ['nome' => 'Lei Complementar 224/2025, art. 4º, §§ 4º e 5º (acréscimo acima de R$ 5 milhões)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/lcp/lcp224.htm'],
            ['nome' => 'Lei Complementar 123/2006, art. 18, §§ 5º-I e 5º-J (Fator R)', 'url' => 'https://www.planalto.gov.br/ccivil_03/leis/lcp/lcp123.htm'],
        ],
        'atualizado' => '2026-10',
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
        'titulo_seo' => 'Consultoria tributária mensal para empresas | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'O que entra no acompanhamento mensal?',
                'resposta' => 'A consultoria revisa, todo mês, como a empresa está apurando e pagando os tributos, para corrigir falhas antes que virem autuação.',
                'lista' => [
                    'Revisão das movimentações fiscais do mês',
                    'Identificação de riscos e correção de falhas',
                    'Ajuste das práticas às normas novas, inclusive às da Reforma Tributária',
                    'Indicação de oportunidades de economia previstas em lei',
                ],
            ],
            [
                'pergunta' => 'Qual a diferença entre consultoria tributária e contabilidade?',
                'resposta' => 'A contabilidade registra as operações e entrega as obrigações da empresa. A consultoria tributária, feita por um advogado tributarista, olha para o enquadramento legal dessas operações: se o tributo está sendo pago do jeito certo, se há risco de autuação e se existe uma alternativa prevista em lei com custo menor.',
                'paragrafos' => [
                    'As duas funcionam melhor juntas, com o contador e a advogada falando a mesma língua sobre a rotina da empresa.',
                ],
            ],
        ],
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
        'faq' => ['treinamento'],
        'titulo_seo' => 'Treinamento tributário para equipes | Cassia Souza',
        'secoes' => [
            [
                'pergunta' => 'Para quem é o treinamento tributário?',
                'resposta' => 'Para as equipes que lidam com tributos no dia a dia, como o departamento fiscal e o financeiro. O conteúdo parte da rotina da empresa, com exemplos e exercícios dos casos que a equipe enfrenta.',
                'paragrafos' => [
                    'As turmas podem ser presenciais ou online, em programas adaptados à empresa.',
                ],
            ],
        ],
    ],
];
