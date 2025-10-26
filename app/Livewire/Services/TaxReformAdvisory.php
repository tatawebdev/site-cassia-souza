<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxReformAdvisory extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Assessoria para Reforma Tributária',
            'img' => 'banner-assessoria-reforma.jpg',
            'descricao' => 'Orientação estratégica para adaptação às mudanças da reforma tributária.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Assessoria Reforma Tributária', 'url' => '/servicos/assessoria-reforma-tributaria'],
        ];

        return view('livewire.services.tax-reform-advisory')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
