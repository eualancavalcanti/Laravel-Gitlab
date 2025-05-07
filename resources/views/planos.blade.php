@extends('layouts.app')

@section('title', 'Planos e Assinaturas - HotBoys')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/planos-dark-2023.css') }}">
@endpush

@section('content')
<div class="planos-container">
    <!-- Banner Hero -->
    <section class="planos-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1>Assine o <span>HotBoys</span></h1>
                    <p class="lead">Acesso ilimitado ao melhor conteúdo premium da plataforma</p>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <span class="badge">
                            <i class="fas fa-fire"></i> Mais de 800 vídeos
                        </span>
                        <span class="badge">
                            <i class="fas fa-plus"></i> Atualizado semanalmente
                        </span>
                        <span class="badge">
                            <i class="fas fa-lock"></i> Acesso exclusivo
                        </span>
                        <span class="badge">
                            <i class="fas fa-video"></i> 4K Ultra HD
                        </span>
                    </div>
                    <a href="#planos-section" class="btn btn-danger">
                        Ver planos disponíveis <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="bg-dark rounded-3 shadow-lg d-flex align-items-center justify-content-center position-relative overflow-hidden" style="height: 300px;">
                        <div class="position-absolute w-100 h-100" style="background: radial-gradient(circle at center, rgba(255, 0, 51, 0.2) 0%, transparent 70%);"></div>
                        <i class="fas fa-photo-video fa-4x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Informações de Debug - Visível apenas em ambiente de desenvolvimento -->
    @if(isset($debug) && config('app.env') != 'production')
    <div class="debug-panel bg-dark text-white p-3 mb-4">
        <div class="container">
            <h5 class="text-warning">Informações de Debug</h5>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-group list-group-flush bg-dark">
                        <li class="list-group-item bg-dark text-white border-secondary">Total de Planos: {{ $debug['total_planos'] }}</li>
                        <li class="list-group-item bg-dark text-white border-secondary">Categorias: {{ $debug['categorias'] }}</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Primeiro Plano:</label>
                        <textarea class="form-control bg-dark text-white" rows="4" readonly>{{ $debug['primeiro_plano'] }}</textarea>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <h6 class="text-light">Planos por Período:</h6>
                    <ul class="list-group list-group-flush bg-dark">
                        @forelse($planosPorPeriodo as $periodo => $planosPeriodo)
                            <li class="list-group-item bg-dark text-white border-secondary">
                                {{ ucfirst($periodo) }}: {{ count($planosPeriodo) }} plano(s)
                            </li>
                        @empty
                            <li class="list-group-item bg-dark text-white border-secondary">Nenhum período encontrado</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Vantagens -->
    <section class="vantagens">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white">Por que assinar o <span class="text-danger">HotBoys</span>?</h2>
                <p class="lead text-light-muted">Confira todas as vantagens de ser um assinante</p>
            </div>

            <div class="row g-4">
                @foreach($vantagens as $vantagem)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon mx-auto">
                                <i class="fas {{ $vantagem['icone'] }}"></i>
                            </div>
                            <h4 class="fw-bold mb-3 text-white">{{ $vantagem['titulo'] }}</h4>
                            <p class="text-light-muted mb-0">{{ $vantagem['descricao'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Lista de Planos -->
    <section id="planos-section" class="planos">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white">Escolha seu plano</h2>
                <p class="lead text-light-muted">Temos opções que cabem no seu bolso</p>
            </div>

            <!-- Botões de filtro por tipo de pagamento -->
            <div class="tipo-pagamento-filter mb-4 text-center">
                <div class="btn-group" role="group" aria-label="Filtro por tipo de pagamento">
                    <button type="button" class="btn btn-outline-light active" data-filter="todos">Todos</button>
                    <button type="button" class="btn btn-outline-light" data-filter="pix">
                        <i class="fas fa-exchange-alt me-1"></i> PIX
                    </button>
                    <button type="button" class="btn btn-outline-light" data-filter="cartao">
                        <i class="fas fa-credit-card me-1"></i> Cartão
                    </button>
                </div>
            </div>

            <!-- Tabs para tipos de período -->
            <ul class="nav nav-pills" id="planosTab" role="tablist">
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
                        <div class="col plano-item" data-tipo-pagamento="{{ $plano->tipo_pagamento }}">
                            <div class="card h-100 plano-card {{ isset($plano->destaque) && $plano->destaque ? 'plano-destaque' : '' }} {{ isset($plano->popular) && $plano->popular ? 'plano-popular' : '' }}">
                                @if(isset($plano->destaque) && $plano->destaque)
                                <div class="destaque-badge">
                                    <span>Destaque</span>
                                </div>
                                @endif
                                
                                @if(isset($plano->popular) && $plano->popular)
                                <div class="popular-badge">
                                    <span>Mais Popular</span>
                                </div>
                                @endif
                                
                                <div class="card-header text-center py-3 border-0 bg-transparent">
                                    <h5 class="fw-bold mb-0 text-white">{{ $plano->titulo }}</h5>
                                    @if(isset($plano->subtitulo) && $plano->subtitulo)
                                    <p class="text-light-muted small mb-0">{{ $plano->subtitulo }}</p>
                                    @endif
                                </div>
                                <div class="card-body text-center">
                                    @if(isset($plano->preco_promocional) && $plano->preco_promocional && isset($plano->promocao) && $plano->promocao)
                                    <p class="text-light-muted text-decoration-line-through mb-1">
                                        R$ {{ number_format($plano->preco, 2, ',', '.') }}
                                    </p>
                                    <h2 class="card-price mb-1">
                                        R$ {{ number_format($plano->preco_promocional, 2, ',', '.') }}
                                    </h2>
                                    <p class="economia-texto">
                                        Economia de R$ {{ number_format($plano->preco - $plano->preco_promocional, 2, ',', '.') }}
                                    </p>
                                    @else
                                    <h2 class="card-price mb-1">
                                        R$ {{ number_format($plano->preco, 2, ',', '.') }}
                                    </h2>
                                    @endif

                                    <p class="text-light-muted small mb-4">
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

                                    <div class="text-start text-light">
                                        <div class="mb-3">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-calendar-check text-danger me-2"></i>
                                                <span>Acesso por {{ $plano->duracao_dias }} dias</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-{{ $plano->tipo_pagamento == 'cartao' ? 'credit-card' : ($plano->tipo_pagamento == 'boleto' ? 'barcode' : ($plano->tipo_pagamento == 'pix' ? 'exchange-alt' : 'university')) }} text-danger me-2"></i>
                                                <span>Pagamento via {{ ucfirst($plano->tipo_pagamento) }}</span>
                                            </div>
                                            
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-unlock-alt text-danger me-2"></i>
                                                <span>Acesso imediato após confirmação</span>
                                            </div>
                                        </div>

                                        <!-- Recursos do plano se houver -->
                                        @if($plano->recursos)
                                            @php
                                                $recursos = json_decode($plano->recursos, true);
                                            @endphp
                                            @if(is_array($recursos) && count($recursos) > 0)
                                                <hr class="border-secondary">
                                                <div class="pequeno mb-3">
                                                    @foreach($recursos as $recurso)
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fas fa-check text-danger me-2"></i>
                                                            <span>{{ $recurso }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @else
                                            <!-- Recursos padrão quando não existir no plano -->
                                            <hr class="border-secondary">
                                            <div class="pequeno mb-3">
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-check text-danger me-2"></i>
                                                    <span>Acesso a todos os vídeos</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-check text-danger me-2"></i>
                                                    <span>Conteúdo em alta qualidade</span>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="fas fa-check text-danger me-2"></i>
                                                    <span>Acesso em todos os dispositivos</span>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent border-0 pt-0 pb-4">
                                    <a href="{{ route('planos.assinar', $plano->codigo) }}" class="btn btn-{{ isset($plano->destaque) && $plano->destaque ? 'danger' : 'outline-danger' }} btn-lg w-100">
                                        Assinar agora
                                    </a>
                                    @if(isset($plano->descricao_curta) && $plano->descricao_curta)
                                    <p class="small text-center text-light-muted mt-2">
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
    <section class="formas-pagamento">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white">Formas de Pagamento</h2>
                <p class="lead text-light-muted">Escolha a forma que mais te convém</p>
            </div>

            <div class="row g-4">
                @foreach($tiposPagamento as $tipo => $info)
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="pagamento-icon me-3 bg-danger text-white">
                                    <i class="fas {{ $info['icone'] }} fa-lg"></i>
                                </div>
                                <h4 class="fw-bold mb-0 text-white">{{ $info['titulo'] }}</h4>
                            </div>
                            <p class="mb-0 text-light">{{ $info['descricao'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                <div class="p-4 bg-dark-card rounded-3 shadow-custom d-inline-block">
                    <div class="d-flex align-items-center justify-content-center flex-wrap gap-4">
                        <div class="d-flex align-items-center text-light">
                            <i class="fas fa-lock text-danger me-2"></i>
                            <span>Pagamento 100% seguro</span>
                        </div>
                        <div class="d-flex align-items-center text-light">
                            <i class="fas fa-shield-alt text-danger me-2"></i>
                            <span>Seus dados estão protegidos</span>
                        </div>
                        <div class="d-flex align-items-center text-light">
                            <i class="fas fa-credit-card text-danger me-2"></i>
                            <span>Transações criptografadas</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="faq">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold text-white">Perguntas Frequentes</h2>
                <p class="lead text-light-muted">Tire suas dúvidas sobre nossas assinaturas</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item border-0 mb-3">
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

                        <div class="accordion-item border-0 mb-3">
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

                        <div class="accordion-item border-0 mb-3">
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

                        <div class="accordion-item border-0 mb-3">
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

                        <div class="accordion-item border-0">
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
                <p class="mb-3 text-light">Ainda está com dúvidas?</p>
                <a href="{{ route('contact') }}" class="btn btn-outline-danger">
                    <i class="fas fa-headset me-2"></i> Fale com nossa equipe
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Final -->
    <section class="cta-final">
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
                planoCards.forEach(c => {
                    c.classList.remove('hover-focus');
                });
                this.classList.add('hover-focus');
            });
            
            card.addEventListener('mouseleave', function() {
                this.classList.remove('hover-focus');
            });
        });
        
        // Adicionar efeito de entrada com delay para cards
        const animateCards = () => {
            document.querySelectorAll('.plano-card').forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('animate-in');
                }, 100 * index);
            });
            
            document.querySelectorAll('.vantagens .card').forEach((card, index) => {
                setTimeout(() => {
                    card.classList.add('animate-in');
                }, 100 * index);
            });
        };
        
        // Chamar animação quando o conteúdo estiver visível
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCards();
                    observer.disconnect();
                }
            });
        });
        
        observer.observe(document.querySelector('.vantagens'));
    });
    
    // Adicionar classe para animação de entrada
    document.addEventListener('DOMContentLoaded', function() {
        document.body.classList.add('loaded');
    });

    // Filtrar planos por tipo de pagamento
    document.addEventListener('DOMContentLoaded', function() {
        const filtroButtons = document.querySelectorAll('.tipo-pagamento-filter .btn');
        const planoItems = document.querySelectorAll('.plano-item');

        filtroButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');

                // Atualizar estado dos botões
                filtroButtons.forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');

                // Filtrar planos
                planoItems.forEach(item => {
                    if (filterValue === 'todos' || item.getAttribute('data-tipo-pagamento') === filterValue) {
                        item.closest('.col').style.display = 'block';
                    } else {
                        item.closest('.col').style.display = 'none';
                    }
                });
            });
        });
    });

    $(document).ready(function() {
        // Filtro por tipo de pagamento
        $('.tipo-pagamento-filter .btn').on('click', function() {
            const filtro = $(this).data('filter');
            
            // Ativar botão selecionado
            $('.tipo-pagamento-filter .btn').removeClass('active');
            $(this).addClass('active');
            
            // Filtrar planos
            if (filtro === 'todos') {
                $('.plano-item').fadeIn(300);
            } else {
                $('.plano-item').hide();
                $('.plano-item[data-tipo-pagamento="' + filtro + '"]').fadeIn(300);
            }
            
            // Verificar se há planos visíveis em cada tab
            $('.tab-pane').each(function() {
                const tabId = $(this).attr('id');
                const visiblePlans = $(this).find('.plano-item:visible').length;
                
                // Se não houver planos visíveis, exibir mensagem
                if (visiblePlans === 0) {
                    if ($(this).find('.no-plans-message').length === 0) {
                        $(this).append('<div class="no-plans-message alert alert-info mt-4 text-center">Nenhum plano disponível para este tipo de pagamento neste período.</div>');
                    }
                } else {
                    $(this).find('.no-plans-message').remove();
                }
            });
        });
    });
</script>
@endpush
