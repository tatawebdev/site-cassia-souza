<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/** Texto compartilhado pelas páginas de SEO, por chave (ex.: atendimento_online). */
class SeoBloco extends Model
{
    protected $table = 'seo_blocos';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['conteudo' => 'array'];
    }

    public static function conteudo(string $chave, $padrao = null)
    {
        return static::firstWhere('chave', $chave)?->conteudo ?? $padrao;
    }
}
