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
            'descricao' => 'Treinamentos práticos para equipes fiscais: reduzir riscos, evitar autuações e otimizar rotinas — presencial ou online.',
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
