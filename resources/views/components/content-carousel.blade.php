<!-- resources/views/components/content-carousel.blade.php -->
<section class="continue-watching">
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
                @forelse($items as $item)
                    <div class="content-card" 
                         data-id="{{ $item->id ?? '0' }}" 
                         data-title="{{ $item->title }}"
                         data-duration="{{ $item->remaining_time ?? '1:30:00' }}"
                         data-viewers="{{ $item->viewers ?? '1.2K' }}"
                         data-progress="{{ $item->progress ?? 50 }}">
                        <img src="{{ asset($item->thumbnail) }}" alt="{{ $item->title }}">
                        <div class="content-overlay">
                            <h3>{{ $item->title }}</h3>
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
                    <!-- Cards de placeholder quando não há dados -->
                    @for($i = 0; $i < 5; $i++)
                        <div class="content-card skeleton" aria-hidden="true"></div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>