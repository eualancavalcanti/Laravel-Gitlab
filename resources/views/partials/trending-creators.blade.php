<!-- resources/views/partials/trending-creators.blade.php -->
<section class="hb-trending-creators">
    <div class="section-container">
        <div class="section-header premium-header">
            <h2><i class="lucide-diamond" aria-hidden="true"></i> Criadores Premium</h2>
            <p class="section-tagline">Conteúdo Exclusivo & VIP</p>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Criadores anteriores"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximos criadores"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>
        
        <div class="carousel-container">
            <div class="hb-creators-carousel">                @forelse($creators as $creator)
                    <div class="hb-creator-card-premium">
                        <!-- Badge Exclusivo/VIP no topo do card -->
                        <div class="hb-premium-badges">
                            @if($creator->conteudos_individuais_count > 0)
                                <span class="hb-exclusive-badge">Exclusivo</span>
                            @endif
                            @if($creator->associador_cenas_count > 0)
                                <span class="hb-vip-badge">VIP</span>
                            @endif
                        </div>
                        
                        <!-- Imagem de fundo com overlay gradiente -->
                        <div class="hb-creator-banner" style="background-image: url('{{ $creator->background_image ?? 'https://server2.hotboys.com.br/arquivos/default-banner.jpg' }}')">
                            <div class="hb-creator-overlay"></div>
                        </div>
                          <!-- Conteúdo principal -->
                        <div class="hb-creator-main-content">
                            <!-- Foto de perfil com badge de verificação -->
                            <div class="hb-creator-profile">
                                <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="hb-profile-link">
                                    <div class="hb-profile-photo">
                                        <img src="{{ $creator->image }}" alt="{{ $creator->nome }}" onerror="this.onerror=null; this.src='/images/placeholder-profile.jpg'; this.classList.add('fallback-image');">
                                        @if($creator->exclusivos == 'Sim')
                                            <span class="hb-verified-badge">
                                                <i class="lucide-badge-check"></i>
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                <div class="hb-creator-info">
                                    <h3>{{ $creator->nome }}</h3>
                                    <span class="hb-creator-role">Modelo Premium</span>
                                </div>
                            </div>
                              <!-- Métricas do criador -->
                            <div class="hb-creator-metrics">
                                <div class="hb-metric">
                                    <i class="lucide-video"></i>
                                    <span>{{ $creator->conteudos_individuais_count ?? 0 }} <small>vídeos</small></span>
                                </div>
                                <div class="hb-metric hb-vip">
                                    <i class="lucide-film"></i>
                                    <span>{{ $creator->associador_cenas_count ?? 0 }} <small>VIP</small></span>
                                </div>
                                <div class="hb-metric hb-trending">
                                    <i class="lucide-flame"></i>
                                    <span>Hot</span>
                                </div>
                            </div>
                            
                            <!-- Botão de ação -->
                            <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="hb-creator-action-btn">
                                <span>Ver Conteúdo Premium</span>
                                <i class="lucide-chevron-right"></i>
                            </a>
                        </div>
                    </div>                @empty
                    <!-- Cards de placeholder quando não há dados -->
                    @for($i = 0; $i < 5; $i++)
                        <div class="hb-creator-card-premium hb-skeleton" aria-hidden="true">
                            <div class="hb-creator-banner">
                                <div class="hb-creator-overlay"></div>
                            </div>
                            <div class="hb-creator-main-content">
                                <div class="hb-creator-profile">
                                    <div class="hb-profile-photo hb-skeleton-circle"></div>
                                    <div class="hb-creator-info">
                                        <div class="hb-skeleton-line"></div>
                                        <div class="hb-skeleton-line hb-sm"></div>
                                    </div>
                                </div>
                                <div class="hb-creator-metrics">
                                    <div class="hb-metric hb-skeleton-pill"></div>
                                    <div class="hb-metric hb-skeleton-pill"></div>
                                </div>
                                <div class="hb-skeleton-button"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>