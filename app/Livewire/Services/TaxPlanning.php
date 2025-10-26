<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxPlanning extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Planejamento Tributário',
            'img' => 'banner-planejamento-tributario.jpg',
            'descricao' => 'Estratégias tributárias sob medida para reduzir a carga fiscal, garantir previsibilidade e apoiar o crescimento seguro da empresa.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Planejamento Tributário', 'url' => '/servicos/planejamento-tributario'],
        ];

        return view('livewire.services.tax-planning')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
