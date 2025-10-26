<?php

namespace App\Livewire;

use Livewire\Component;

class Services extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Serviços',
            'descricao' => 'Conheça nossos serviços.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
        ];

        return view('livewire.services')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
