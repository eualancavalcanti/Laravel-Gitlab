<!-- resources/views/partials/trending-creators.blade.php -->
<section class="trending-creators">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-star" aria-hidden="true"></i> Criadores do Momento</h2>
        </div>
        
        <div class="creators-grid">
            @forelse($creators as $creator)
                <div class="creator-card">
                    <div class="creator-header">
                        <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="creator-image-link">
                            <div class="creator-image" style="background-image: url('https://server2.hotboys.com.br/arquivos/{{ $creator->foto_principal }}')">
                                @if($creator->exclusivos == 'Sim')
                                    <span class="verified-badge">
                                        <i class="lucide-badge-check"></i>
                                    </span>
                                @endif
                            </div>
                        </a>
                        <div class="creator-info">
                            <h3>
                                <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}">
                                    {{ $creator->nome }}
                                </a>
                            </h3>
                            <span class="creator-role">{{ $creator->tipo_modelo ?? 'Modelo' }}</span>
                        </div>
                    </div>
                    
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="lucide-users"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ number_format($creator->visualizacao, 0, ',', '.') }}</span>
                                <span class="stat-label">Visualizações</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-heart"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator->idade ?? '18' }}</span>
                                <span class="stat-label">Anos</span>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('creator.profile', ['username' => $creator->nome_usuario ?? strtolower(str_replace(' ', '', $creator->nome))]) }}" class="btn-primary">
                        <i class="lucide-plus"></i> Seguir
                    </a>
                </div>
            @empty
                <!-- Cards de placeholder quando não há dados -->
                @for($i = 0; $i < 4; $i++)
                    <div class="creator-card skeleton" aria-hidden="true"></div>
                @endfor
            @endforelse
        </div>
    </div>
</section>