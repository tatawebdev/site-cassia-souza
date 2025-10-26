<?php

namespace App\Livewire\Services;

use Livewire\Component;


class TaxConsulting extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Consultoria Tributária',
            'img' => 'banner-consultoria-tributaria.jpg',
            'descricao' => 'Consultoria especializada em matéria tributária.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Consultoria Tributária', 'url' => '/servicos/consultoria-tributaria'],
        ];

        return view('livewire.services.tax-consulting')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}