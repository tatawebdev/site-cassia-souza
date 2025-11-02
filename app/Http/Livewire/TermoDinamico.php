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
    public $autor = 'Cassia Souza Advocacia';

    protected $mapeamento = [
        'advocacia-tributaria' => [
            'tituloBanner' => "Transforme a Gestão Tributária <br>da sua Empresa em @cidade",
            'textoBanner' => "Reduza riscos fiscais e potencialize o crescimento da sua empresa em nossa cidade. Nós simplificamos as complexidades tributárias para você.<br><strong>Entre em contato hoje mesmo e dê o próximo passo rumo ao sucesso!</strong>",
            'servico' => "Advocacia Tributária",
            'titulo' => "Advocacia Tributária em @cidade - @estado",
            'descricao' => "Maximize o Potencial do seu Negócio com a Advocacia Tributária em @cidade - @estado. Reduza riscos fiscais e potencialize o crescimento da sua empresa na nossa cidade.",
            'palavrasChave' => "advocacia tributária, @cidade - @estado, consultoria tributária, planejamento tributário, contencioso tributário",
        ],
        'advogados-tributarios' => [
            'tituloBanner' => "Advogados Tributários Comprometidos com Seu Sucesso",
            'textoBanner' => "Equipe de advogados tributários dedicados a encontrar as melhores soluções para seus desafios fiscais. Conte conosco para proteger seus interesses e alcançar seus objetivos.",
            'servico' => "Advogados Tributários",
            'titulo' => "Advogados Tributários em @cidade - @estado",
            'descricao' => "Equipe de Advogados Tributários em @cidade - @estado, especializados em oferecer soluções jurídicas eficientes e estratégicas para questões fiscais.",
            'palavrasChave' => "advogados tributários, @cidade - @estado, consultoria tributária, defesa fiscal, planejamento tributário estratégico",
        ],
        'advogada-tributarista' => [
            'tituloBanner' => "Consultoria Tributária Especializada com Advogada Tributarista",
            'textoBanner' => "Obtenha orientação jurídica especializada em tributação empresarial e pessoal. Nossa advogada tributarista está pronta para ajudar a otimizar sua carga tributária e garantir conformidade fiscal.",
            'servico' => "Advogada Tributarista",
            'titulo' => "Advogada Tributarista em @cidade - @estado",
            'descricao' => "Especialista em Advocacia Tributária para Empresas em @cidade - @estado. Conte com nossos serviços para resolver questões tributárias complexas.",
            'palavrasChave' => "advogada tributarista, @cidade - @estado, consultoria tributária, planejamento tributário, defesa fiscal",
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
        }
    }

    public function render()
    {
        return view('livewire.termo-dinamico');
    }
}
