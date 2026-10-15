<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Prioridade de liberação por demanda real de busca (Google Ads) e porte da cidade
    public function up(): void
    {
        Schema::table('seo_paginas', function (Blueprint $table) {
            // Pontuação de conversão (volume × CPC); maior = liberar antes
            $table->unsignedInteger('prioridade')->nullable()->index();
            // Frase pesquisada, volume, CPC, concorrência e data da consulta
            $table->json('demanda')->nullable();
        });

        Schema::table('seo_localidades', function (Blueprint $table) {
            // População (IBGE, Censo 2022): ordena a liberação das cidades sem demanda medida
            $table->unsignedInteger('populacao')->nullable()->index();
        });
    }

    public function down(): void
    {
        Schema::table('seo_paginas', function (Blueprint $table) {
            $table->dropColumn(['prioridade', 'demanda']);
        });
        Schema::table('seo_localidades', function (Blueprint $table) {
            $table->dropColumn('populacao');
        });
    }
};
