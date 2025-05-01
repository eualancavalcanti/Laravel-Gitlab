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
                        <a href="{{ route('creator.profile', ['username' => ($actor->nome_usuario ? ltrim($actor->nome_usuario, '@') : strtolower(str_replace(' ', '', $actor->nome)))]) }}" class="actor-link">
                            <div class="actor-image" style="background-image: url('https://server2.hotboys.com.br/arquivos/{{ $actor->foto_principal }}')">
                                <div class="actor-tags">
                                    @if(!empty($actor->tag_principal))
                                        <span class="tag">{{ $actor->tag_principal }}</span>
                                    @endif
                                    @if(!empty($actor->tipo_modelo))
                                        <span class="tag">{{ $actor->tipo_modelo }}</span>
                                    @endif
                                </div>
                            </div>
                            <h3>{{ $actor->nome }}</h3>
                            <div class="actor-stats">
                                <span>{{ $actor->idade ?? 0 }} Anos</span>
                                <span>{{ $actor->visualizacao ?? '0' }} Visualizações</span>
                                <span>{{ $actor->penis ?? '0' }} cm</span>
                            </div>
                        </a>
                        <a href="{{ route('creator.profile', ['username' => ($actor->nome_usuario ? ltrim($actor->nome_usuario, '@') : strtolower(str_replace(' ', '', $actor->nome)))]) }}" class="btn-primary">
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