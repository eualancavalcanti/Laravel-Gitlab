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
                        <a href="{{ route('creator.profile', ['username' => $creator->username ?? strtolower(str_replace(' ', '', $creator->name))]) }}" class="creator-image-link">
                            <div class="creator-image" style="background-image: url('{{ $creator->image }}')">
                                @if($creator->verified)
                                    <span class="verified-badge">
                                        <i class="lucide-badge-check"></i>
                                    </span>
                                @endif
                            </div>
                        </a>
                        <div class="creator-info">
                            <h3>
                                <a href="{{ route('creator.profile', ['username' => $creator->username ?? strtolower(str_replace(' ', '', $creator->name))]) }}">
                                    {{ $creator->name }}
                                </a>
                            </h3>
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
                    
                    <a href="{{ route('creator.profile', ['username' => $creator->username ?? strtolower(str_replace(' ', '', $creator->name))]) }}" class="btn-primary">
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