<!-- resources/views/components/content-carousel.blade.php -->
@php
    // Gerar um ID único para este carrossel
    $carouselId = 'carousel-' . md5(uniqid($title ?? 'default', true));
@endphp

<section class="hb-continue-watching" id="{{ $carouselId }}">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-play-circle" aria-hidden="true"></i> {{ $title ?? 'Conteúdo em Destaque' }}</h2>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Conteúdo anterior"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximo conteúdo"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="carousel-container">
            <div class="hb-content-grid">            @forelse($watchingItems ?? [] as $key => $item)
                <!-- Card de conteúdo otimizado para abrir o modal de vídeo -->
                <div class="hb-content-card" 
                    data-video-id="{{ $item->video_id ?? '' }}"
                    data-title="{{ $item->title ?? '' }}" 
                    data-thumbnail="{{ $item->thumbnail ?? '' }}"
                    data-teaser-code="{{ $item->teaser_code ?? '' }}"
                    data-duration="{{ $item->remaining_time ?? '1:30:00' }}"
                    data-type="{{ isset($item->is_vip) && $item->is_vip ? 'vip' : (isset($item->is_exclusive) && $item->is_exclusive ? 'exclusive' : 'standard') }}">
                      <a href="#" class="hb-content-card-link" 
                       data-video-id="{{ $item->video_id ?? '' }}"
                       data-title="{{ $item->title ?? '' }}"
                       data-thumbnail="{{ $item->thumbnail ?? '' }}"
                       data-teaser-code="{{ $item->teaser_code ?? '' }}"
                       data-duration="{{ $item->remaining_time ?? '1:30:00' }}">
                        
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
                          <div class="hb-content-overlay">
                            <h3 class="hb-content-title">{{ $item->title ?? '' }}</h3>
                            <span class="hb-content-duration">{{ $item->remaining_time ?? '1:30:00' }}</span>
                            
                            @if(isset($item->is_vip) && $item->is_vip)
                                <span class="hb-content-badge vip">VIP</span>
                            @endif
                            
                            @if(isset($item->is_exclusive) && $item->is_exclusive)
                                <span class="hb-content-badge exclusive">Exclusivo</span>
                            @endif                        </div>
                        
                        <div class="hb-watching-info">
                            <i class="lucide-users"></i>
                            <span class="hb-viewers-count">{{ $item->viewers ?? '1.2K' }}</span>
                        </div>
                        
                        <div class="hb-content-progress">
                            <div class="hb-progress-bar" style="--progress: {{ $item->progress ?? 50 }}%"></div>
                        </div>
                        
                        <div class="hb-play-overlay">
                            <button class="hb-play-icon" aria-label="Assistir vídeo">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide-play">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </button>
                        </div>
                    </a>                </div>
            @empty
                <div class="hb-empty-state">
                    <p>Nenhum conteúdo disponível no momento.</p>
                </div>
            @endforelse
            </div>
        </div>
    </div>
</section>