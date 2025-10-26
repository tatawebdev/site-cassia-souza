<?php

namespace App\Livewire\Services;

use Livewire\Component;

class MedicalDentalTaxPlanning extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Planejamento Tributário para Clínicas',
            'img' => 'banner-planejamento-clinicas.jpg',
            'descricao' => 'Estratégias tributárias específicas para clínicas médicas e odontológicas.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Planejamento para Clínicas', 'url' => '/servicos/planejamento-tributario-clinicas'],
        ];

        return view('livewire.services.medical-dental-tax-planning')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
