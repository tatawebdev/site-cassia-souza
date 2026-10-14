<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // URLs enviadas à Google Indexing API (google:indexing-sync)
        Schema::create('indexed_pages', function (Blueprint $table) {
            $table->id();
            $table->string('url', 500)->unique();
            $table->timestamp('indexed_at')->nullable();
            $table->text('last_error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indexed_pages');
    }
};
