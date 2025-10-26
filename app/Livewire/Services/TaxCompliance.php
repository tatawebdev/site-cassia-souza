<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxCompliance extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Compliance Tributário',
            'descricao' => 'Soluções em compliance tributário para sua empresa.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Compliance Tributário', 'url' => '/servicos/compliance-tributario'],
        ];

        return view('livewire.services.tax-compliance')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
