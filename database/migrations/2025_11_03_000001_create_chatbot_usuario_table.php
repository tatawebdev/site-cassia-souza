<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('telefone')->nullable()->index();
            $table->string('nome')->nullable();
            $table->timestamp('ultima_mensagem')->nullable();
            $table->timestamp('ultima_conversa')->nullable();
            $table->string('notion')->nullable();
            $table->boolean('ia')->default(false);
            $table->boolean('notBot')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_usuario');
    }
};
