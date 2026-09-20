# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

Empresas de pequeno, médio e grande porte que precisam de assessoria tributária: desde negócios optantes pelo Simples Nacional buscando recuperação de créditos (PIS/COFINS monofásico) e regularização de débitos, até empresas maiores com contabilidade estruturada que precisam de consultoria e planejamento tributário contínuo. Um segmento específico já atendido é o de clínicas e profissionais da saúde (planejamento tributário para clínicas).

## Product Purpose

Site institucional do escritório Cássia Souza Advocacia Tributária. O objetivo principal é gerar contato/lead: o visitante identifica o problema tributário que tem (regime tributário inadequado, crédito de PIS/COFINS a recuperar, débito com a PGFN, impacto da Reforma Tributária, etc.), entende que o escritório resolve esse tipo de caso, e entra em contato via formulário, WhatsApp ou e-mail.

## Positioning

Assessoria tributária especializada e personalizada — atuação vai da consultoria mensal recorrente a frentes técnicas específicas (recuperação de crédito, regularização de dívida ativa, compliance, treinamento tributário), com atenção a nichos como clínicas. Nenhum diferencial numérico (anos de experiência, quantidade de clientes, prêmios) está confirmado ainda — não deve ser inventado.

## Operating Context

- Site em Laravel + Livewire, com páginas de serviço individuais roteadas (`servicos.*`) para cada frente: consultoria tributária, planejamento tributário, planejamento tributário para clínicas, recuperação de crédito, recuperação PIS/COFINS, regularização de débitos PGFN, compliance tributário, assessoria de reforma tributária, treinamento tributário.
- Página inicial traz FAQ rotativo (amostra de perguntas sobre regime tributário, Reforma Tributária, PIS/COFINS monofásico, negociação de dívida ativa) e lista de serviços com ícones.
- Canais de contato existentes no código: formulário de contato (`contact-form`), link direto para WhatsApp (componente `link-whatsapp`), e-mail (`cassia_souza@adv.oabsp.org.br`), newsletter (assinatura e confirmação por e-mail), blog externo (`blog.cassiasouzaadvocacia.com.br`).
- Também há páginas de política de privacidade e termo dinâmico (indicando preocupação com conformidade/LGPD).

## Capabilities and Constraints

- Stack: Laravel + Livewire (Blade views), sem SPA framework.
- Conteúdo é institucional/jurídico: precisão técnica na linguagem tributária importa; evitar simplificações que distorçam o sentido legal.
- Formulário de contato, assinatura de newsletter e link de WhatsApp são os mecanismos de conversão — qualquer trabalho de design/UX deve preservar e destacar esses caminhos.

## Brand Commitments

Nome: Cássia Souza Advocacia (Tributária). E-mail institucional `cassia_souza@adv.oabsp.org.br` (indica advogada inscrita na OAB/SP). Blog próprio em domínio separado (`cassiasouzaadvocacia.com.br`). Nenhuma paleta, tipografia ou diretriz visual foi definida como vínculo obrigatório neste momento — decisões visuais ficam para os comandos de design (`new-work`, `polish`, etc.), não para este documento.

## Evidence on Hand

Nenhum depoimento, case, número de clientes atendidos, prêmio ou estatística de resultado está confirmado. Não fabricar esse tipo de prova em trabalhos futuros — tratar como lacuna aberta até o usuário fornecer.

## Product Principles

- Cada página de serviço deve deixar claro qual problema tributário específico ela resolve, para o visitante se reconhecer rapidamente.
- O caminho até o contato (formulário, WhatsApp, e-mail) deve estar sempre visível e de fácil acesso, já que gerar lead é o objetivo central do site.
- Linguagem precisa juridicamente, mas acessível a quem não é advogado — o público é majoritariamente empresário, não profissional do direito.
- Não inventar prova social, números ou credenciais além do que está confirmado.

## Accessibility & Inclusion

Nenhum requisito específico de acessibilidade foi estabelecido além dos padrões gerais de boas práticas web.
