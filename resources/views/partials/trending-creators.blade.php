<!-- resources/views/partials/trending-creators.blade.php -->
<section class="trending-creators">
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
            <div class="creators-carousel">
                @forelse($creators as $creator)
                    <div class="creator-card-premium">
                        <!-- Badge Exclusivo/VIP no topo do card -->
                        <div class="premium-badges">
                            @if($creator->conteudos_individuais_count > 0)
                                <span class="exclusive-badge">Exclusivo</span>
                            @endif
                            @if($creator->associador_cenas_count > 0)
                                <span class="vip-badge">VIP</span>
                            @endif
                        </div>
                        
                        <!-- Imagem de fundo com overlay gradiente -->
                        <div class="creator-banner" style="background-image: url('{{ $creator->background_image ?? 'https://server2.hotboys.com.br/arquivos/default-banner.jpg' }}')">
                            <div class="creator-overlay"></div>
                        </div>
                        
                        <!-- Conteúdo principal -->
                        <div class="creator-main-content">
                            <!-- Foto de perfil com badge de verificação -->
                            <div class="creator-profile">
                                <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="profile-link">
                                    <div class="profile-photo" style="background-image: url('{{ $creator->image }}')">
                                        @if($creator->exclusivos == 'Sim')
                                            <span class="verified-badge">
                                                <i class="lucide-badge-check"></i>
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <div class="creator-details">
                                    <h3 class="creator-name">
                                        <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}">
                                            {{ $creator->nome }}
                                        </a>
                                    </h3>
                                    <div class="creator-info">
                                        <span class="creator-role">{{ $creator->tipo_modelo ?? 'Modelo' }}</span>
                                        <span class="creator-age">{{ $creator->idade ?? '18' }} anos</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Estatísticas do criador -->
                            <div class="creator-metrics">
                                <div class="metric exclusive">
                                    <i class="lucide-lock"></i>
                                    <span>{{ $creator->conteudos_individuais_count ?? 0 }} <small>Exclusivos</small></span>
                                </div>
                                <div class="metric vip">
                                    <i class="lucide-film"></i>
                                    <span>{{ $creator->associador_cenas_count ?? 0 }} <small>VIP</small></span>
                                </div>
                                <div class="metric trending">
                                    <i class="lucide-flame"></i>
                                    <span>Hot</span>
                                </div>
                            </div>
                            
                            <!-- Botão de ação -->
                            <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="creator-action-btn">
                                <span>Ver Conteúdo Premium</span>
                                <i class="lucide-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Cards de placeholder quando não há dados -->
                    @for($i = 0; $i < 4; $i++)
                        <div class="creator-card-premium skeleton" aria-hidden="true">
                            <div class="skeleton-banner"></div>
                            <div class="skeleton-content">
                                <div class="skeleton-profile"></div>
                                <div class="skeleton-details">
                                    <div class="skeleton-line"></div>
                                    <div class="skeleton-line short"></div>
                                </div>
                                <div class="skeleton-metrics"></div>
                                <div class="skeleton-button"></div>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>