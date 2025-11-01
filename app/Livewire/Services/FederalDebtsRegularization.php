<?php

namespace App\Livewire\Services;

use Livewire\Component;

class FederalDebtsRegularization extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Regularização de Débitos (PGFN)',
            'img' => 'banner-regularizacao-pgfn.jpg',
            'descricao' => 'Negociação e parcelamento de débitos inscritos na Dívida Ativa (PGFN), com foco em recuperação financeira e redução de encargos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Regularização de Débitos (PGFN)', 'url' => '/servicos/regularizacao-debitos-pgfn'],
        ];

        return view('livewire.services.federal-debts-regularization')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
