<?php

namespace App\Livewire;

use Livewire\Component;

class About extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Sobre a Cassia Souza Advogacia',
            'img' => 'banner-sobre-nos.jpg',
            'descricao' => 'Escritório de Direito Tributário focado em estratégia, segurança jurídica e resultados reais para empresas de todos os portes.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Sobre', 'url' => '/sobre-nos'],
        ];

        return view('livewire.about')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
