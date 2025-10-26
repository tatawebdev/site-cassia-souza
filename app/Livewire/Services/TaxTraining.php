<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxTraining extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Treinamento Tributário',
            'img' => 'banner-treinamento-tributario.jpg',
            'descricao' => 'Capacitação de equipes em compliance tributário e melhores práticas.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Treinamento Tributário', 'url' => '/servicos/treinamento-tributario'],
        ];

        return view('livewire.services.tax-training')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
