<?php

namespace App\Livewire\Services;

use Livewire\Component;

class AdministrativeDefense extends Component
{
    public function render()
    {
        $banner = [
            'title' => 'Defesa Administrativa',
            'img' => 'banner-defesa-administrativa.jpg',
            'descricao' => 'Atuação em defesa administrativa para proteger seus direitos.',
        ];
        $breadcrumbs = [
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Serviços', 'url' => '/servicos'],
            ['label' => 'Defesa Administrativa', 'url' => '/servicos/defesa-administrativa'],
        ];

        $base = class_basename($this);
        $slug = strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1-$2', $base));

        $imagem1Default = "/assets/images/{$slug}/imagem1.jpg";
        $imagem2Default = "/assets/images/{$slug}/imagem2.jpg";

        if (!file_exists(public_path($imagem1Default))) {
            $source1 = public_path('/assets/images/singleblog-image1.jpg');
            if (file_exists($source1)) {
            @copy($source1, public_path($imagem1Default));
            }
        }

        if (!file_exists(public_path($imagem2Default))) {
            $source2 = public_path('/assets/images/singleblog-image1.jpg');
            if (file_exists($source2)) {
            @copy($source2, public_path($imagem2Default));
            }
        }

        $imagem1 = file_exists(public_path($imagem1Default)) ? $imagem1Default : '/assets/images/singleblog-image1.jpg';
        $imagem2 = file_exists(public_path($imagem2Default)) ? $imagem2Default : '/assets/images/singleblog-image2.jpg';



        
        return view('livewire.services.administrative-defense', [
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
