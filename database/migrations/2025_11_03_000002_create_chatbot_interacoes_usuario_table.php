<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_interacoes_usuario', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario')->index();
            $table->unsignedBigInteger('id_flow')->nullable()->index();
            $table->unsignedBigInteger('id_step')->nullable()->index();
            $table->dateTime('primeira_interacao')->nullable();
            $table->boolean('aguardando')->default(false);
            $table->boolean('ia')->default(false);
            $table->string('tipo_interacao_esperado')->nullable();
            $table->timestamp('ultima_interacao')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('chatbot_usuario')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_interacoes_usuario');
    }
};
