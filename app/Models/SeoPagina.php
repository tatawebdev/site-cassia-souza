<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Página termo + localidade editada à mão: os campos preenchidos substituem o modelo do termo. */
class SeoPagina extends Model
{
    protected $table = 'seo_paginas';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'introducao' => 'array',
            'secoes' => 'array',
            'indexar' => 'boolean',
        ];
    }

    public function termo()
    {
        return $this->belongsTo(SeoTermo::class, 'seo_termo_id');
    }

    public function localidade()
    {
        return $this->belongsTo(SeoLocalidade::class, 'seo_localidade_id');
    }
}
