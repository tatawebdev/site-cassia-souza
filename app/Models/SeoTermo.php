<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Termo de busca das páginas de SEO (ex.: advocacia-tributaria), com o modelo de texto. */
class SeoTermo extends Model
{
    protected $table = 'seo_termos';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'introducoes' => 'array',
            'secoes' => 'array',
            'indexar' => 'boolean',
            'ativo' => 'boolean',
        ];
    }

    public function paginas()
    {
        return $this->hasMany(SeoPagina::class);
    }
}
