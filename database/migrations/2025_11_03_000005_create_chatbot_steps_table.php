<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_steps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_flow')->index();
            $table->text('pergunta')->nullable();
            $table->string('tipo_resposta')->nullable();
            $table->string('tipo_interacao')->nullable();
            $table->unsignedBigInteger('id_step_proximo')->nullable()->index();
            $table->unsignedBigInteger('parent')->nullable()->index();
            $table->string('nome_campo')->nullable();
            $table->string('nome_da_funcao')->nullable();
            $table->string('titulo')->nullable();
            $table->timestamps();

            $table->foreign('id_flow')->references('id')->on('chatbot_flows')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_steps');
    }
};
