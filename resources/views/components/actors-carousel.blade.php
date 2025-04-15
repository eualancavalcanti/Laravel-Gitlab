<section class="featured-actors">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-users" aria-hidden="true"></i> {{ $title ?? 'Atores em Destaque' }}</h2>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Atores anteriores"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximos atores"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="carousel-container">
            <div class="actors-carousel">
                @forelse($actors as $actor)
                    <div class="actor-card">
                        <div class="actor-image" style="background-image: url('{{ asset($actor->image) }}')">
                            <div class="actor-tags">
                                @foreach($actor->tags as $tag)
                                    <span class="tag">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <h3>{{ $actor->name }}</h3>
                        <div class="actor-stats">
                            <span>{{ $actor->videos }} Vídeos</span>
                            <span>{{ $actor->followers }} Seguidores</span>
                            <span>{{ $actor->rating }} ⭐</span>
                        </div>
                        <button class="btn-primary">Ver Conteúdo</button>
                    </div>
                @empty
                    <!-- Cards de placeholder quando não há dados -->
                    @for($i = 0; $i < 5; $i++)
                        <div class="actor-card skeleton" aria-hidden="true"></div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>