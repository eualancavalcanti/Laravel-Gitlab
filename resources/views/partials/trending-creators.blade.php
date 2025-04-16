<section class="trending-creators">
    <div class="section-container">
        <h2><i class="lucide-trending-up" aria-hidden="true"></i> Criadores do Momento</h2>
        <div class="creators-grid">
            @forelse($creators as $creator)
                <div class="creator-card">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 120px; background-image: url('{{ asset($creator->image) }}'); background-size: cover; z-index: 1;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(18,18,18,0.4), var(--card-bg))"></div>
</div>
                <div class="creator-header-bg" style="background-image: url('{{ asset($creator->image) }}')">
                    <div class="creator-header-overlay"></div>
                </div>
                    <div class="creator-image" style="background-image: url('{{ asset($creator['image']) }}')">
                        <div class="creator-badges">
                            @if($creator['verified'])
                                <span class="badge verified">
                                    <i class="lucide-badge-check"></i>
                                </span>
                            @endif
                            
                            @if($creator['trending'])
                                <span class="badge trending">
                                    <i class="lucide-trending-up"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                    <h3>{{ $creator['name'] }}</h3>
                    <p class="creator-role">{{ $creator['role'] }}</p>
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="lucide-users"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator->followers }}</span>
                                <span class="stat-label">Seguidores</span>
                            </div>
                        </div>
                        <div class="stat">
                            <i class="lucide-heart"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator->likes }}</span>
                                <span class="stat-label">Likes</span>
                            </div>
                        </div>
                    </div>
                    <button class="btn-primary">
                        <i class="lucide-plus"></i> Seguir
                    </button>
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