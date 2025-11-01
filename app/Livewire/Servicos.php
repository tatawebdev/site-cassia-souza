<?php

namespace App\Livewire;

use Livewire\Component;

class Servicos extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Serviços',
            'img' => 'banner-servicos.jpg',
            'descricao' => 'Conheça nossos serviços.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
        ];

        return view('livewire.servicos')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
