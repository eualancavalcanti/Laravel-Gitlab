<!-- resources/views/components/actors-carousel.blade.php -->
<section class="featured-actors">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-users" aria-hidden="true"></i> {{ $title ?? 'Atores em Destaque' }}</h2>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Ator anterior"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximo ator"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="carousel-container">
            <div class="actors-carousel">
                @forelse($actors as $actor)
                    <div class="actor-card">
                        <a href="{{ route('creator.profile', ['username' => $actor->username ?? strtolower(str_replace(' ', '', $actor->name))]) }}" class="actor-link">
                            <div class="actor-image" style="background-image: url('{{ $actor->image }}')">
                                <div class="actor-tags">
                                    @foreach($actor->tags as $tag)
                                        <span class="tag">{{ is_object($tag) ? $tag->name : $tag }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <h3>{{ $actor->name }}</h3>
                            <div class="actor-stats">
                                <span>{{ $actor->videos ?? 0 }} Vídeos</span>
                                <span>{{ $actor->followers ?? '0' }} Seguidores</span>
                                <span>{{ $actor->rating ?? '0.0' }} ⭐</span>
                            </div>
                        </a>
                        <a href="{{ route('creator.profile', ['username' => $actor->username ?? strtolower(str_replace(' ', '', $actor->name))]) }}" class="btn-primary">
                            Ver Perfil
                        </a>
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