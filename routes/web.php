<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\RemoteImageController;
use App\Http\Controllers\PlanosController;
use Illuminate\Support\Facades\DB;

// Rota da Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// PERFIS DE USUÁRIOS - Tanto com @ quanto sem @
// Rota para perfil com @ no início
Route::get('/@{username}', [CreatorController::class, 'show'])->name('creator.profile');

// Rota alternativa sem @ para maior compatibilidade
Route::get('/profile/{username}', [CreatorController::class, 'show'])->name('profile');

// Rota para listagem de todos os criadores/atores
Route::get('/creators', function () {
    return view('pages.creators');
})->name('creators');


// Add to routes/web.php
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// Rota alternativa em português para compatibilidade
Route::get('/contato', function () {
    return view('pages.contact');
})->name('contato');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// Add other footer menu routes
Route::get('/catalog', function () {
    return view('pages.catalog');
})->name('catalog');

Route::get('/pay-per-view', [App\Http\Controllers\PayPerViewController::class, 'index'])->name('pay-per-view');

Route::get('/system-status', function () {
    return view('pages.system-status');
})->name('system-status');

Route::get('/report-issue', function () {
    return view('pages.report-issue');
})->name('report-issue');

Route::get('/cookies', function () {
    return view('pages.cookies');
})->name('cookies');

Route::get('/licenses', function () {
    return view('pages.licenses');
})->name('licenses');

Route::get('/dmca', function () {
    return view('pages.dmca');
})->name('dmca');

Route::get('/news', function () {
    return view('pages.news');
})->name('news');

// Rotas adicionais para funcionalidades de conversão
Route::get('/plans', function () {
    return view('pages.plans');
})->name('plans');

Route::get('/become-creator', function () {
    return view('pages.become-creator');
})->name('become-creator');

Route::get('/creators/{id}', function ($id) {
    // Lógica para exibir perfil do criador
    return view('pages.creator-profile', ['id' => $id]);
})->name('creators.show');

// Rota de login temporária para testes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Rota para requisição de nova senha
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request');

// Rota de registro temporária para testes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Rota para o proxy de imagens (usando sintaxe atual do Laravel)
Route::get('img/{filename}', [RemoteImageController::class, 'show'])
     ->where('filename', '.*\.(jpe?g|png|gif)$')
     ->name('image.proxy');

// Rota para a página de planos
Route::get('/planos', [PlanosController::class, 'index'])->name('planos.index');
Route::get('/planos/{codigo}/assinar', [PlanosController::class, 'assinar'])->name('planos.assinar');
// Rota para o formulário de pagamento do plano
Route::get('/planos/{codigo}/pagamento', [PlanosController::class, 'pagamento'])->name('planos.pagamento');
Route::get('/consulta-planos', function() {
    return DB::table('planos')->count();
});
Route::get('/teste-planos', function() {
    return view('planos', [
        'planos' => [(object)[
            'id' => 1,
            'codigo' => 'TESTE',
            'titulo' => 'Plano de Teste',
            'subtitulo' => 'Apenas para teste',
            'preco' => 99.90,
            'duracao_dias' => 30,
            'tipo_pagamento' => 'cartao',
            'recursos' => json_encode(['Recurso 1', 'Recurso 2']),
            'popular' => 1,
            'destaque' => 0,
            'descricao_curta' => 'Descrição de teste'
        ]],
        'planosPorPeriodo' => [
            'mensal' => [(object)[
                'id' => 1,
                'codigo' => 'TESTE',
                'titulo' => 'Plano de Teste',
                'subtitulo' => 'Apenas para teste',
                'preco' => 99.90,
                'duracao_dias' => 30,
                'tipo_pagamento' => 'cartao',
                'recursos' => json_encode(['Recurso 1', 'Recurso 2']),
                'popular' => 1,
                'destaque' => 0,
                'descricao_curta' => 'Descrição de teste'
            ]]
        ],
        'vantagens' => [
            ['icone' => 'fa-lock', 'titulo' => 'Vantagem 1', 'descricao' => 'Descrição da vantagem 1'],
            ['icone' => 'fa-film', 'titulo' => 'Vantagem 2', 'descricao' => 'Descrição da vantagem 2']
        ],
        'tiposPagamento' => [
            'cartao' => ['icone' => 'fa-credit-card', 'titulo' => 'Cartão de Crédito', 'descricao' => 'Descrição do pagamento']
        ]
    ]);
});

// Rotas para planos premium
Route::get('/api/planos/principais', [PlanosController::class, 'getPrincipais'])->name('api.plans.main');