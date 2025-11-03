<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chatbot_flows', function (Blueprint $table) {
            $table->id();
            $table->string('nome')->nullable();
            $table->boolean('atual')->default(false);
            $table->boolean('teste')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chatbot_flows');
    }
};
