<?php

namespace App\Livewire\Services;

use Livewire\Component;

class PISCOFINSRecovery extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Recuperação de PIS/COFINS (Monofásicos)',
            'img' => 'banner-recuperacao-pis-cofins.jpg',
            'descricao' => 'Análise e recuperação de créditos de PIS/COFINS monofásicos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Recuperação PIS/COFINS', 'url' => '/servicos/recuperacao-pis-cofins-monofasicos'],
        ];

        return view('livewire.services.pis-cofins-recovery')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
