<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_atendimento', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->index();
            $table->string('nome_campo')->nullable();
            $table->text('resposta')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_atendimento');
    }
};
