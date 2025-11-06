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
        if (!Schema::hasColumn('chatbot_options', 'secao_titulo')) {
            Schema::table('chatbot_options', function (Blueprint $table) {
                $table->string('secao_titulo')->nullable()->after('descricao_interacao');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('chatbot_options', 'secao_titulo')) {
            Schema::table('chatbot_options', function (Blueprint $table) {
                $table->dropColumn('secao_titulo');
            });
        }
    }
};
