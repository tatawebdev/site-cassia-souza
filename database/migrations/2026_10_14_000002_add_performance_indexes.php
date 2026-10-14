<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * Índices para as consultas mais frequentes do chatbot que ainda não tinham:
 * - chatbot_atendimento: sempre busca "numero + nome_campo" (CNPJ, Assunto)
 * - chatbot_interacoes_usuario: painel e checagem de abandono filtram por "aguardando"
 * O resto das colunas consultadas (numero, telefone, usuario_id, id_step,
 * email, url) já tinha índice. webhook_events só recebe gravações: sem índice.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasIndex('chatbot_atendimento', 'chatbot_atendimento_numero_nome_campo_index')) {
            Schema::table('chatbot_atendimento', function (Blueprint $table) {
                $table->index(['numero', 'nome_campo']);
            });
        }

        if (! Schema::hasIndex('chatbot_interacoes_usuario', 'chatbot_interacoes_usuario_aguardando_index')) {
            Schema::table('chatbot_interacoes_usuario', function (Blueprint $table) {
                $table->index('aguardando');
            });
        }
    }

    public function down(): void
    {
        Schema::table('chatbot_atendimento', fn (Blueprint $table) => $table->dropIndex(['numero', 'nome_campo']));
        Schema::table('chatbot_interacoes_usuario', fn (Blueprint $table) => $table->dropIndex(['aguardando']));
    }
};
