<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Libera todos os municípios, bairros e distritos para indexação no Google
        DB::table('seo_localidades')
            ->where('tipo', '!=', 'homonimo')
            ->update(['indexar' => true]);
    }

    public function down(): void
    {
        // Reverte mantendo apenas as capitais e cidades estratégicas de SP/Alto Tietê
        DB::table('seo_localidades')
            ->where('tipo', '!=', 'homonimo')
            ->update(['indexar' => false]);

        DB::table('seo_localidades')
            ->where(function ($query) {
                $query->where('presencial', true)
                    ->orWhere('capital', true)
                    ->orWhere(function ($q) {
                        $q->where('uf', 'SP')->where('microrregiao', 'like', '%São Paulo%');
                    });
            })
            ->where('tipo', '!=', 'homonimo')
            ->update(['indexar' => true]);
    }
};
