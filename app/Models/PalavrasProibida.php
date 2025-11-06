<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PalavrasProibida extends Model
{
    protected $table = 'palavras_proibidas';

    protected $fillable = [
        'palavra',
    ];

    public $timestamps = false;

    /**
     * Retorna um array simples com todas as palavras proibidas (somente a string).
     * Usado por `validacoes.php`.
     *
     * @return array
     */
    public static function getAllPalavrasOnly(): array
    {
        return self::query()->pluck('palavra')->toArray();
    }
}
