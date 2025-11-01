<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxPlanning extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Planejamento Tributário',
            'img' => 'banner-planejamento-tributario.jpg',
            'descricao' => 'Estratégias tributárias sob medida para reduzir a carga fiscal, garantir previsibilidade e apoiar o crescimento seguro da empresa.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Planejamento Tributário', 'url' => '/servicos/planejamento-tributario'],
        ];

        $base = class_basename($this);
        $slug = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $base));

        $imagem1Default = "/assets/images/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/images/{$slug}/imagem2.jpg";

        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.services.tax-planning', [
            'imagem1' => $imagem1,
            'imagem2' => $imagem2,
        ])
            ->layout('components.layouts.app', [
                'banner' => $banner,
                'breadcrumbs' => $breadcrumbs,
                'pageTitle' => $banner['title'],
            ]);
    }
}
