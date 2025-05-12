<section class="hb-hero" aria-label="Destaques">
    <div class="hb-hero-slides">        @forelse($heroSlides as $index => $slide)
            <div class="hb-hero-slide {{ $index === 0 ? 'active' : '' }}" 
                 data-title="{{ $slide->title }}" 
                 data-description="{{ $slide->description }}" 
                 data-date="{{ $slide->date }}"
                 data-cta-text="{{ $slide->cta_text }}"
                 data-cta-link="{{ $slide->cta_link }}"
                 data-video-id="{{ $slide->video_id }}"
                 data-image-url="{{ $slide->full_image_url ?? 'https://server2.hotboys.com.br/arquivos/' . $slide->image }}"
                 data-image-type="{{ $slide->image_type ?? 'unknown' }}"
                 data-fallback-url="{{ asset('images/hero/default.jpg') }}">
                <!-- Imagem será carregada via JavaScript para melhor tratamento de erros -->
            </div>
        @empty            <!-- Slide padrão se não houver dados -->
            <div class="hb-hero-slide active" 
                 data-title="Conteúdo Premium" 
                 data-description="Experimente o melhor conteúdo premium da plataforma." 
                 data-date="Premium"
                 data-cta-text="Assistir Agora"
                 data-cta-link="#"
                 data-video-id=""
                 data-image-url="{{ asset('images/hero/default.jpg') }}"
                 data-image-type="default"
                 data-fallback-url="{{ asset('images/hero/default.jpg') }}">   
            </div>
        @endforelse    </div>
    <div class="hb-hero-content">
        <div class="hb-hero-metadata">
            <span class="hb-date">{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->date : 'Premium' }}</span>
            <span class="hb-vip-badge">VIP</span>
        </div>        <h1>{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->title : 'Conteúdo Premium' }}</h1>
        <p class="hb-hero-description">{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->description : 'Descubra experiências exclusivas em nossa plataforma.' }}</p>
        <div class="hb-hero-buttons">
    <button class="btn-primary cta open-video-modal" 
            data-video-id="{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->video_id : '' }}"
            data-title="{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->title : 'Conteúdo Premium' }}"
            data-thumbnail="{{ $heroSlides->isNotEmpty() ? $heroSlides[0]->full_image_url ?? 'https://server2.hotboys.com.br/arquivos/' . $heroSlides[0]->image : asset('images/hero/default.jpg') }}">
        <i class="lucide-play" aria-hidden="true"></i> {{ $heroSlides->isNotEmpty() ? $heroSlides[0]->cta_text : 'Assistir Agora' }}
    </button>
    <button class="btn-secondary">
        <i class="lucide-crown" aria-hidden="true"></i> Conteúdo VIP
    </button>
</div>
    </div>    <!-- Os indicadores serão adicionados via JavaScript se não existirem -->
    @if($heroSlides->count() > 1)
    <div class="hb-hero-indicators">
        @foreach($heroSlides as $index => $slide)
            <div class="hb-indicator {{ $index === 0 ? 'active' : '' }}"></div>
        @endforeach
    </div>
    @endif
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {    // Função para lidar com carregamento de imagens na vitrine principal
    const heroSlides = document.querySelectorAll('.hb-hero-slide');
    console.log('Iniciando carregamento de imagens para ' + heroSlides.length + ' slides');
    
    heroSlides.forEach((slide, index) => {
        const imageUrl = slide.getAttribute('data-image-url');
        const fallbackUrl = slide.getAttribute('data-fallback-url');
        const imageType = slide.getAttribute('data-image-type');
        const title = slide.getAttribute('data-title');
        
        console.log(`Slide ${index + 1}: "${title}" - Tipo: ${imageType}`);
        console.log(`Slide ${index + 1}: Tentando carregar imagem: ${imageUrl}`);
        
        // Tentar carregar a imagem principal
        const img = new Image();
        img.onload = function() {
            console.log(`Slide ${index + 1}: Imagem carregada com sucesso: ${imageUrl}`);
            slide.style.backgroundImage = `url('${imageUrl}')`;
            slide.classList.add('loaded');
            slide.classList.add(`image-${imageType}`);
        };
        img.onerror = function() {
            // Em caso de erro, usar a imagem de fallback
            console.log(`Slide ${index + 1}: Erro ao carregar imagem. Usando fallback: ${fallbackUrl}`);
            slide.style.backgroundImage = `url('${fallbackUrl}')`;
            slide.classList.add('fallback');
        };
        img.src = imageUrl;
    });
    
    // Adicionar um pouco de diagnóstico
    console.log('Informações de diagnóstico da vitrine principal:');
    if (heroSlides.length === 0) {
        console.warn('Nenhum slide encontrado na vitrine principal');
    } else {
        console.log(`Total de slides: ${heroSlides.length}`);
        
        // Verificar os títulos para diagnóstico
        const titles = Array.from(heroSlides).map(slide => slide.getAttribute('data-title'));
        console.log('Títulos dos slides:', titles);
    }
});
</script>