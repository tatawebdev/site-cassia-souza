<?php

namespace App\Livewire\Services;

use Livewire\Component;

class CreditRecovery extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Recuperação de Crédito',
            'img' => 'banner-recuperacao-credito.jpg',
            'descricao' => 'Atuamos na recuperação de créditos e direitos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Recuperação de Crédito', 'url' => '/servicos/recuperacao-de-credito'],
        ];

        return view('livewire.services.credit-recovery')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
