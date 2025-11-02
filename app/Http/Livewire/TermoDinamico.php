<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TermoDinamico extends Component
{
    public $termo;
    public $cidade;
    public $estado;

    public $titulo;
    public $tituloBanner;
    public $textoBanner;
    public $servico;
    public $descricao;
    public $palavrasChave;
    public $html;
    public $autor = 'Cassia Souza Advocacia';
    /**
     * Texto HTML padrão usado para a chave 'html' em todos os mapeamentos.
     * Pode conter tokens @cidade e @estado que serão substituídos em runtime.
     */
    protected $defaultHtml = "Cassia Souza Advocacia Tributária em @cidade - @estado\nEstratégia, clareza e segurança para empresas que querem crescer do jeito certo.\nA Cassia Souza Advocacia é um escritório especializado em Direito Tributário, focado em oferecer soluções estratégicas para empresas que desejam pagar apenas o justo em tributos, recuperar valores pagos indevidamente e garantir segurança jurídica para crescer com tranquilidade.\n\nAtuamos de forma consultiva e preventiva, identificando oportunidades legais de economia, regularizando pendências e preparando sua empresa para mudanças como a Reforma Tributária. Trabalhamos com linguagem simples, transparência e foco no resultado: economia, previsibilidade e proteção patrimonial.";
    protected $mapeamento = [
        'advocacia-tributaria' => [
            'tituloBanner' => "Transforme a Gestão Tributária <br>da sua Empresa em @cidade",
            'textoBanner' => "Reduza riscos fiscais e potencialize o crescimento da sua empresa em nossa cidade. Nós simplificamos as complexidades tributárias para você.<br><strong>Entre em contato hoje mesmo e dê o próximo passo rumo ao sucesso!</strong>",
            'servico' => "Advocacia Tributária",
            'titulo' => "Advocacia Tributária em @cidade - @estado",
            'descricao' => "Maximize o Potencial do seu Negócio com a Advocacia Tributária em @cidade - @estado. Reduza riscos fiscais e potencialize o crescimento da sua empresa na nossa cidade.",
            'palavrasChave' => "advocacia tributária, @cidade - @estado, consultoria tributária, planejamento tributário, contencioso tributário",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advocacia Tributária\nTransforme a gestão tributária da sua empresa em @cidade - @estado com soluções estratégicas e personalizadas. Reduza riscos fiscais, potencialize o crescimento e garanta segurança jurídica para o seu negócio.\n\nNossa equipe é especializada em identificar oportunidades legais de economia, regularizar pendências fiscais e preparar sua empresa para mudanças legislativas, como a Reforma Tributária. Trabalhamos com transparência, linguagem acessível e foco em resultados: economia, previsibilidade e proteção patrimonial.",

        ],
        'cassia-souza-advocacia' => [
            'tituloBanner' => "Cassia Souza Advocacia: Experiência e Comprometimento em @cidade",
            'textoBanner' => "Especialistas em direito tributário em @cidade - @estado, oferecemos soluções jurídicas personalizadas para empresas e indivíduos. Entre em contato e descubra como podemos ajudar você a resolver questões fiscais complexas.",
            'servico' => "Cassia Souza Advocacia",
            'titulo' => "Cassia Souza Advocacia em @cidade - @estado",
            'descricao' => "Serviços especializados em Advocacia Tributária em @cidade - @estado. Conte com nossa experiência para resolver questões fiscais e melhorar a gestão tributária da sua empresa.",
            'palavrasChave' => "cassia souza advocacia, @cidade - @estado, advocacia tributária, consultoria fiscal, planejamento tributário",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Cassia Souza Advocacia Tributária em @cidade - @estado\nEstratégia, clareza e segurança para empresas que querem crescer do jeito certo.\nA Cassia Souza Advocacia é um escritório especializado em Direito Tributário, focado em oferecer soluções estratégicas para empresas que desejam pagar apenas o justo em tributos, recuperar valores pagos indevidamente e garantir segurança jurídica para crescer com tranquilidade.\n\nAtuamos de forma consultiva e preventiva, identificando oportunidades legais de economia, regularizando pendências e preparando sua empresa para mudanças como a Reforma Tributária. Trabalhamos com linguagem simples, transparência e foco no resultado: economia, previsibilidade e proteção patrimonial.",
        ],
        'advogada-tributarista' => [
            'tituloBanner' => "Consultoria Tributária Especializada com Advogada Tributarista",
            'textoBanner' => "Obtenha orientação jurídica especializada em tributação empresarial e pessoal. Nossa advogada tributarista está pronta para ajudar a otimizar sua carga tributária e garantir conformidade fiscal.",
            'servico' => "Advogada Tributarista",
            'titulo' => "Advogada Tributarista em @cidade - @estado",
            'descricao' => "Especialista em Advocacia Tributária para Empresas em @cidade - @estado. Conte com nossos serviços para resolver questões tributárias complexas e otimizar sua gestão fiscal.",
            'palavrasChave' => "advogada tributarista, @cidade - @estado, consultoria tributária, planejamento tributário, defesa fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advogada Tributarista\nConsultoria tributária especializada com advogada tributarista em @cidade - @estado. Obtenha orientação jurídica para otimizar sua carga tributária e garantir conformidade fiscal.\n\nNossa advogada tributarista oferece soluções personalizadas para empresas e indivíduos, focando em planejamento tributário estratégico, defesa fiscal e resolução de questões tributárias complexas. Conte com nossa expertise para proteger seus interesses e alcançar seus objetivos financeiros.",
        ],
        'defesa-fiscal' => [
            'tituloBanner' => "Defesa Fiscal: Proteja Seus Interesses com Especialistas",
            'textoBanner' => "Estratégias eficazes de defesa fiscal para enfrentar disputas tributárias. Conte com nossa experiência em defender seus direitos contra autuações e cobranças indevidas.",
            'servico' => "Defesa Fiscal",
            'titulo' => "Defesa Fiscal em @cidade - @estado",
            'descricao' => "Consultoria Especializada em Defesa Fiscal em @cidade - @estado. Conte com nossos serviços para resolver questões tributárias complexas e proteger seus interesses fiscais.",
            'palavrasChave' => "defesa fiscal, @cidade - @estado, consultoria tributária, planejamento tributário, contencioso fiscal",
            'autor' => "Cassia Souza Advocacia",
        ],
        'tributarista' => [
            'tituloBanner' => "Especialistas Tributários ao Seu Serviço em @cidade",
            'textoBanner' => "Profissionais dedicados a resolver questões tributárias complexas. Oferecemos soluções personalizadas para empresas e indivíduos, garantindo conformidade fiscal e eficiência operacional.",
            'servico' => "Tributarista",
            'titulo' => "Tributarista em @cidade - @estado",
            'descricao' => "Consultoria Especializada em Tributaristas em @cidade - @estado. Conte com nossos serviços para resolver questões tributárias complexas e otimizar sua gestão fiscal.",
            'palavrasChave' => "tributarista, @cidade - @estado, consultoria tributária, planejamento tributário, defesa fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Tributarista\nAtendimento especializado em @cidade - @estado para empresas e pessoas físicas. Oferecemos análise tributária, planejamento e defesa em contencioso fiscal.\n\nNosso trabalho foca em reduzir riscos, buscar economia legal e garantir segurança jurídica para suas operações.",
        ],
        'advocacia-administrativa-tributaria' => [
            'tituloBanner' => "Advocacia Administrativa Tributária: Soluções Eficientes",
            'textoBanner' => "Assessoria jurídica especializada em processos administrativos tributários. Nossa equipe está pronta para defender seus interesses e garantir resultados positivos para sua empresa.",
            'servico' => "Advocacia Administrativa Tributária",
            'titulo' => "Advocacia Administrativa Tributária em @cidade - @estado",
            'descricao' => "Oferecemos serviços especializados em Advocacia Administrativa Tributária em @cidade - @estado. Conte com nossa expertise para resolver questões fiscais de forma estratégica e eficiente.",
            'palavrasChave' => "advocacia administrativa tributária, @cidade - @estado, consultoria tributária, defesa fiscal, planejamento tributário",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advocacia Administrativa Tributária\nAtuamos em processos administrativos junto aos órgãos fiscais em @cidade - @estado, oferecendo defesa técnica, impugnações e soluções negociadas.\n\nNosso objetivo é resolver pendências e preservar patrimônio com estratégias administrativas eficientes.",
        ],
        'advocacia-empresarial-e-tributaria' => [
            'tituloBanner' => "Advocacia Empresarial e Tributária Personalizada",
            'textoBanner' => "Soluções jurídicas completas para empresas enfrentarem desafios tributários. Conte com nossa experiência em direito empresarial e tributário para alcançar seus objetivos de negócio.",
            'servico' => "Advocacia Empresarial e Tributária",
            'titulo' => "Advocacia Empresarial e Tributária em @cidade - @estado",
            'descricao' => "Especializados em Advocacia Empresarial e Tributária em @cidade - @estado, oferecemos soluções jurídicas integradas para empresas. Proteja seus interesses e otimize sua performance fiscal conosco.",
            'palavrasChave' => "advocacia empresarial e tributária, @cidade - @estado, consultoria jurídica empresarial, planejamento tributário estratégico",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advocacia Empresarial e Tributária\nAssessoria integrada para empresas em @cidade - @estado, combinando direito societário e tributário para operações seguras e eficientes.\n\nOferecemos planejamento tributário, contratos e compliance para apoiar o crescimento sustentável do seu negócio.",
        ],
        'advocacia-tributaria-empresarial' => [
            'tituloBanner' => "Advocacia Tributária Empresarial: Proteja Seu Patrimônio",
            'textoBanner' => "Consultoria jurídica especializada em tributação empresarial. Proteja seu patrimônio e otimize sua estrutura fiscal com nossa expertise em advocacia tributária empresarial.",
            'servico' => "Advocacia Tributária Empresarial",
            'titulo' => "Advocacia Tributária Empresarial em @cidade - @estado",
            'descricao' => "Nossa Advocacia Tributária Empresarial em @cidade - @estado oferece soluções personalizadas para sua empresa. Reduza custos fiscais e maximize o retorno dos seus investimentos.",
            'palavrasChave' => "advocacia tributária empresarial, @cidade - @estado, consultoria tributária empresarial, planejamento fiscal estratégico",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advocacia Tributária Empresarial\nConsultoria especializada em tributação empresarial em @cidade - @estado. Ajudamos a estruturar operações, reduzir custos fiscais e proteger o patrimônio da empresa.\n\nAtuamos em planejamento tributário, regimes especiais e defesa administrativa e judicial.",
        ],
        'advogado-area-tributaria' => [
            'tituloBanner' => "Consultoria Jurídica na Área Tributária em @cidade",
            'textoBanner' => "Obtenha suporte jurídico especializado em questões tributárias. Nossa equipe está preparada para oferecer orientação estratégica e representação em litígios fiscais.",
            'servico' => "Advogado Área Tributária",
            'titulo' => "Advogado Área Tributária em @cidade - @estado",
            'descricao' => "Consultoria jurídica especializada na Área Tributária em @cidade - @estado. Conte com nossos advogados para resolver questões tributárias complexas de forma eficiente e estratégica.",
            'palavrasChave' => "advogado área tributária, @cidade - @estado, consultoria jurídica, planejamento tributário estratégico, defesa fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advogado Área Tributária\nAtendimento em @cidade - @estado para demandas tributárias empresariais e pessoais, com foco em conformidade e redução de riscos.\n\nPrestamos consultoria, planejamento e defesa em processos fiscais para proteger seus interesses.",
        ],
        'advogado-consultoria-tributaria' => [
            'tituloBanner' => "Consultoria Tributária com Advogado Especializado em @cidade",
            'textoBanner' => "Consultoria tributária personalizada para empresas e indivíduos. Maximizamos oportunidades e minimizamos riscos fiscais com nossa abordagem estratégica em direito tributário.",
            'servico' => "Advogado Consultoria Tributária",
            'titulo' => "Advogado Consultoria Tributária em @cidade - @estado",
            'descricao' => "Especialistas em Consultoria Tributária em @cidade - @estado, oferecemos suporte jurídico personalizado para empresas e indivíduos. Minimize riscos fiscais e otimize sua gestão tributária conosco.",
            'palavrasChave' => "advogado consultoria tributária, @cidade - @estado, planejamento tributário estratégico, contencioso fiscal, defesa tributária",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advogado Consultoria Tributária\nConsultoria personalizada para revisar tributos, orientar regimes e reduzir custos fiscais em @cidade - @estado.\n\nOferecemos diagnósticos, planejamento e acompanhamento para manter sua empresa em conformidade e otimizar sua carga tributária.",
        ],
        'advogado-planejamento-tributario' => [
            'tituloBanner' => "Planejamento Tributário com Advogado Especializado em @cidade",
            'textoBanner' => "Planejamento tributário estratégico para otimizar sua carga fiscal. Nosso advogado está aqui para ajudar você a navegar no complexo sistema tributário brasileiro.",
            'servico' => "Advogado Planejamento Tributário",
            'titulo' => "Advogado Planejamento Tributário em @cidade - @estado",
            'descricao' => "Planejamento Tributário Estratégico em @cidade - @estado com foco em otimização fiscal. Nossos advogados estão prontos para oferecer soluções jurídicas que garantem segurança e economia para seu negócio.",
            'palavrasChave' => "advogado planejamento tributário, @cidade - @estado, consultoria tributária estratégica, planejamento fiscal, otimização tributária",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advogado Planejamento Tributário\nPlanejamento fiscal estratégico em @cidade - @estado para proteger patrimônio e otimizar a carga tributária.\n\nDesenvolvemos soluções sob medida que alinham economia fiscal com segurança jurídica.",
        ],
        'advogados-tributarios' => [
            'tituloBanner' => "Advogados Tributários Comprometidos com Seu Sucesso",
            'textoBanner' => "Equipe de advogados tributários dedicados a encontrar as melhores soluções para seus desafios fiscais. Conte conosco para proteger seus interesses e alcançar seus objetivos.",
            'servico' => "Advogados Tributários",
            'titulo' => "Advogados Tributários em @cidade - @estado",
            'descricao' => "Equipe de Advogados Tributários em @cidade - @estado, especializados em oferecer soluções jurídicas eficientes e estratégicas para questões fiscais. Conte com nossa experiência para proteger seus interesses.",
            'palavrasChave' => "advogados tributários, @cidade - @estado, consultoria tributária, defesa fiscal, planejamento tributário estratégico",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Advogados Tributários\nEquipe de advogados especializados em @cidade - @estado para contencioso e consultoria tributária.\n\nOferecemos atuação estratégica em defesas, recursos e planejamento para garantir segurança jurídica e melhores resultados.",
        ],
        'direito-tributario-advocacia' => [
            'tituloBanner' => "Especialistas em Direito Tributário e Advocacia",
            'textoBanner' => "Soluções jurídicas em direito tributário para empresas e indivíduos. Nossa expertise em advocacia tributária garante suporte eficaz em todas as etapas de sua jornada fiscal.",
            'servico' => "Direito Tributário Advocacia",
            'titulo' => "Direito Tributário Advocacia em @cidade - @estado",
            'descricao' => "Serviços de Advocacia Especializados em Direito Tributário em @cidade - @estado. Nossos advogados estão preparados para oferecer suporte jurídico completo e eficaz para questões fiscais.",
            'palavrasChave' => "direito tributário advocacia, @cidade - @estado, consultoria tributária, contencioso fiscal, planejamento tributário",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Direito Tributário Advocacia\nServiços completos de direito tributário em @cidade - @estado, da consultoria preventiva à atuação contenciosa.\n\nNossa equipe presta suporte técnico e estratégico para resolver questões fiscais com eficiência.",
        ],
        'direito-tributario-advogado' => [
            'tituloBanner' => "Consultoria Jurídica em Direito Tributário",
            'textoBanner' => "Consultoria jurídica especializada em direito tributário. Nossa equipe está pronta para oferecer suporte estratégico e representação em litígios fiscais e questões tributárias.",
            'servico' => "Direito Tributário Advogado",
            'titulo' => "Direito Tributário Advogado em @cidade - @estado",
            'descricao' => "Advogado Especializado em Direito Tributário em @cidade - @estado, oferecendo soluções jurídicas personalizadas para questões fiscais. Conte com nossa expertise para resolver suas demandas tributárias.",
            'palavrasChave' => "direito tributário advogado, @cidade - @estado, consultoria tributária, planejamento tributário estratégico, defesa fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Direito Tributário Advogado\nConsultoria e defesa em matéria tributária para empresas e pessoas físicas em @cidade - @estado.\n\nBuscamos soluções práticas e seguras para reduzir riscos e assegurar direitos fiscais.",
        ],
        'escritorio-advocacia-tributaria' => [
            'tituloBanner' => "Escritório de Advocacia Tributária: Expertise e Comprometimento",
            'textoBanner' => "Serviços jurídicos especializados em advocacia tributária. Nosso escritório oferece soluções personalizadas para empresas e indivíduos enfrentarem desafios fiscais com segurança.",
            'servico' => "Escritório Advocacia Tributária",
            'titulo' => "Escritório Advocacia Tributária em @cidade - @estado",
            'descricao' => "Nosso Escritório de Advocacia Tributária em @cidade - @estado oferece soluções jurídicas integradas e personalizadas para empresas. Proteja seus interesses fiscais com nossa equipe especializada.",
            'palavrasChave' => "escritório advocacia tributária, @cidade - @estado, consultoria tributária, planejamento tributário estratégico, contencioso fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Escritório de Advocacia Tributária\nAtuação em @cidade - @estado com foco em estratégia fiscal, compliance e defesa de interesses empresariais.\n\nPrestamos serviços personalizados para proteger o patrimônio e otimizar a gestão tributária.",
        ],
        'escritorio-de-advocacia-tributaria' => [
            'tituloBanner' => "Escritório de Advocacia Tributária: Compromisso com Resultados",
            'textoBanner' => "Assessoria jurídica especializada em tributação empresarial e pessoal. Oferecemos soluções personalizadas para garantir conformidade fiscal e proteger seus interesses.",
            'servico' => "Escritório de Advocacia Tributária",
            'titulo' => "Escritório de Advocacia Tributária em @cidade - @estado",
            'descricao' => "Especializados em Escritório de Advocacia Tributária em @cidade - @estado, oferecemos suporte jurídico especializado para empresas e indivíduos. Minimize riscos fiscais e otimize sua gestão tributária conosco.",
            'palavrasChave' => "escritório de advocacia tributária, @cidade - @estado, consultoria tributária, planejamento tributário estratégico, contencioso fiscal",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Escritório de Advocacia Tributária\nAssessoria completa em @cidade - @estado, unindo experiência e foco prático para resolver desafios fiscais.\n\nAtuamos em planejamento, contencioso e regularização de débitos com objetivo de máxima eficiência.",
        ],
        'planejamento-tributario-advogado' => [
            'tituloBanner' => "Planejamento Tributário Estratégico com Advogado",
            'textoBanner' => "Planejamento tributário personalizado para otimizar sua carga fiscal. Nossa equipe jurídica está preparada para oferecer as melhores soluções em planejamento tributário.",
            'servico' => "Planejamento Tributário Advogado",
            'titulo' => "Planejamento Tributário Advogado em @cidade - @estado",
            'descricao' => "Serviços de Planejamento Tributário Estratégico em @cidade - @estado com foco na otimização fiscal. Nossos advogados estão preparados para oferecer soluções personalizadas e eficientes para sua empresa.",
            'palavrasChave' => "planejamento tributário advogado, @cidade - @estado, consultoria tributária estratégica, otimização fiscal, planejamento tributário eficaz",
            'autor' => "Cassia Souza Advocacia",
            'html' => "Planejamento Tributário Advogado\nSoluções de planejamento tributário para empresas em @cidade - @estado, visando eficiência fiscal e segurança jurídica.\n\nElaboramos estratégias sob medida que reduzem custos e mitigam riscos fiscais.",
        ],
    ];

    public function mount($termo = null, $cidade = null, $estado = null)
    {
        $this->termo = $termo;
        $this->cidade = $cidade;
        $this->estado = $estado;

        $this->applyMapping();
    }

    protected function applyMapping()
    {
        $key = $this->termo ?: '';

        if (isset($this->mapeamento[$key])) {
            $dados = $this->mapeamento[$key];
            // garantir que todos os mapeamentos tenham o campo 'html' atualizado
            // apenas aplicar o default se não houver html específico na entrada
            if (!isset($dados['html']) || $dados['html'] === '') {
                $dados['html'] = $this->defaultHtml;
            }
            // substituir @cidade e @estado nas strings de template
            $dados = array_map(function ($v) {
                $v = str_replace('@cidade', $this->cidade ?? '', $v);
                $v = str_replace('@estado', $this->estado ?? '', $v);
                return $v;
            }, $dados);

            $this->tituloBanner = $dados['tituloBanner'] ?? null;
            $this->textoBanner = $dados['textoBanner'] ?? null;
            $this->servico = $dados['servico'] ?? null;
            $this->titulo = $dados['titulo'] ?? null;
            $this->descricao = $dados['descricao'] ?? null;
            $this->palavrasChave = $dados['palavrasChave'] ?? null;
            $this->html = $dados['html'] ?? $this->defaultHtml;
        } else {
            // fallback genérico: formatar termo para um título legível
            $human = str_replace(['-'], ' ', $this->termo ?: '');
            $cidade = $this->cidade ? (" em " . ucwords(str_replace('-', ' ', $this->cidade))) : '';
            $estado = $this->estado ? (" - " . strtoupper($this->estado)) : '';

            $this->servico = ucwords($human);
            $this->titulo = (ucwords($human) ?: 'Serviço') . $cidade . $estado;
            $this->descricao = "Serviços de " . ($this->servico ?: 'consultoria') . ($cidade ? " na cidade de " . ucwords(str_replace('-', ' ', $this->cidade)) : '') . ". Entre em contato para mais informações.";
            $this->palavrasChave = ($this->termo ? str_replace('-', ', ', $this->termo) . ', ' : '') . 'advocacia tributária, consultoria tributária';
            $this->tituloBanner = $this->titulo;
            $this->textoBanner = $this->descricao;
            // preparar html default com tokens substituídos
            $this->html = str_replace(['@cidade', '@estado'], [$this->cidade ?? '', $this->estado ?? ''], $this->defaultHtml);
        }
    }

    public function render()
    {
        // Banner dinâmico: usar título/descrição do mapeamento quando disponível
        $bannerTitle = $this->tituloBanner ?? $this->titulo ?? 'Cassia Souza Advocacia';
        // gerar nome de imagem padrão a partir do termo (pode ser ajustado para caminhos reais)
        $bannerImg = $this->termo ? 'banner-' . str_replace(['/', ' '], '-', $this->termo) . '.jpg' : 'banner-sobre-nos.jpg';

        $bannerImgPath = public_path('assets/images/' . $bannerImg);
        if (!file_exists($bannerImgPath)) {
            $bannerImg = 'banner-sobre-nos.jpg';
        }
        $bannerDesc = $this->descricao ?? 'Escritório de Direito Tributário focado em estratégia, segurança jurídica e resultados reais para empresas de todos os portes.';

        $banner = [
            'title' => $bannerTitle,
            'img' => $bannerImg,
            'descricao' => $bannerDesc,
        ];

        // Breadcrumbs dinâmicos: Home > Serviço/Termo > Cidade (se existir)
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
        ];

        if (!empty($this->servico)) {
            $breadcrumbs[] = ['label' => $this->servico, 'url' => '/' . ($this->termo ?? '')];
        } elseif (!empty($this->titulo)) {
            $breadcrumbs[] = ['label' => $this->titulo, 'url' => '/' . ($this->termo ?? '')];
        }

        if (!empty($this->cidade)) {
            $labelCidade = ucwords(str_replace('-', ' ', $this->cidade));
            $urlCidade = '/' . ($this->termo ?? '') . '/' . $this->cidade . (!empty($this->estado) ? ('/' . $this->estado) : '');
            $breadcrumbs[] = ['label' => $labelCidade, 'url' => $urlCidade];
        }

        return view('livewire.termo-dinamico')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}

