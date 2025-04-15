<section class="trending-creators">
    <div class="section-container">
        <h2><i class="lucide-trending-up" aria-hidden="true"></i> Criadores do Momento</h2>
        <div class="creators-grid">
            @forelse($creators as $creator)
                <div class="creator-card">
                    <div class="creator-header">
                        <div class="creator-image" style="background-image: url('{{ asset($creator->image) }}')">
                            @if($creator->verified)
                                <span class="verified-badge">
                                    <i class="lucide-badge-check"></i>
                                </span>
                            @endif
                        </div>
                        <div class="creator-info">
                            <h3>{{ $creator->name }}</h3>
                            <span class="creator-role">{{ $creator->role }}</span>
                        </div>
                    </div>
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