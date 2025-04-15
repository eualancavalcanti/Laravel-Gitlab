<!-- resources/views/pages/creators.blade.php -->
@extends('layouts.page')

@section('title', 'Criadores - HotBoys')

@section('page-title', 'Nossos Criadores')

@section('page-content')
    <div class="creators-container">
        <div class="creators-header">
            <div class="creators-search">
                <input type="text" id="creators-search-input" placeholder="Buscar criadores por nome ou categoria">
                <button class="search-btn"><i class="lucide-search"></i></button>
            </div>
            
            <div class="creators-filters">
                <div class="filter-group">
                    <label>Categorias</label>
                    <div class="filter-options">
                        <button class="filter-option active" data-filter="all">Todos</button>
                        <button class="filter-option" data-filter="exclusive">Exclusivos</button>
                        <button class="filter-option" data-filter="trending">Em Alta</button>
                        <button class="filter-option" data-filter="new">Novos</button>
                        <button class="filter-option" data-filter="verified">Verificados</button>
                    </div>
                </div>
                
                <div class="filter-group">
                    <label>Ordenar por</label>
                    <select id="sort-select">
                        <option value="popular">Mais populares</option>
                        <option value="recent">Mais recentes</option>
                        <option value="rating">Melhor avaliados</option>
                        <option value="videos">Mais vídeos</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="creators-grid" id="creators-grid">
            <!-- Cards dos criadores serão inseridos aqui dinamicamente via JS ou loop Blade -->
            
            @forelse($creators as $creator)
                <div class="creator-card" 
                     data-rating="{{ $creator->rating }}" 
                     data-videos="{{ $creator->videos }}" 
                     data-followers="{{ $creator->followers }}"
                     data-tags="{{ $creator->tags->implode('name', ',') }}"
                     data-exclusive="{{ $creator->exclusive ? 'true' : 'false' }}"
                     data-verified="{{ $creator->verified ? 'true' : 'false' }}"
                     data-trending="{{ $creator->trending ? 'true' : 'false' }}"
                     data-new="{{ $creator->created_at->diffInDays() < 30 ? 'true' : 'false' }}">
                    
                    <div class="creator-card-header">
                        <div class="creator-image" style="background-image: url('{{ asset($creator->image) }}')">
                            <div class="creator-badges">
                                @if($creator->verified)
                                    <span class="badge verified">
                                        <i class="lucide-badge-check"></i>
                                    </span>
                                @endif
                                
                                @if($creator->exclusive)
                                    <span class="badge exclusive">
                                        <i class="lucide-crown"></i>
                                    </span>
                                @endif
                                
                                @if($creator->trending)
                                    <span class="badge trending">
                                        <i class="lucide-trending-up"></i>
                                    </span>
                                @endif
                                
                                @if($creator->created_at->diffInDays() < 30)
                                    <span class="badge new">
                                        <i class="lucide-sparkles"></i>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <h3 class="creator-name">{{ $creator->name }}</h3>
                        <p class="creator-role">{{ $creator->role }}</p>
                    </div>
                    
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="lucide-video"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator->videos }}</span>
                                <span class="stat-label">Vídeos</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-users"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator->followers }}</span>
                                <span class="stat-label">Seguidores</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-star"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ number_format($creator->rating, 1) }}</span>
                                <span class="stat-label">Avaliação</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="creator-tags">
                        @foreach($creator->tags->take(3) as $tag)
                            <span class="tag">{{ $tag->name }}</span>
                        @endforeach
                        
                        @if($creator->tags->count() > 3)
                            <span class="tag more">+{{ $creator->tags->count() - 3 }}</span>
                        @endif
                    </div>
                    
                    <div class="creator-actions">
                        <a href="{{ route('creators.show', $creator->id) }}" class="btn-primary">Ver Perfil</a>
                        <button class="btn-follow" data-id="{{ $creator->id }}">
                            <i class="lucide-plus"></i> Seguir
                        </button>
                    </div>
                </div>
            @empty
                <div class="no-results">
                    <i class="lucide-search-x"></i>
                    <h3>Nenhum criador encontrado</h3>
                    <p>Tente ajustar seus filtros ou termos de busca.</p>
                </div>
            @endforelse
        </div>
        
        <div class="pagination-container">
            {{ $creators->links() }}
        </div>
        
        <div class="become-creator">
            <div class="become-creator-content">
                <h2>Quer se tornar um criador no HotBoys?</h2>
                <p>Ganhe dinheiro compartilhando seu conteúdo premium com milhões de fãs. Nossos criadores ganham em média R$ 15.000 por mês.</p>
                <a href="{{ route('creators.apply') }}" class="btn-primary">Quero ser Criador</a>
            </div>
            <div class="benefits">
                <div class="benefit">
                    <i class="lucide-dollar-sign"></i>
                    <h3>Ganhos Garantidos</h3>
                    <p>Receba até 80% dos lucros gerados com seu conteúdo</p>
                </div>
                
                <div class="benefit">
                    <i class="lucide-shield"></i>
                    <h3>Proteção de Conteúdo</h3>
                    <p>Nosso sistema protege seu conteúdo contra vazamentos</p>
                </div>
                
                <div class="benefit">
                    <i class="lucide-bar-chart"></i>
                    <h3>Analytics Completo</h3>
                    <p>Acompanhe seu desempenho e entenda seu público</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .creators-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Header e Filtros */
    .creators-header {
        margin-bottom: 2rem;
    }
    
    .creators-search {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .creators-search input {
        width: 100%;
        padding: 1rem 3rem 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .creators-search input:focus {
        outline: none;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.3);
        border-color: var(--hot-red);
        background: rgba(255, 255, 255, 0.15);
    }
    
    .search-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--hot-red);
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .creators-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        align-items: center;
    }
    
    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filter-group label {
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    
    .filter-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .filter-option {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-option:hover {
        background: rgba(255, 51, 51, 0.2);
        color: white;
    }
    
    .filter-option.active {
        background: var(--hot-red);
        color: white;
    }
    
    #sort-select {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='white' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        padding-right: 30px;
    }
    
    #sort-select:focus {
        outline: none;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.3);
        border-color: var(--hot-red);
    }
    
    /* Grid de Criadores */
    .creators-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .creator-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-card);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    
    .creator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 51, 51, 0.2);
        border-color: rgba(255, 51, 51, 0.3);
    }
    
    .creator-card-header {
        text-align: center;
        padding: 0 1rem;
    }
    
    .creator-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 1.5rem auto 1rem;
        background-size: cover;
        background-position: center;
        position: relative;
        border: 3px solid var(--hot-red);
        box-shadow: 0 0 20px rgba(255, 51, 51, 0.3);
    }
    
    .creator-badges {
        position: absolute;
        bottom: 0;
        right: 0;
        display: flex;
        gap: 4px;
    }
    
    .badge {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        border: 2px solid var(--dark-bg);
    }
    
    .badge.verified {
        background: #1DA1F2;
        color: white;
    }
    
    .badge.exclusive {
        background: #FFD700;
        color: black;
    }
    
    .badge.trending {
        background: #FF3333;
        color: white;
    }
    
    .badge.new {
        background: #7CFC00;
        color: black;
    }
    
    .creator-name {
        margin: 0.5rem 0 0.2rem;
        font-size: 1.2rem;
    }
    
    .creator-role {
        color: var(--text-secondary);
        margin: 0 0 1rem;
        font-size: 0.9rem;
    }
    
    .creator-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        padding: 1rem;
        background: rgba(0, 0, 0, 0.2);
    }
    
    .stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .stat i {
        color: var(--hot-red);
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .creator-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1rem;
    }
    
    .tag {
        background: rgba(255, 51, 51, 0.15);
        color: var(--text-primary);
        padding: 0.2rem 0.7rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }
    
    .tag.more {
        background: rgba(255, 255, 255, 0.1);
    }
    
    .creator-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.7rem;
        padding: 0 1rem 1rem;
        margin-top: auto;
    }
    
    .creator-actions .btn-primary,
    .creator-actions .btn-follow {
        width: 100%;
        text-align: center;
        padding: 0.7rem;
        border-radius: var(--border-radius-button);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background: var(--gradient-hot);
        color: white;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    
    .btn-follow {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover, 
    .btn-follow:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 51, 51, 0.3);
    }
    
    .no-results {
        grid-column: 1 / -1;
        text-align: center;
        padding: 3rem 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: var(--border-radius-card);
    }
    
    .no-results i {
        font-size: 3rem;
        color: var(--hot-red);
        margin-bottom: 1rem;
        opacity: 0.6;
    }
    
    .no-results h3 {
        margin: 0 0 0.5rem;
    }
    
    .no-results p {
        color: var(--text-secondary);
    }
    
    /* Paginação */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-bottom: 3rem;
    }
    
    /* Torne-se um Criador */
    .become-creator {
        margin-top: 4rem;
        padding: 3rem 2rem;
        background: linear-gradient(145deg, rgba(255, 51, 51, 0.15), rgba(255, 26, 26, 0.05));
        border-radius: var(--border-radius-card);
        text-align: center;
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
    
    .become-creator-content {
        max-width: 700px;
        margin: 0 auto 3rem;
    }
    
    .become-creator h2 {
        margin-top: 0;
        font-size: 2rem;
    }
    
    .become-creator p {
        margin-bottom: 2rem;
        color: var(--text-secondary);
        font-size: 1.1rem;
    }
    
    .benefits {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }
    
    .benefit {
        background: rgba(0, 0, 0, 0.3);
        padding: 2rem 1.5rem;
        border-radius: var(--border-radius-card);
        transition: all 0.3s ease;
    }
    
    .benefit:hover {
        transform: translateY(-5px);
        background: rgba(255, 51, 51, 0.1);
    }
    
    .benefit i {
        font-size: 2.5rem;
        color: var(--hot-red);
        margin-bottom: 1rem;
    }
    
    .benefit h3 {
        margin: 0 0 0.5rem;
    }
    
    .benefit p {
        margin: 0;
        font-size: 0.9rem;
    }
    
    /* Responsividade */
    @media (max-width: 992px) {
        .benefits {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .creators-filters {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .filter-group {
            width: 100%;
        }
        
        .filter-options {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            width: 100%;
            flex-wrap: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        
        .filter-option {
            white-space: nowrap;
        }
        
        #sort-select {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .creator-actions {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elementos DOM
        const searchInput = document.getElementById('creators-search-input');
        const filterButtons = document.querySelectorAll('.filter-option');
        const sortSelect = document.getElementById('sort-select');
        const creatorCards = document.querySelectorAll('.creator-card');
        const creatorGrid = document.getElementById('creators-grid');
        
        // Estado atual dos filtros
        let currentFilter = 'all';
        let currentSort = 'popular';
        let searchTerm = '';
        
        // Botões de filtro
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Atualizar estado ativo dos botões
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                // Atualizar filtro atual
                currentFilter = button.dataset.filter;
                
                // Aplicar filtros
                applyFilters();
            });
        });
        
        // Select de ordenação
        sortSelect.addEventListener('change', () => {
            currentSort = sortSelect.value;
            applyFilters();
        });
        
        // Input de busca
        searchInput.addEventListener('input', () => {
            searchTerm = searchInput.value.toLowerCase();
            applyFilters();
        });
        
        // Botões de seguir
        const followButtons = document.querySelectorAll('.btn-follow');
        followButtons.forEach(button => {
            button.addEventListener('click', function() {
                const creatorId = this.dataset.id;
                
                // Toggle estado visual para feedback imediato
                if (this.classList.contains('following')) {
                    this.classList.remove('following');
                    this.innerHTML = '<i class="lucide-plus"></i> Seguir';
                    this.style.background = 'rgba(255, 255, 255, 0.1)';
                } else {
                    this.classList.add('following');
                    this.innerHTML = '<i class="lucide-check"></i> Seguindo';
                    this.style.background = 'var(--hot-red)';
                }
                
                // Aqui você enviaria uma requisição AJAX para atualizar o estado no servidor
                // Por exemplo:
                /*
                fetch('/api/creators/' + creatorId + '/follow', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Reverter a UI em caso de erro
                });
                */
            });
        });
        
        // Função principal para aplicar filtros
        function applyFilters() {
            let hasVisibleCards = false;
            
            creatorCards.forEach(card => {
                // Verificar se o card atende ao filtro de categoria
                let matchesFilter = currentFilter === 'all' || card.dataset[currentFilter] === 'true';
                
                // Verificar se o card atende ao termo de busca
                let matchesSearch = true;
                if (searchTerm.length >= 2) {
                    const creatorName = card.querySelector('.creator-name').textContent.toLowerCase();
                    const creatorRole = card.querySelector('.creator-role').textContent.toLowerCase();
                    const creatorTags = card.dataset.tags.toLowerCase();
                    
                    matchesSearch = creatorName.includes(searchTerm) || 
                                    creatorRole.includes(searchTerm) ||
                                    creatorTags.includes(searchTerm);
                }
                
                // Mostrar ou esconder com base nos filtros
                if (matchesFilter && matchesSearch) {
                    card.style.display = 'flex';
                    hasVisibleCards = true;
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Verificar se há cartões visíveis
            if (!hasVisibleCards) {
                // Se não houver resultados, mostrar mensagem
                let noResults = document.querySelector('.no-results');
                if (!noResults) {
                    noResults = document.createElement('div');
                    noResults.className = 'no-results';
                    noResults.innerHTML = `
                        <i class="lucide-search-x"></i>
                        <h3>Nenhum criador encontrado</h3>
                        <p>Tente ajustar seus filtros ou termos de busca.</p>
                    `;
                    creatorGrid.appendChild(noResults);
                }
            } else {
                // Se houver resultados, remover mensagem de "sem resultados"
                const noResults = document.querySelector('.no-results');
                if (noResults) {
                    noResults.remove();
                }
                
                // Aplicar ordenação aos cartões visíveis
                const visibleCards = Array.from(creatorCards).filter(card => card.style.display !== 'none');
                sortCards(visibleCards, currentSort);
            }
        }
        
        // Função para ordenar os cartões
        function sortCards(cards, sortBy) {
            // Desanexar cartões para reordenação
            cards.forEach(card => card.remove());
            
            // Ordenar com base no critério selecionado
            cards.sort((a, b) => {
                switch (sortBy) {
                    case 'popular':
                        return parseInt(b.dataset.followers) - parseInt(a.dataset.followers);
                    case 'recent':
                        // Assumindo que cartões "novos" são mais recentes
                        if (a.dataset.new === 'true' && b.dataset.new !== 'true') return -1;
                        if (a.dataset.new !== 'true' && b.dataset.new === 'true') return 1;
                        return parseInt(b.dataset.followers) - parseInt(a.dataset.followers);
                    case 'rating':
                        return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
                    case 'videos':
                        return parseInt(b.dataset.videos) - parseInt(a.dataset.videos);
                    default:
                        return 0;
                }
            });
            
            // Reapender cartões ordenados
            cards.forEach(card => creatorGrid.appendChild(card));
        }
    });
</script>
@endpush