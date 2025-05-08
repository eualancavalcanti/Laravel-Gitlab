<!-- resources/views/components/content-carousel.blade.php -->
@php
    // Gerar um ID único para este carrossel
    $carouselId = 'carousel-' . md5(uniqid($title ?? 'default', true));
@endphp

<section class="continue-watching" id="{{ $carouselId }}">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-play-circle" aria-hidden="true"></i> {{ $title ?? 'Conteúdo em Destaque' }}</h2>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Conteúdo anterior"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximo conteúdo"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="carousel-container">
            <div class="content-grid">
            @forelse($watchingItems ?? [] as $key => $item)
                <!-- Modificar os cards para abrirem o modal -->
                <div class="content-card open-video-modal"
                    data-video-id="{{ $item->video_id ?? '' }}"
                    data-title="{{ $item->title ?? '' }}"
                    data-thumbnail="{{ $item->thumbnail ?? '' }}">
                    @if($key < 4)
                    {{-- As primeiras 4 imagens são carregadas com prioridade alta --}}
                    <img src="{{ $item->thumbnail ?? '' }}" 
                         alt="{{ $item->title ?? '' }}"
                         fetchpriority="{{ $key < 2 ? 'high' : 'auto' }}"
                         decoding="async"
                         onerror="this.onerror=null; this.src='/images/placeholder-content.jpg'; this.classList.add('fallback-image');">
                    @else
                    {{-- As demais imagens usam lazy loading --}}
                    <img src="{{ $item->thumbnail ?? '' }}" 
                         alt="{{ $item->title ?? '' }}"
                         loading="lazy"
                         decoding="async"
                         onerror="this.onerror=null; this.src='/images/placeholder-content.jpg'; this.classList.add('fallback-image');">
                    @endif
                    <div class="content-overlay">
                        <h3>{{ $item->title ?? '' }}</h3>
                        <span class="duration">{{ $item->remaining_time ?? '1:30:00' }} restantes</span>
                    </div>
                    <div class="watching-info">
                        <i class="lucide-users"></i>
                        {{ $item->viewers ?? '1.2K' }}
                    </div>
                    <div class="content-progress">
                        <div class="progress-bar" style="--progress: {{ $item->progress ?? 50 }}%"></div>
                    </div>
                </div>
            @empty
                <!-- Conteúdo para quando não houver itens -->
                <div class="empty-content">
                    <p>Nenhum conteúdo disponível no momento.</p>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</section>