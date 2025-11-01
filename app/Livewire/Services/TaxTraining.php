<?php

namespace App\Livewire\Services;

use Livewire\Component;

class TaxTraining extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Treinamento Tributário',
            'img' => 'banner-treinamento-tributario.jpg',
            'descricao' => 'Treinamentos práticos para equipes fiscais: reduzir riscos, evitar autuações e otimizar rotinas — presencial ou online.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Treinamento Tributário', 'url' => '/servicos/treinamento-tributario'],
        ];

        $base = class_basename($this);
        $slug = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $base));

        $imagem1Default = "/assets/images/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/images/{$slug}/imagem2.jpg";

        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.services.tax-training', [
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
