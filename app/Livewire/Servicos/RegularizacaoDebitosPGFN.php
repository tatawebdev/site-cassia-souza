<?php

namespace App\Livewire\Servicos;

use Livewire\Component;

class RegularizacaoDebitosPGFN extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Regularização de Débitos (PGFN)',
            'img' => 'banner-regularizacao-pgfn.jpg',
            'descricao' => 'Negociação e parcelamento de débitos inscritos na Dívida Ativa (PGFN), com foco em recuperação financeira e redução de encargos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Regularização de Débitos (PGFN)', 'url' => '/servicos/regularizacao-debitos-pgfn'],
        ];

        $base = class_basename($this);
        $slug = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $base));

        $imagem1Default = "/assets/images/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/images/{$slug}/imagem2.jpg";

        if (!file_exists(public_path($imagem1Default))) {
            $source1 = public_path('/assets/images/singleblog-image1.jpg');
            if (file_exists($source1)) {
                copy($source1, public_path($imagem1Default));
            }
        }

        if (!file_exists(public_path($imagem2Default))) {
            $source2 = public_path('/assets/images/singleblog-image1.jpg');
            if (file_exists($source2)) {
                copy($source2, public_path($imagem2Default));
            }
        }

        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.servicos.regularizacao-debitos-pgfn', [
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
