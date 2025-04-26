<section class="hero" aria-label="Destaques">
    <div class="hero-slides">
        @forelse($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'active' : '' }}" 
                 data-title="{{ $slide->title }}" 
                 data-description="{{ $slide->description }}" 
                 data-date="{{ $slide->date }}"
                 data-cta-text="{{ $slide->cta_text }}"
                 data-cta-link="{{ $slide->cta_link }}"
                 style="background-image: url('https://server2.hotboys.com.br/arquivos/{{ $slide->image }}')">
                <!-- Imagem inserida como background-image via CSS -->
            </div>
        @empty
            <!-- Slide padrão se não houver dados -->
            <div class="hero-slide active" 
                 data-title="Conteúdo Premium" 
                 data-description="Experimente o melhor conteúdo premium da plataforma." 
                 data-date="Premium"
                 data-cta-text="Assistir Agora"
                 data-cta-link="#"
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
    <button class="btn-primary cta open-video-modal" 
            data-video-id="{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->video_id : '' }}"
            data-title="{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->title : 'Conteúdo Premium' }}"
            data-thumbnail="{{ $heroSlides->isNotEmpty() ? asset($heroSlides[0]->image) : asset('images/hero/default.jpg') }}">
        <i class="lucide-play" aria-hidden="true"></i> {{ $heroSlides->isNotEmpty() ? $heroSlides[0]->cta_text : 'Assistir Agora' }}
    </button>
    <button class="btn-secondary">
        <i class="lucide-crown" aria-hidden="true"></i> Conteúdo VIP
    </button>
</div>
    </div>
    <!-- Os indicadores serão adicionados via JavaScript se não existirem -->
    @if($heroSlides->count() > 1)
    <div class="hero-indicators">
        @foreach($heroSlides as $index => $slide)
            <div class="indicator {{ $index === 0 ? 'active' : '' }}"></div>
        @endforeach
    </div>
    @endif
</section>