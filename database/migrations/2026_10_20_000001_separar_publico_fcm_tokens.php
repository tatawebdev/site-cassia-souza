<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Notificações em dois públicos que não se misturam: "painel" (mensagens do chat,
 * só para quem tem login) e "site" (avisos de artigos novos, para visitantes).
 * O mesmo navegador pode estar nos dois, então a chave única é token + público.
 * Os tokens já gravados vêm do convite do site ou do painel sem distinção: ficam
 * como "site" e o painel volta a se registrar sozinho ao ser aberto.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('fcm_tokens', 'publico')) {
            Schema::table('fcm_tokens', function (Blueprint $table) {
                $table->string('publico', 10)->default('site')->after('token');
            });
        }

        $indices = collect(Schema::getIndexes('fcm_tokens'))->pluck('name');
        Schema::table('fcm_tokens', function (Blueprint $table) use ($indices) {
            if ($indices->contains('fcm_tokens_token_unique')) {
                $table->dropUnique('fcm_tokens_token_unique');
            }
            if (! $indices->contains('fcm_tokens_token_publico_unique')) {
                $table->unique(['token', 'publico']);
            }
        });

        // Não guardamos mais IP nem navegador de quem pede os avisos
        DB::table('fcm_tokens')->update(['ip_address' => null, 'user_agent' => null]);

        if (! Schema::hasTable('fcm_avisos')) {
            Schema::create('fcm_avisos', function (Blueprint $table) {
                $table->id();
                $table->string('url', 500)->unique();
                $table->string('titulo');
                $table->unsignedInteger('enviados')->default(0);
                $table->unsignedInteger('falhas')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('fcm_avisos');

        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropUnique(['token', 'publico']);
            $table->dropColumn('publico');
        });
    }
};
