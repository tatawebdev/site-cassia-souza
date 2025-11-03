<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_interacoes_chat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id')->index();
            $table->text('mensagem')->nullable();
            $table->string('remetente')->nullable();
            $table->string('status_mensagem')->nullable();
            $table->unsignedBigInteger('id_step')->nullable()->index();
            $table->string('message_id')->nullable();
            $table->text('data')->nullable();
            $table->timestamp('data_envio')->nullable();
            $table->timestamp('data_recebimento')->nullable();
            $table->timestamp('data_visualizacao')->nullable();
            $table->timestamp('data_leitura')->nullable();
            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('chatbot_usuario')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_interacoes_chat');
    }
};
