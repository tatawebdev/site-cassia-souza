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
            'descricao' => 'Consultoria mensal que revisa movimentações fiscais, previne riscos e identifica oportunidades para garantir conformidade e economia.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Consultoria Tributária', 'url' => '/servicos/consultoria-tributaria'],
        ];

        $base = class_basename($this);
        $slug = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $base));

        $imagem1Default = "/assets/images/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/images/{$slug}/imagem2.jpg";

        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.services.tax-consulting', [
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