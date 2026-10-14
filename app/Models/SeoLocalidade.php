<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Cidade, distrito ou bairro das páginas de SEO (dados do IBGE + endereços do site antigo). */
class SeoLocalidade extends Model
{
    protected $table = 'seo_localidades';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'secoes' => 'array',
            'capital' => 'boolean',
            'presencial' => 'boolean',
            'indexar' => 'boolean',
        ];
    }

    public function paginas()
    {
        return $this->hasMany(SeoPagina::class);
    }
}
