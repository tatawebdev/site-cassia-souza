<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_config_message_interactive', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_step')->index();
            $table->text('texto_cabecalho')->nullable();
            $table->text('texto_corpo')->nullable();
            $table->text('texto_rodape')->nullable();
            $table->string('texto_botao')->nullable();
            $table->timestamps();

            $table->foreign('id_step')->references('id')->on('chatbot_steps')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_config_message_interactive');
    }
};
