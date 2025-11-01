<?php

namespace App\Livewire\Servicos;

use Livewire\Component;

class RecuperacaoPISCOFINS extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Recuperação de PIS/COFINS (Monofásicos)',
            'img' => 'banner-recuperacao-pis-cofins.jpg',
            'descricao' => 'Analisamos operações, identificamos créditos legítimos e recuperamos valores de PIS/COFINS monofásicos de forma legal, devolvendo recursos importantes ao caixa.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Recuperação PIS/COFINS', 'url' => '/servicos/recuperacao-pis-cofins-monofasicos'],
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



        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';

        return view('livewire.servicos.recuperacao-pis-cofins', [
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
