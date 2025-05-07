@extends('layouts.app')

@section('title', 'Nossos Planos - HotBoys')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/planos-dark-2023.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Estilos para os botões de filtro */
    .payment-filter {
        display: flex;
        justify-content: center;
        margin: 0 auto 30px;
        max-width: 400px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    
    .payment-filter-btn {
        flex: 1;
        padding: 12px 20px;
        background-color: #272727;
        color: #ccc;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .payment-filter-btn.active {
        background-color: #7220d9;
        color: white;
    }
    
    .payment-filter-btn:hover:not(.active) {
        background-color: #333;
    }
    
    .payment-filter-btn i {
        font-size: 18px;
    }
    
    .plan-grid-container {
        position: relative;
    }
    
    .plans-grid.pix-active .plan-card[data-payment="cartao"],
    .plans-grid.cartao-active .plan-card[data-payment="pix"] {
        display: none;
    }
    
    .plans-grid .plan-card {
        transition: all 0.5s ease-in-out;
    }
</style>
@endpush

@section('content')
<div class="plans-container">
    <div class="plans-header">
        <h1 class="plans-title">Escolha o Plano <span>Ideal</span></h1>
        <p class="plans-subtitle">Acesso completo à nossa plataforma com o plano que mais combina com você. Conteúdo exclusivo em alta qualidade.</p>
    </div>

    @if(session('error'))
        <div class="plan-alert plan-alert-error">
            <i class="fas fa-exclamation-triangle fa-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($planos && count($planos) > 0)
        <!-- Botões de filtro para tipo de pagamento -->
        <div class="payment-filter">
            <button class="payment-filter-btn active" data-filter="todos">
                <i class="fas fa-filter"></i> Todos os Planos
            </button>
            <button class="payment-filter-btn" data-filter="pix">
                <i class="fas fa-bolt"></i> PIX
            </button>
            <button class="payment-filter-btn" data-filter="cartao">
                <i class="fas fa-credit-card"></i> Cartão
            </button>
        </div>
        
        <div class="plan-grid-container">
            <div class="plans-grid">
                @foreach($planos as $plano)
                    <div class="plan-card {{ $plano->destaque ? 'featured' : '' }} animate-in" 
                         data-payment="{{ $plano->tipo_pagamento }}"
                         style="animation-delay: {{ $loop->index * 0.1 }}s;">
                        <div class="spotlight"></div>
                        @if($plano->popular)
                            <div class="plan-badge">Popular</div>
                        @endif
                        <div class="plan-head">
                            <h3 class="plan-name" data-text="{{ $plano->titulo }}" style="color: {{ $plano->cor_titulo ?? 'var(--text-color)' }};">{{ $plano->titulo }}</h3>
                            @if($plano->subtitulo)
                                <p class="plan-period" style="margin-bottom: 0.5rem; font-size: 0.95em; color: var(--text-muted);">{{ $plano->subtitulo }}</p>
                            @endif
                            
                            <div class="plan-price">
                                @if($plano->promocao && isset($plano->preco_promocional) && $plano->preco_promocional < $plano->preco)
                                    <span class="currency">R$</span>
                                    <span class="price-value">{{ number_format($plano->preco_promocional, 2, ',', '.') }}</span>
                                    <span style="text-decoration: line-through; font-size: 0.6em; color: var(--text-muted); margin-left: 8px; align-self: center;">R$ {{ number_format($plano->preco, 2, ',', '.') }}</span>
                                @else
                                    <span class="currency">R$</span>
                                    <span class="price-value">{{ number_format($plano->preco, 2, ',', '.') }}</span>
                                @endif
                            </div>
                            <p class="plan-period">/ {{ $plano->periodo_recorrencia }}</p>
                            @if($plano->promocao && isset($plano->preco_promocional) && $plano->preco_promocional < $plano->preco)
                                <span class="save-badge">Economize R$ {{ number_format($plano->preco - $plano->preco_promocional, 2, ',', '.') }}</span>
                            @endif
                        </div>

                        <ul class="plan-features">
                            <li class="feature-item highlight"><i class="fas fa-calendar-alt"></i> Acesso por {{ $plano->duracao_dias }} dias</li>
                            <li class="feature-item"><i class="fas fa-credit-card"></i> Pagamento via {{ ucfirst($plano->tipo_pagamento) }}</li>
                            <li class="feature-item"><i class="fas fa-desktop"></i> Máx. {{ $plano->max_dispositivos }} dispositivo(s)</li>
                            
                            @if($plano->recursos)
                                @php
                                    $recursosArray = json_decode($plano->recursos, true);
                                @endphp
                                @if(is_array($recursosArray) && count($recursosArray) > 0)
                                    @foreach($recursosArray as $recurso)
                                        <li class="feature-item"><i class="fas fa-check"></i> {{ $recurso }}</li>
                                    @endforeach
                                @else
                                    {{-- Fallback se 'recursos' for um JSON inválido ou vazio --}}
                                    <li class="feature-item"><i class="fas fa-film"></i> Acesso a todos os vídeos</li>
                                    <li class="feature-item highlight"><i class="fas fa-star"></i> Conteúdo em alta qualidade</li>
                                @endif
                            @else
                                {{-- Fallback se 'recursos' for null --}}
                                <li class="feature-item"><i class="fas fa-film"></i> Acesso a todos os vídeos</li>
                                <li class="feature-item highlight"><i class="fas fa-star"></i> Conteúdo em alta qualidade</li>
                            @endif
                        </ul>

                        <div class="plan-action">
                            <a href="{{ route('planos.assinar', ['codigo' => $plano->codigo]) }}" 
                               class="plan-button {{ $plano->destaque ? 'primary-button' : 'secondary-button' }}">
                               <i class="fas fa-shopping-cart"></i> Assinar Agora
                            </a>
                        </div>
                        @if($plano->descricao_curta)
                            <p style="font-size: 0.85em; text-align: center; margin-top: 15px; color: var(--text-muted); padding: 0 10px;">{{ $plano->descricao_curta }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="plan-alert plan-alert-info">
            <i class="fas fa-info-circle fa-3x"></i>
            <h4>Nenhum Plano Disponível</h4>
            <p>No momento, não temos planos para exibir. Por favor, volte mais tarde para conferir nossas ofertas!</p>
        </div>
    @endif

    <div class="plans-cta">
        <h2 class="cta-title">Dúvidas sobre os Planos?</h2>
        <p class="cta-text">Nossa equipe está pronta para te ajudar a escolher o melhor plano ou responder qualquer questão.</p>
        <a href="{{ route('contact') }}" class="cta-button">
            <i class="fas fa-headset"></i> Fale Conosco
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Adiciona o atributo data-text para o efeito 3D do nome do plano
        document.querySelectorAll('.plan-name').forEach(name => {
            if (!name.hasAttribute('data-text')) {
                name.setAttribute('data-text', name.textContent);
            }
        });
        
        // Efeito de spotlight nos cards
        const planCards = document.querySelectorAll('.plan-card');
        planCards.forEach(card => {
            const spotlight = card.querySelector('.spotlight');
            if (spotlight) {
                card.addEventListener('mousemove', (e) => {
                    const rect = card.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    spotlight.style.setProperty('--x', `${x}px`);
                    spotlight.style.setProperty('--y', `${y}px`);
                    
                    // Adiciona efeito 3D sutil baseado na posição do mouse
                    const xPercent = (x / rect.width - 0.5) * 10;
                    const yPercent = (y / rect.height - 0.5) * 10;
                    card.style.transform = `translateY(-15px) translateZ(20px) rotateX(${-yPercent}deg) rotateY(${xPercent}deg)`;
                });
                
                card.addEventListener('mouseleave', () => {
                    // Restaura a posição original com a classe correta
                    if (card.classList.contains('featured')) {
                        card.style.transform = 'scale(1.05) translateZ(30px)';
                    } else {
                        card.style.transform = 'translateZ(0)';
                    }
                });
            }
        });
        
        // Anima os elementos ao entrar na viewport
        const observeElements = () => {
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.2 });
            
            document.querySelectorAll('.animate-in:not(.visible)').forEach(el => {
                observer.observe(el);
            });
        };
        
        // Inicia a observação para animações de entrada
        if ('IntersectionObserver' in window) {
            observeElements();
        } else {
            // Fallback para navegadores sem suporte a IntersectionObserver
            document.querySelectorAll('.animate-in').forEach(el => {
                el.classList.add('visible');
            });
        }
        
        // Filtragem dos planos por tipo de pagamento
        const filterButtons = document.querySelectorAll('.payment-filter-btn');
        const plansGrid = document.querySelector('.plans-grid');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                const filter = button.getAttribute('data-filter');
                
                // Atualiza o estado ativo dos botões
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Adiciona classe de animação para transição suave
                plansGrid.style.opacity = '0.6';
                
                setTimeout(() => {
                    // Filtra os planos
                    if (filter === 'todos') {
                        plansGrid.querySelectorAll('.plan-card').forEach(card => {
                            card.style.display = 'block';
                            setTimeout(() => card.style.opacity = '1', 50);
                        });
                    } else {
                        plansGrid.querySelectorAll('.plan-card').forEach(card => {
                            const isVisible = card.getAttribute('data-payment') === filter;
                            if (isVisible) {
                                card.style.display = 'block';
                                setTimeout(() => card.style.opacity = '1', 50);
                            } else {
                                card.style.opacity = '0';
                                setTimeout(() => card.style.display = 'none', 300);
                            }
                        });
                    }
                    
                    // Restaura a opacidade do grid
                    setTimeout(() => {
                        plansGrid.style.opacity = '1';
                    }, 300);
                }, 200);
                
                // Exibe mensagem quando não houver planos com o filtro selecionado
                setTimeout(() => {
                    const visibleCards = plansGrid.querySelectorAll('.plan-card[style*="display: block"]');
                    const noResultsMessage = document.querySelector('.no-results-message');
                    
                    if (visibleCards.length === 0 && !noResultsMessage) {
                        const message = document.createElement('div');
                        message.className = 'no-results-message plan-alert plan-alert-info';
                        message.innerHTML = `
                            <i class="fas fa-info-circle"></i>
                            <span>Nenhum plano disponível para o tipo de pagamento selecionado.</span>
                        `;
                        plansGrid.appendChild(message);
                    } else if (visibleCards.length > 0 && noResultsMessage) {
                        noResultsMessage.remove();
                    }
                }, 500);
            });
        });
    });
</script>
@endpush
