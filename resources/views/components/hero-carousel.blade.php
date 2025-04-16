<section class="hero" aria-label="Destaques">
    <div class="hero-slides">
        @forelse($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" 
                 data-title="{{ $slide->title }}" 
                 data-description="{{ $slide->description }}" 
                 data-date="{{ $slide->date }}"
                 style="background-image: url('{{ asset($slide->image) }}')">
                <!-- Imagem inserida como background-image via CSS -->
            </div>
        @empty
            <!-- Slide padrão se não houver dados -->
            <div class="hero-slide active" 
                 data-title="Conteúdo Premium" 
                 data-description="Experimente o melhor conteúdo premium da plataforma." 
                 data-date="Premium"
                 style="background-image: url('{{ asset('images/hero/default.jpg') }}')">
            </div>
        @endforelse
    </div>
    <div class="hero-content">
        <div class="hero-metadata">
            <span class="date">{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->date : 'Premium' }}</span>
            <span class="vip-badge">VIP</span>
        </div>
        <h1>{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->title : 'Conteúdo Premium' }}</h1>
        <p class="hero-description">{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->description : 'Descubra experiências exclusivas em nossa plataforma.' }}</p>
        <div class="hero-buttons">
            <button class="btn-primary cta open-hero-modal" data-slide-index="0">
                <i class="lucide-play" aria-hidden="true"></i> {{ $heroSlides->isNotEmpty() ? $heroSlides[0]->cta_text : 'Assistir Agora' }}
            </button>
            <button class="btn-secondary open-hero-modal" data-slide-index="0">
                <i class="lucide-crown" aria-hidden="true"></i> Conteúdo VIP
            </button>
        </div>
    </div>
</section>

