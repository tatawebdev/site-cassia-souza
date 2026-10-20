<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * O aviso de artigo novo também vai por e-mail para a newsletter. O e-mail mostra
 * resumo, imagem de capa e categoria do post, e a contagem fica junto da do navegador.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fcm_avisos', function (Blueprint $table) {
            $table->text('resumo')->nullable()->after('titulo');
            $table->string('imagem', 500)->nullable()->after('resumo');
            $table->string('categoria')->nullable()->after('imagem');
            $table->unsignedInteger('emails_enviados')->default(0)->after('falhas');
            $table->unsignedInteger('emails_falhas')->default(0)->after('emails_enviados');
        });
    }

    public function down(): void
    {
        Schema::table('fcm_avisos', function (Blueprint $table) {
            $table->dropColumn(['resumo', 'imagem', 'categoria', 'emails_enviados', 'emails_falhas']);
        });
    }
};
