<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chatbot_mensagens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_step')->index();
            $table->unsignedBigInteger('id_step_proximo')->nullable()->index();
            $table->text('palavras_chaves')->nullable();
            $table->boolean('opcional')->default(false);
            $table->timestamps();

            $table->foreign('id_step')->references('id')->on('chatbot_steps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chatbot_mensagens');
    }
};
