<?php

namespace App\Livewire;

use Livewire\Component;

class Contact extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Contatos',
            'descricao' => 'Entre em contato conosco para dúvidas ou informações.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Contatos', 'url' => '/contatos'],
        ];

        return view('livewire.contact')
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
            ]);
    }
}
