<?php

namespace App\Models\Legacy;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PalavrasProibidas extends Model
{
    protected $table = 'palavras_proibidas';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public static function getAllPalavras()
    {
        return self::select('id', 'palavra')->get()->toArray();
    }

    public static function existsPalavra($palavra)
    {
        return self::where('palavra', $palavra)->exists();
    }

    public static function getAllPalavrasOnly()
    {
        return self::pluck('palavra')->toArray();
    }

    public static function addPalavra($palavra)
    {
        if (self::where('palavra', $palavra)->exists()) {
            throw new \Exception("A palavra '$palavra' já está proibida.");
        }
        return self::create(['palavra' => $palavra])->toArray();
    }

    public static function removePalavra($id)
    {
        $existing = self::where('id', $id)->first();
        if (!$existing) {
            throw new \Exception("Palavra não encontrada com o ID: $id");
        }
        self::where('id', $id)->delete();
        return true;
    }
}
