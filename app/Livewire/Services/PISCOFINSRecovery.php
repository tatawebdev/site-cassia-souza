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
            'descricao' => 'Analisamos operações, identificamos créditos legítimos e recuperamos valores de PIS/COFINS monofásicos de forma legal, devolvendo recursos importantes ao caixa.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Recuperação PIS/COFINS', 'url' => '/servicos/recuperacao-pis-cofins-monofasicos'],
        ];

        return view('livewire.services.piscofins-recovery')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
