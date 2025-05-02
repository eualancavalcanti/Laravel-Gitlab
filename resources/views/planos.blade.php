@extends('layouts.app')

@section('title', 'Planos e Assinaturas - HotBoys')

@section('content')
<div class="planos-container">
    <!-- Banner Hero -->
    <section class="planos-hero bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Assine o <span class="text-danger">HotBoys</span></h1>
                    <p class="lead mb-4">Acesso ilimitado ao melhor conteúdo premium da plataforma</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge bg-danger p-2">
                            <i class="fas fa-fire"></i> Mais de 800 vídeos
                        </span>
                        <span class="badge bg-danger p-2">
                            <i class="fas fa-plus"></i> Conteúdo atualizado semanalmente
                        </span>
                        <span class="badge bg-danger p-2">
                            <i class="fas fa-lock"></i> Acesso exclusivo
                        </span>
                        <span class="badge bg-danger p-2">
                            <i class="fas fa-video"></i> Qualidade 4K Ultra HD
                        </span>
                    </div>
                    <a href="#planos-section" class="btn btn-danger btn-lg px-4 py-2">
                        Ver planos disponíveis <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/assinatura-hero.jpg') }}" alt="Assine HotBoys" class="img-fluid rounded-3 shadow-lg">
                </div>
            </div>
        </div>
    </section>

    <!-- Vantagens -->
    <section class="vantagens py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Por que assinar o <span class="text-danger">HotBoys</span>?</h2>
                <p class="lead text-muted">Confira todas as vantagens de ser um assinante</p>
            </div>

            <div class="row g-4">
                @foreach($vantagens as $vantagem)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm hover-scale">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon bg-danger text-white rounded-circle mb-3 mx-auto">
                                <i class="fas {{ $vantagem['icone'] }} fa-lg"></i>
                            </div>
                            <h4 class="fw-bold mb-3">{{ $vantagem['titulo'] }}</h4>
                            <p class="text-muted mb-0">{{ $vantagem['descricao'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lista de Planos -->
    <section id="planos-section" class="planos py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Escolha seu plano</h2>
                <p class="lead text-muted">Temos opções que cabem no seu bolso</p>
            </div>

            <!-- Tabs para tipos de período -->
            <ul class="nav nav-pills mb-4 justify-content-center" id="planosTab" role="tablist">
                @php $firstTab = true; @endphp
                @foreach($planosPorPeriodo as $periodo => $planosPeriodo)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $firstTab ? 'active' : '' }}" 
                        id="{{ $periodo }}-tab" 
                        data-bs-toggle="tab" 
                        data-bs-target="#{{ $periodo }}-content" 
                        type="button" 
                        role="tab" 
                        aria-controls="{{ $periodo }}-content" 
                        aria-selected="{{ $firstTab ? 'true' : 'false' }}">
                        <i class="fas fa-{{ $periodo == 'mensal' ? 'calendar-day' : ($periodo == 'trimestral' ? 'calendar-week' : ($periodo == 'semestral' ? 'calendar-alt' : 'calendar-check')) }} me-2"></i>
                        {{ ucfirst($periodo) }}
                    </button>
                </li>
                @php $firstTab = false; @endphp
                @endforeach
            </ul>

            <!-- Conteúdo das tabs -->
            <div class="tab-content" id="planosTabContent">
                @php $firstTab = true; @endphp
                @foreach($planosPorPeriodo as $periodo => $planosPeriodo)
                <div class="tab-pane fade {{ $firstTab ? 'show active' : '' }}" 
                    id="{{ $periodo }}-content" 
                    role="tabpanel" 
                    aria-labelledby="{{ $periodo }}-tab">
                    
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($planosPeriodo as $plano)
                        <div class="col">
                            <div class="card h-100 plano-card border-0 shadow {{ $plano->destaque ? 'plano-destaque' : '' }} {{ $plano->popular ? 'plano-popular' : '' }}">
                                @if($plano->destaque)
                                <div class="destaque-badge">
                                    <span>Destaque</span>
                                </div>
                                @endif
                                
                                @if($plano->popular)
                                <div class="popular-badge">
                                    <span>Mais Popular</span>
                                </div>
                                @endif
                                
                                <div class="card-header text-center py-3 border-0">
                                    <h5 class="fw-bold mb-0">{{ $plano->titulo }}</h5>
                                    @if($plano->subtitulo)
                                    <p class="text-muted small mb-0">{{ $plano->subtitulo }}</p>
                                    @endif
                                </div>
                                <div class="card-body text-center">
                                    @if($plano->preco_promocional && $plano->promocao)
                                    <p class="text-muted text-decoration-line-through mb-1">
                                        R$ {{ number_format($plano->preco, 2, ',', '.') }}
                                    </p>
                                    <h2 class="card-price mb-1">
                                        R$ {{ number_format($plano->preco_promocional, 2, ',', '.') }}
                                    </h2>
                                    <p class="economia-texto small">
                                        Economia de R$ {{ number_format($plano->preco - $plano->preco_promocional, 2, ',', '.') }}
                                    </p>
                                    @else
                                    <h2 class="card-price mb-1">
                                        R$ {{ number_format($plano->preco, 2, ',', '.') }}
                                    </h2>
                                    @endif

                                    <p class="text-muted small mb-4">
                                        @if($plano->duracao_dias == 30)
                                            {{ number_format($plano->preco / 30, 2, ',', '.') }} por dia
                                        @elseif($plano->duracao_dias == 90)
                                            {{ number_format($plano->preco / 3, 2, ',', '.') }} por mês
                                        @elseif($plano->duracao_dias == 180)
                                            {{ number_format($plano->preco / 6, 2, ',', '.') }} por mês
                                        @elseif($plano->duracao_dias == 365)
                                            {{ number_format($plano->preco / 12, 2, ',', '.') }} por mês
                                        @else
                                            Acesso por {{ $plano->duracao_dias }} dias
                                        @endif
                                    </p>

                                    <div class="text-start">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-check text-success me-2"></i>
                                                <span>Acesso por {{ $plano->duracao_dias }} dias</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-{{ $plano->tipo_pagamento == 'cartao' ? 'credit-card' : ($plano->tipo_pagamento == 'boleto' ? 'barcode' : ($plano->tipo_pagamento == 'pix' ? 'exchange-alt' : 'university')) }} text-success me-2"></i>
                                                <span>Pagamento via {{ ucfirst($plano->tipo_pagamento) }}</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-unlock-alt text-success me-2"></i>
                                                <span>Acesso imediato após confirmação</span>
                                            </div>
                                        </div>

                                        <!-- Recursos do plano se houver -->
                                        @if($plano->recursos)
                                            @php
                                                $recursos = json_decode($plano->recursos, true);
                                            @endphp
                                            @if(is_array($recursos) && count($recursos) > 0)
                                                <hr>
                                                <div class="pequeno mb-3">
                                                    @foreach($recursos as $recurso)
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-check text-success me-2"></i>
                                                            <span>{{ $recurso }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                                    <a href="{{ route('planos.assinar', $plano->codigo) }}" class="btn btn-{{ $plano->destaque ? 'danger' : 'outline-danger' }} btn-lg w-100">
                                        Assinar agora
                                    </a>
                                    @if($plano->descricao_curta)
                                    <p class="small text-center text-muted mt-2">
                                        {{ $plano->descricao_curta }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @php $firstTab = false; @endphp
                @endforeach
            </div>
        </div>
    </section>

    <!-- Formas de Pagamento -->
    <section class="formas-pagamento py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Formas de Pagamento</h2>
                <p class="lead text-muted">Escolha a forma que mais te convém</p>
            </div>

            <div class="row g-4">
                @foreach($tiposPagamento as $tipo => $info)
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="pagamento-icon me-3 bg-danger text-white">
                                    <i class="fas {{ $info['icone'] }} fa-lg"></i>
                                </div>
                                <h4 class="fw-bold mb-0">{{ $info['titulo'] }}</h4>
                            </div>
                            <p class="mb-0">{{ $info['descricao'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <div class="seguranca-pagamento p-4 bg-white rounded-3 shadow-sm d-inline-block">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-4">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-lock text-success me-2"></i>
                            <span>Pagamento 100% seguro</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt text-success me-2"></i>
                            <span>Seus dados estão protegidos</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fas fa-credit-card text-success me-2"></i>
                            <span>Transações criptografadas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Perguntas Frequentes</h2>
                <p class="lead text-muted">Tire suas dúvidas sobre nossas assinaturas</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1Collapse" aria-expanded="false" aria-controls="faq1Collapse">
                                    Como funciona a assinatura?
                                </button>
                            </h2>
                            <div id="faq1Collapse" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Após realizar o pagamento, você receberá acesso imediato à plataforma. Basta fazer login com seu e-mail e senha para desfrutar de todo o conteúdo disponível.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2Collapse" aria-expanded="false" aria-controls="faq2Collapse">
                                    Posso cancelar minha assinatura?
                                </button>
                            </h2>
                            <div id="faq2Collapse" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Sim, você pode cancelar sua assinatura a qualquer momento diretamente em sua conta. No entanto, não fazemos reembolsos proporcionais de períodos não utilizados.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3Collapse" aria-expanded="false" aria-controls="faq3Collapse">
                                    Qual a diferença entre os planos?
                                </button>
                            </h2>
                            <div id="faq3Collapse" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    A principal diferença entre os planos é a duração da assinatura e a forma de pagamento. Planos mais longos (trimestral, semestral e anual) oferecem melhor custo-benefício. Todos os planos dão acesso ao mesmo conteúdo, exceto os planos Patrocinador que incluem conteúdos exclusivos.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4Collapse" aria-expanded="false" aria-controls="faq4Collapse">
                                    Em quais dispositivos posso assistir?
                                </button>
                            </h2>
                            <div id="faq4Collapse" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Você pode assistir em qualquer dispositivo com acesso à internet, incluindo smartphones, tablets, computadores e smart TVs compatíveis. Nossa plataforma é responsiva e se adapta a diferentes tamanhos de tela.
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item border-0 shadow-sm">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5Collapse" aria-expanded="false" aria-controls="faq5Collapse">
                                    Como aparece na minha fatura?
                                </button>
                            </h2>
                            <div id="faq5Collapse" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    A cobrança aparecerá em sua fatura como "HOTB*CONTEUDO" ou similar, garantindo total discrição.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="mb-3">Ainda está com dúvidas?</p>
                <a href="{{ route('contato') }}" class="btn btn-outline-danger">
                    <i class="fas fa-headset me-2"></i> Fale com nossa equipe
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-final bg-dark text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="fw-bold mb-4">Pronto para começar?</h2>
                    <p class="lead mb-4">Não perca mais tempo. Assine agora e tenha acesso ao melhor conteúdo.</p>
                    <a href="#planos-section" class="btn btn-danger btn-lg px-5 py-3">
                        Escolher meu plano <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <p class="small mt-3">Cancele quando quiser. Sem compromisso.</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    /* Estilos para a página de planos */
    .planos-container {
        overflow-x: hidden;
    }

    .planos-hero {
        background: linear-gradient(135deg, #151515, #380000);
        position: relative;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    /* Estilos dos cards de planos */
    .plano-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .plano-card:hover {
        transform: translateY(-10px);
    }

    .plano-destaque {
        border: 2px solid #dc3545 !important;
    }

    .destaque-badge, .popular-badge {
        position: absolute;
        top: 0;
        right: 0;
        background: #dc3545;
        color: white;
        padding: 5px 15px;
        font-weight: bold;
        font-size: 0.8rem;
        text-transform: uppercase;
        z-index: 10;
    }

    .popular-badge {
        background: #ffc107;
        color: #212529;
    }

    .card-price {
        font-size: 2.5rem;
        font-weight: bold;
        color: #dc3545;
    }

    .economia-texto {
        color: #28a745;
        font-weight: bold;
    }

    /* Tabs de planos */
    .nav-pills .nav-link {
        background-color: transparent;
        color: #6c757d;
        border: 1px solid #dee2e6;
        margin: 0 5px;
        border-radius: 30px;
        padding: 8px 20px;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }

    .nav-pills .nav-link:hover:not(.active) {
        background-color: #f8f9fa;
    }

    /* Ícones de forma de pagamento */
    .pagamento-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Acordeon de FAQ */
    .accordion-button:not(.collapsed) {
        background-color: #ffeaea;
        color: #dc3545;
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(220, 53, 69, 0.25);
    }

    /* Efeito hover */
    .hover-scale {
        transition: transform 0.3s ease;
    }

    .hover-scale:hover {
        transform: scale(1.03);
    }

    /* Media queries para responsividade */
    @media (max-width: 767.98px) {
        .card-price {
            font-size: 2rem;
        }
        
        .nav-pills .nav-link {
            margin-bottom: 5px;
        }
    }

    /* Elementos pequenos */
    .pequeno {
        font-size: 0.85rem;
    }
</style>
@endpush

@push('scripts')
<script>
    // Script para rolagem suave para as âncoras
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Destacar plano ao passar o mouse
        const planoCards = document.querySelectorAll('.plano-card');
        planoCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                planoCards.forEach(c => c.classList.remove('shadow-lg'));
                this.classList.add('shadow-lg');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('shadow-lg');
            });
        });
    });
</script>
@endpush
