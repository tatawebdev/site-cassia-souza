<?php

namespace App\Livewire\Services;

use Livewire\Component;

class AdministrativeDefense extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Defesa Administrativa',
            'descricao' => 'Atuação em defesa administrativa para proteger seus direitos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Defesa Administrativa', 'url' => '/servicos/defesa-administrativa'],
        ];

        return view('livewire.services.administrative-defense')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
