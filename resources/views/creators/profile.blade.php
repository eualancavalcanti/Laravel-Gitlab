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
                <h1 class="profile-name">{{ $creator->name }}</h1>
                <h2 class="profile-username">@{{ $creator->username }} 
                    @if($creator->is_verified)
                    <span class="verified-badge">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    </span>
                    @endif
                </h2>
                
                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-value">{{ $creator->videos_count }}</span>
                        <span class="stat-label">Vídeos</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ $creator->vip_count }}</span>
                        <span class="stat-label">VIP</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value">{{ $creator->photos_count }}</span>
                        <span class="stat-label">Fotos</span>
                    </div>
                </div>
            </div>
            
            <!-- Botão de Assinatura/Login -->
            <div class="profile-actions">
                <button class="subscribe-btn" data-toggle="modal" data-target="#loginModal">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                    </svg>
                    Assinar
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
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Entre para ter acesso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Acesse sua conta para ver o conteúdo exclusivo de {{ $creator->name }}</p>
                <form action="{{ route('login') }}" method="post">
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
                <hr>
                <div class="text-center">
                    <p>Ainda não tem uma conta?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Criar conta</a>
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