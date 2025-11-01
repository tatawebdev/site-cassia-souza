<?php

namespace App\Livewire\Servicos;

use Livewire\Component;

class PlanejamentoClinicas extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Planejamento para Clínicas',
            'img' => 'banner-planejamento-clinicas.jpg',
            'descricao' => 'Planejamento tributário especializado para clínicas médicas e odontológicas, buscando economia legal, previsibilidade e maior rentabilidade.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Planejamento para Clínicas', 'url' => '/servicos/planejamento-tributario-clinicas'],
        ];

        $imagem1Default = '/assets/images/planejamento-tributario-clinicas/imagem1.jpg';
        $imagem2Default = '/assets/images/planejamento-tributario-clinicas/imagem2.jpg';

        $imagem1 = file_exists(public_path("{$imagem1Default}")) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path("{$imagem2Default}")) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view(
            'livewire.servicos.planejamento-tributario-clinicas',
            [
                'imagem1' => $imagem1,
                'imagem2' => $imagem2
            ]
        )
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
