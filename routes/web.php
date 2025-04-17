<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\CreatorController;

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

Route::get('/catalog', function () {
    return view('pages.catalog');
})->name('catalog');

Route::get('/creators', function () {
    return view('pages.creators');
})->name('creators');

Route::get('/news', function () {
    return view('pages.news');
})->name('news');

// Rotas adicionais para funcionalidades de conversão
Route::get('/plans', function () {
    return view('pages.plans');
})->name('plans');

Route::get('/become-creator', function () {
    return view('pages.become-creator');
})->name('creators.apply');

Route::get('/creators/{id}', function ($id) {
    // Lógica para exibir perfil do criador
    return view('pages.creator-profile', ['id' => $id]);
})->name('creators.show');

// Rota de perfil do criador
Route::get('/@{username}', [App\Http\Controllers\CreatorController::class, 'show'])
    ->name('creator.profile');

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