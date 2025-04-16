```php
@extends('layouts.app')

@section('title', $creator->name . ' - HotBoys')

@section('content')
<div class="profile-container">
    <!-- Área do Banner -->
    <div class="profile-banner" style="background-image: url('{{ $creator->banner_image }}')">
        <div class="banner-overlay"></div>
    </div>
    
    <!-- Seção de Informações do Perfil -->
    <div class="container">
        <div class="profile-header">
            <!-- Foto de Perfil -->
            <div class="profile-photo">
                <img src="{{ $creator->profile_image }}" alt="{{ $creator->name }}">
            </div>
            
            <!-- Informações do Perfil -->
            <div class="profile-info">
                <!-- Oferta -->
                 <!--
                <div class="limited-offer">
                    <span class="offer-text">Oferta por tempo limitado!</span>
                    <span class="offer-timer" id="offerTimer">23:59:59</span>
                </div> -->

                <h1 class="profile-name">{{ $creator->name }}</h1>
                <h2 class="profile-username">
                    @{{ $creator->username }} 
                    @if($creator->is_verified)
                    <span class="verified-badge" title="Conta Verificada">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </span>
                    @endif
                    <span class="online-badge" title="Online Agora"></span>
                </h2>
                
                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-value">{{ number_format($creator->videos_count) }}</span>
                        <span class="stat-label">Vídeos</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ number_format($creator->vip_count) }}</span>
                        <span class="stat-label">VIP</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ number_format($creator->photos_count) }}</span>
                        <span class="stat-label">Fotos</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ number_format($creator->visualizacao) }}</span>
                        <span class="stat-label">Visualizações</span>
                    </div>
                </div>
                
                <!-- Social badges without inline styles -->
                <div class="social-badges">
                    <a href="#" title="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="#" title="Twitter">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
                        </svg>
                    </a>
                    <a href="#" title="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
                        </svg>
                    </a>
                </div>
            </div>
            
            <!-- Botão de Assinatura/Login -->
            <div class="profile-actions">
            <button class="subscribe-btn pulse-animation" data-toggle="modal" data-target="#loginModal">
                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
                Assinar agora <span class="discount-badge">-50%</span>
            </button>
            </div>
        </div>
        
        <!-- Abas de Conteúdo -->
        <div class="profile-tabs">
            <button class="tab-btn active" data-tab="exclusive">Exclusivos</button>
            <button class="tab-btn" data-tab="vip">VIP</button>
            <button class="tab-btn" data-tab="packs">Packs</button>
            <button class="tab-btn" data-tab="about">Sobre</button>
        </div>
        
        <!-- Conteúdo das Abas -->
        <div class="tab-contents">
            <!-- Aba de Conteúdo Exclusivo -->
            <div class="tab-content active" id="exclusive">
                <div class="content-grid">
                    @forelse($exclusiveContent as $content)
                    <div class="content-card">
                        <div class="thumbnail">
                            <img src="{{ $content->thumbnail }}" alt="{{ $content->title }}">
                            <div class="thumbnail-overlay"></div>
                            <div class="content-badge exclusive">Exclusivo</div>
                            <div class="content-duration">{{ $content->duration }}</div>
                            <div class="play-icon">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                            <div class="content-lock">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="content-info">
                            <h3 class="content-title">{{ $content->title }}</h3>
                            <div class="content-meta">
                                <div class="content-price">R$ {{ number_format($content->price, 2, ',', '.') }}</div>
                                <div class="content-likes">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    {{ $content->likes_count }}
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="popularity-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"></path>
                            </svg>
                            <span>Popular</span>
                        </div>-->
                    </div>
                    @empty
                    <div class="empty-content">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <h3>Conteúdo Exclusivo</h3>
                        <p>Faça login para visualizar o conteúdo exclusivo de {{ $creator->name }}</p>
                        <button class="btn-login" data-toggle="modal" data-target="#loginModal">Entrar</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Aba de Conteúdo VIP -->
            <div class="tab-content" id="vip">
                <div class="content-grid">
                    @forelse($vipContent as $content)
                    <div class="content-card">
                        <div class="thumbnail">
                            <img src="{{ $content->thumbnail }}" alt="{{ $content->title }}">
                            <div class="thumbnail-overlay"></div>
                            <div class="content-badge vip">VIP</div>
                            <div class="content-duration">{{ $content->duration }}</div>
                            <div class="play-icon">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                            <div class="content-lock">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="content-info">
                            <h3 class="content-title">{{ $content->title }}</h3>
                            <div class="content-meta">
                                <div class="content-price">VIP</div>
                                <div class="content-likes">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    {{ $content->likes_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-content">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <h3>Conteúdo VIP</h3>
                        <p>Faça login para visualizar o conteúdo VIP de {{ $creator->name }}</p>
                        <button class="btn-login" data-toggle="modal" data-target="#loginModal">Entrar</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Aba de Packs -->
            <div class="tab-content" id="packs">
                <div class="content-grid">
                    @forelse($packs as $pack)
                    <div class="content-card pack-card">
                        <div class="thumbnail">
                            <img src="{{ $pack->thumbnail }}" alt="{{ $pack->title }}">
                            <div class="thumbnail-overlay"></div>
                            <div class="content-badge pack">PACK</div>
                            <div class="content-items">{{ $pack->items_count }} itens</div>
                            <div class="pack-icon">
                                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                </svg>
                            </div>
                            <div class="content-lock">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="content-info">
                            <h3 class="content-title">{{ $pack->title }}</h3>
                            <div class="content-meta">
                                <div class="content-price">R$ {{ number_format($pack->price, 2, ',', '.') }}</div>
                                <div class="content-likes">
                                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>
                                    {{ $pack->likes_count }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-content">
                        <div class="empty-icon">
                            <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <h3>Packs Exclusivos</h3>
                        <p>Faça login para visualizar os packs exclusivos de {{ $creator->name }}</p>
                        <button class="btn-login" data-toggle="modal" data-target="#loginModal">Entrar</button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Aba Sobre -->
            <div class="tab-content" id="about">
                <div class="about-section">
                    <div class="about-bio">
                        <h3>Sobre {{ $creator->name }}</h3>
                        <div class="bio-content">
                            {!! $creator->description !!}
                        </div>
                    </div>
                    
                    <div class="subscription-options">
                        <h3>Opções de Assinatura</h3>
                        <div class="subscription-cards">
                            <!-- Plano básico -->
                            <div class="subscription-card">
                                <div class="card-header">Básico</div>
                                <div class="card-price">R$ 29,90<span>/mês</span></div>
                                <ul class="card-features">
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Acesso a todo conteúdo VIP
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Atualizações semanais
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Qualidade HD
                                    </li>
                                </ul>
                                <button class="btn-subscribe" data-toggle="modal" data-target="#loginModal">Assinar</button>
                            </div>
                            
                            <!-- Plano premium -->
                            <div class="subscription-card premium">
                                <div class="popular-tag">Mais Popular</div>
                                <div class="card-header">Premium</div>
                                <div class="card-price">R$ 49,90<span>/mês</span></div>
                                <ul class="card-features">
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Acesso a todo conteúdo VIP
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        20% de desconto em exclusivos
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Qualidade 4K Ultra HD
                                    </li>
                                    <li>
                                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                        Download para assistir offline
                                    </li>
                                </ul>
                                <button class="btn-subscribe btn-premium" data-toggle="modal" data-target="#loginModal">Assinar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Login -->
<!-- Atualizar o modal de login em resources/views/creators/profile.blade.php -->

<div class="modal" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Acesse este conteúdo exclusivo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="login-benefits">
                    <div class="benefit-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>Acesso a <strong>{{ $creator->videos_count }} vídeos exclusivos</strong></span>
                    </div>
                    <div class="benefit-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span>Qualidade <strong>HD e 4K Ultra</strong></span>
                    </div>
                    <div class="benefit-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FF3333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                        <span><strong>Novos conteúdos</strong> toda semana</span>
                    </div>
                </div>
                
                <div class="login-tabs">
                    <button class="tab-button active" data-tab="login">Entrar</button>
                    <button class="tab-button" data-tab="register">Criar Conta</button>
                </div>
                
                <div class="login-tab-content active" id="login-tab">
                    <form action="{{ route('login') }}" method="post" class="mt-4">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Entrar</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
                    </div>
                </div>
                
                <div class="login-tab-content" id="register-tab">
                    <form action="{{ route('register') }}" method="post" class="mt-4">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="register-name">Nome</label>
                            <input type="text" class="form-control" id="register-name" name="name" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="register-email">E-mail</label>
                            <input type="email" class="form-control" id="register-email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="register-password">Senha</label>
                            <input type="password" class="form-control" id="register-password" name="password" required>
                        </div>
                        <div class="form-group mb-4">
                            <label for="register-password-confirm">Confirmar Senha</label>
                            <input type="password" class="form-control" id="register-password-confirm" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Criar Conta</button>
                    </form>
                </div>
                
                <div class="social-login mt-4">
                    <p class="text-center">Ou entrar com:</p>
                    <div class="social-buttons">
                        <button class="btn-social btn-google">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            Google
                        </button>
                        <button class="btn-social btn-facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                            Facebook
                        </button>
                    </div>
                </div>
                
                <div class="login-security mt-4">
                    <div class="security-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Pagamento 100% seguro e discreto</span>
                    </div>
                    <div class="security-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Privacidade garantida</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('css/creator-profile.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/creator-profile.js') }}" defer></script>
@endpush