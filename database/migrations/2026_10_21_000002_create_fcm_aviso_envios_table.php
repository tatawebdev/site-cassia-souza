<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Um registro por destinatário de cada aviso de artigo: canal (navegador ou
 * e-mail), para quem foi, se deu certo e o erro quando falhou.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fcm_aviso_envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fcm_aviso_id')->constrained('fcm_avisos')->cascadeOnDelete();
            $table->string('canal', 10);
            $table->string('destino');
            $table->boolean('ok');
            $table->string('erro', 500)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fcm_aviso_envios');
    }
};
