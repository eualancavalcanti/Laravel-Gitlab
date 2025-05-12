<!-- resources/views/components/actors-carousel.blade.php -->
<section class="hb-featured-actors">
    <div class="section-container">
        <div class="section-header">
            <h2><i class="lucide-users" aria-hidden="true"></i> {{ $title ?? 'Atores em Destaque' }}</h2>
            <div class="carousel-nav">
                <button class="nav-btn prev" aria-label="Atores anteriores"><i class="lucide-chevron-left" aria-hidden="true"></i></button>
                <button class="nav-btn next" aria-label="Próximos atores"><i class="lucide-chevron-right" aria-hidden="true"></i></button>
            </div>
        </div>        <div class="carousel-container">
            <div class="hb-actors-carousel">
                @forelse($actors as $actor)
                    <div class="hb-actor-card">
                        <div class="hb-actor-image">
                            <img src="{{ $actor->image ?? '' }}" 
                                 alt="{{ $actor->name ?? 'Ator' }}" 
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='/images/placeholder-actor.jpg'; this.classList.add('fallback-image');">
                            
                            @if(isset($actor->exclusive) && $actor->exclusive)                                <span class="hb-exclusive-badge">Exclusivo</span>
                            @endif
                            
                            <div class="hb-actor-overlay">
                                <a href="/modelo/{{ strtolower(str_replace(' ', '-', $actor->name ?? 'ator')) }}" class="hb-view-profile-btn">Ver Perfil</a>
                            </div>
                        </div>
                        <div class="hb-actor-info">
                            <h3>{{ $actor->name ?? 'Nome do Ator' }}</h3>
                            <div class="hb-actor-stats">
                                <span><i class="lucide-film" aria-hidden="true"></i> {{ $actor->videos_count ?? 0 }}</span>
                                <span><i class="lucide-gem" aria-hidden="true"></i> {{ $actor->vip_count ?? 0 }}</span>
                                <span><i class="lucide-star" aria-hidden="true"></i> {{ $actor->exclusive_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>                @empty
                    <!-- Cards de placeholder quando não há dados -->
                    @for($i = 0; $i < 5; $i++)
                        <div class="hb-actor-card hb-skeleton" aria-hidden="true"></div>
                    @endfor
                @endforelse
            </div>
        </div>
    </div>
</section>

<style>
    .featured-actors {
        margin: 3rem 0;
    }
    
    .section-header h2 {
        color: #fff;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
      .section-header h2 i {
        color: #e50914;
    }
    
    .hb-actors-carousel {
        display: flex;
        gap: 1.2rem;
        padding: 1rem 0;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    
    .hb-actors-carousel::-webkit-scrollbar {
        display: none;
    }
    
    .hb-actor-card {
        flex: 0 0 200px;
        border-radius: 12px;
        overflow: hidden;
        background: rgba(20, 20, 20, 0.8);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .hb-actor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(229, 9, 20, 0.2);
        border-color: rgba(229, 9, 20, 0.4);
    }
    
    .hb-actor-image {
        position: relative;
        height: 270px;
        overflow: hidden;
    }
      .hb-actor-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .hb-actor-card:hover .hb-actor-image img {
        transform: scale(1.05);
    }
    
    .hb-actor-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0) 60%);
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .hb-actor-card:hover .hb-actor-overlay {
        opacity: 1;
    }
    
    .hb-view-profile-btn {
        background-color: #e50914;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 4px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
        text-decoration: none;
    }
    
    .hb-view-profile-btn:hover {
        background-color: #f50f0f;
    }
    
    .hb-exclusive-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #e50914;
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 4px;
        font-size: 0.7rem;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        z-index: 1;
    }
      .hb-actor-info {
        padding: 1rem;
    }
    
    .hb-actor-info h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: white;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    .hb-actor-stats {
        display: flex;
        justify-content: space-between;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .hb-actor-stats span {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .carousel-nav {
        display: flex;
        gap: 0.5rem;
    }
    
    .nav-btn {
        background: rgba(229, 9, 20, 0.8);
        color: white;
        border: none;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }
    
    .nav-btn:hover {
        background-color: #e50914;    }
    
    /* Placeholder skeleton */
    .hb-skeleton {
        background: linear-gradient(90deg, #222 0%, #333 50%, #222 100%);
        background-size: 200% 100%;
        animation: shine 1.5s infinite;
    }
    
    @keyframes shine {
        to {
            background-position: -200% 0;
        }
    }
    
    @media (max-width: 768px) {
        .hb-actor-card {
            flex: 0 0 160px;
        }
        
        .hb-actor-image {
            height: 220px;
        }
    }
</style>