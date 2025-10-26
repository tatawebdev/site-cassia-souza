<?php

namespace App\Livewire;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Sobre Nós',
            'img' => 'banner-sobre-nos.jpg',
            'descricao' => 'Conheça mais sobre nosso escritório e nossa missão.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Sobre', 'url' => '/sobre-nos'],
        ];

        return view('livewire.about')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
