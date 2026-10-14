<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Páginas de SEO /{termo}/{localidade} (herdadas do site antigo). O texto vem do
    // termo (modelo com {local}, {uf}...), dos blocos compartilhados e, quando existe,
    // da página editada à mão (seo_paginas), que tem prioridade.
    public function up(): void
    {
        Schema::create('seo_termos', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            $table->string('nome', 160);
            // Serviço de config/servicos.php ligado ao termo (banner, FAQ, destaque)
            $table->string('servico', 120)->nullable();
            $table->string('h1', 255);
            $table->string('titulo_seo', 255);
            $table->string('descricao_seo', 500);
            $table->string('subtitulo', 500);
            // Variações de abertura: lista de listas de parágrafos; cada página usa uma
            $table->json('introducoes');
            // Seções do meio da página: [{titulo, paragrafos}]; vazio = bloco "secoes"
            $table->json('secoes')->nullable();
            $table->boolean('indexar')->default(false);
            // Termo sinônimo: a página aponta (canonical) para a do termo principal
            $table->string('canonical', 120)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });

        Schema::create('seo_localidades', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 120)->unique();
            // Nome sem UF: homônimos (bom-jesus-pi, bom-jesus-rs) compartilham o mesmo
            $table->string('slug_base', 120)->index();
            $table->string('nome', 160);
            $table->string('tipo', 20); // municipio, distrito, bairro, homonimo
            $table->char('uf', 2)->nullable();
            // Distritos e bairros: o município a que pertencem (quando conhecido)
            $table->string('municipio', 160)->nullable();
            $table->string('microrregiao', 160)->nullable()->index();
            $table->string('mesorregiao', 160)->nullable();
            $table->string('regiao', 40)->nullable();
            $table->unsignedBigInteger('ibge_id')->nullable();
            $table->boolean('capital')->default(false);
            // Alto Tietê: atendimento presencial em Suzano
            $table->boolean('presencial')->default(false);
            $table->boolean('indexar')->default(false);
            // Texto próprio da localidade (pesquisa): [{titulo, paragrafos}]
            $table->json('secoes')->nullable();
            $table->timestamps();
        });

        Schema::create('seo_paginas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seo_termo_id')->constrained('seo_termos')->cascadeOnDelete();
            $table->foreignId('seo_localidade_id')->constrained('seo_localidades')->cascadeOnDelete();
            // Campos vazios usam o modelo do termo
            $table->string('h1', 255)->nullable();
            $table->string('titulo_seo', 255)->nullable();
            $table->string('descricao_seo', 500)->nullable();
            $table->string('subtitulo', 500)->nullable();
            $table->json('introducao')->nullable();
            $table->json('secoes')->nullable();
            // null = segue o termo e a localidade
            $table->boolean('indexar')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->unique(['seo_termo_id', 'seo_localidade_id']);
        });

        // Textos compartilhados por todas as páginas (atendimento, seções padrão)
        Schema::create('seo_blocos', function (Blueprint $table) {
            $table->id();
            $table->string('chave', 80)->unique();
            $table->json('conteudo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_paginas');
        Schema::dropIfExists('seo_blocos');
        Schema::dropIfExists('seo_localidades');
        Schema::dropIfExists('seo_termos');
    }
};
