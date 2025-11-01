<?php

namespace App\Livewire\Servicos;

use Livewire\Component;

class TreinamentoTributario extends Component
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

        $imagem1Default = "/assets/servicos/detalhes/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/servicos/detalhes/{$slug}/imagem2.jpg";

        if (!file_exists(public_path($imagem1Default))) {
            $source1 = public_path('/assets/images/singleblog-image1.jpg');
            $destDir1 = dirname(public_path($imagem1Default));
            if (!is_dir($destDir1)) {
                mkdir($destDir1, 0755, true);
            }
            if (file_exists($source1)) {
                copy($source1, public_path($imagem1Default));
            }
        }

        if (!file_exists(public_path($imagem2Default))) {
            $source2 = public_path('/assets/images/singleblog-image1.jpg');
            $destDir2 = dirname(public_path($imagem2Default));
            if (!is_dir($destDir2)) {
                mkdir($destDir2, 0755, true);
            }
            if (file_exists($source2)) {
                copy($source2, public_path($imagem2Default));
            }
        }


        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.servicos.treinamento-tributario', [
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
