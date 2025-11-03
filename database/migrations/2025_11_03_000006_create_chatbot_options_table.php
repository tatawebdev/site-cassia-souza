<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_step')->index();
            $table->string('resposta_opcional')->nullable();
            $table->unsignedBigInteger('id_step_proximo')->nullable()->index();
            $table->string('tipo_interacao')->nullable();
            $table->string('titulo_interacao')->nullable();
            $table->string('descricao_interacao')->nullable();
            $table->timestamps();

            $table->foreign('id_step')->references('id')->on('chatbot_steps')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_options');
    }
};
