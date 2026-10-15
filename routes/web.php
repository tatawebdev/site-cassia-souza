<?php

use App\Http\Controllers\GoogleAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use Inertia\Inertia;

Route::get('/login', function () {
    return redirect()->route('login');
});
// Home no tema novo (Tailwind). A antiga (Bootstrap) fica em /antigo enquanto
// as demais páginas migram uma a uma.
Route::view('/', 'novo.home')->name('inicio');
Route::get('/antigo', \App\Livewire\Index::class)->name('antigo.inicio');
Route::redirect('/novo', '/', 301);

Route::view('/sobre-nos', 'novo.sobre')->name('sobre');
Route::get('/antigo/sobre-nos', \App\Livewire\About::class)->name('antigo.sobre');
Route::view('/contato', 'novo.contato')->name('contato');
Route::get('/antigo/contato', \App\Livewire\Contact::class)->name('antigo.contato');
// Serviços no tema novo: listagem e uma página por serviço (config/servicos.php).
// A listagem antiga (Livewire Servicos) nunca funcionou (view inexistente), então não ganhou /antigo.
Route::view('/servicos', 'novo.servicos')->name('servicos');
foreach (config('servicos') as $servico) {
    Route::view('/servicos/'.$servico['slug'], 'novo.servico', ['slug' => $servico['slug']])->name($servico['route']);
}

// Versões antigas das páginas de serviço
Route::get('/antigo/servicos/consultoria-tributaria', \App\Livewire\Servicos\ConsultoriaTributaria::class)->name('antigo.servicos.consultoria.tributaria');
Route::get('/antigo/servicos/regularizacao-debitos-pgfn', \App\Livewire\Servicos\RegularizacaoDebitosPGFN::class)->name('antigo.servicos.regularizacao.debitos.pgfn');
Route::get('/antigo/servicos/planejamento-tributario', \App\Livewire\Servicos\PlanejamentoTributario::class)->name('antigo.servicos.planejamento.tributario');
Route::get('/antigo/servicos/planejamento-tributario-clinicas', \App\Livewire\Servicos\PlanejamentoClinicas::class)->name('antigo.servicos.planejamento.tributario.clinicas');
Route::get('/antigo/servicos/assessoria-reforma-tributaria', \App\Livewire\Servicos\AssessoriaReformaTributaria::class)->name('antigo.servicos.assessoria.reforma.tributaria');
Route::get('/antigo/servicos/treinamento-tributario', \App\Livewire\Servicos\TreinamentoTributario::class)->name('antigo.servicos.treinamento.tributario');
Route::get('/antigo/servicos/recuperacao-pis-cofins-monofasicos', \App\Livewire\Servicos\RecuperacaoPISCOFINS::class)->name('antigo.servicos.recuperacao.pis.cofins.monofasicos');

// Página: Política de Privacidade
Route::view('/politica-de-privacidade', 'novo.privacidade')->name('privacy');
Route::get('/antigo/politica-de-privacidade', \App\Livewire\PoliticaPrivacidade::class)->name('antigo.privacy');

Route::get('/auth/google/redirecionar', [GoogleAuthController::class, 'redirect'])->name('google.redirecionar');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// Rotas alternativas (em inglês) usadas pelo frontend React/Inertia
Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


Route::get('/conectar-google', fn() => redirect()->route('google.redirect'))->name('google.connect');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Dashboard API stats (used by the SPA frontend)
Route::get('/dashboard/stats', [\App\Http\Controllers\DashboardController::class, 'stats'])
    ->middleware(['auth'])->name('dashboard.stats');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Chat API (métodos para o frontend consumir)
    Route::get('/chat/contacts', [\App\Http\Controllers\ChatController::class, 'contacts'])->name('chat.api.contacts');
    Route::get('/chat/{usuario}/messages', [\App\Http\Controllers\ChatController::class, 'messages'])->name('chat.api.messages');
    Route::post('/chat/messages', [\App\Http\Controllers\ChatController::class, 'storeMessage'])->name('chat.api.storeMessage');
});

require __DIR__ . '/auth.php';




// Rota mocado para o chat de contatos (Inertia)
Route::get('/chat', function () {
    return Inertia::render('Chat/ContactsChat');
})->middleware(['auth'])->name('chat.contacts');

// Sitemap: páginas institucionais + páginas de SEO liberadas para o Google
Route::get('/sitemap.xml', \App\Http\Controllers\SitemapController::class)->name('sitemap');

// Resumo do site para assistentes de IA (llms.txt), montado de config/servicos.php
Route::get('/llms.txt', \App\Http\Controllers\LlmsController::class)->name('llms');

// Páginas de SEO herdadas do site antigo (/{termo}/{localidade}), com o texto no banco
// (seo_termos, seo_localidades, seo_paginas, seo_blocos). Fica por último: só recebe o que
// nenhuma outra rota atendeu, e o controller devolve 404 para termo ou localidade inexistente.
Route::get('/{termo}/{local?}/{uf?}', \App\Http\Controllers\PaginaSeoController::class)
    ->where(['termo' => "[A-Za-z0-9'-]+", 'local' => "[A-Za-z0-9'-]+", 'uf' => '[A-Za-z]{2}'])
    ->name('seo.pagina');
