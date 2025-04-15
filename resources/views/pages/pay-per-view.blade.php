@extends('layouts.page')

@section('title', 'Conteúdo Exclusivo - Pay-per-view - HotBoys')

@section('page-title', 'Conteúdo Exclusivo')

@section('page-content')
    <div class="ppv-container">
        <div class="ppv-intro">
            <h2>Conteúdo Premium - Sem Assinatura</h2>
            <p>Acesse vídeos exclusivos de alta qualidade sem compromisso mensal. Pague apenas pelo que você quer assistir.</p>
        </div>
        
        <div class="ppv-search-filter">
            <div class="ppv-search">
                <input type="text" id="ppv-search-input" placeholder="Buscar por título, categoria ou criador">
                <button class="search-btn"><i class="lucide-search"></i></button>
            </div>
            
            <div class="ppv-filters">
                <select id="filter-category">
                    <option value="all">Todas as categorias</option>
                    <option value="amateur">Amador</option>
                    <option value="professional">Profissional</option>
                    <option value="fetish">Fetiche</option>
                    <option value="exclusive">Super Exclusivo</option>
                </select>
                
                <select id="filter-duration">
                    <option value="all">Qualquer duração</option>
                    <option value="short">Curto (< 10 min)</option>
                    <option value="medium">Médio (10-30 min)</option>
                    <option value="long">Longo (> 30 min)</option>
                </select>
                
                <select id="filter-price">
                    <option value="all">Qualquer preço</option>
                    <option value="low">Econômico (até R$15)</option>
                    <option value="medium">Padrão (R$15-30)</option>
                    <option value="high">Premium (R$30+)</option>
                </select>
            </div>
        </div>
        
        <div class="ppv-content">
            @foreach($ppvItems as $item)
                <div class="ppv-item" data-category="{{ $item['category'] }}" data-duration="{{ str_contains($item['duration'], ':') && explode(':', $item['duration'])[0] > 30 ? 'long' : (str_contains($item['duration'], ':') && explode(':', $item['duration'])[0] < 10 ? 'short' : 'medium') }}" data-price="{{ $item['price'] < 15 ? 'low' : ($item['price'] > 30 ? 'high' : 'medium') }}">
                    <div class="ppv-thumbnail">
                        @if($item['category'] === 'exclusive')
                            <div class="ppv-exclusive-badge">Exclusivo</div>
                        @endif
                        <img src="{{ $item['thumbnail'] }}" alt="{{ $item['title'] }}">
                        <span class="ppv-duration">{{ $item['duration'] }}</span>
                        <div class="ppv-preview-btn" data-id="{{ $item['id'] }}">
                            <i class="lucide-play"></i> Prévia
                        </div>
                    </div>
                    
                    <div class="ppv-info">
                        <h3>{{ $item['title'] }}</h3>
                        <div class="ppv-creator">
                            <img src="{{ $item['creator']['avatar'] }}" alt="Avatar de {{ $item['creator']['name'] }}" class="creator-avatar">
                            <span>{{ $item['creator']['name'] }}</span>
                            @if($item['creator']['verified'])
                                <i class="lucide-badge-check verified-badge"></i>
                            @endif
                        </div>
                        <div class="ppv-details">
                            <span class="ppv-views"><i class="lucide-eye"></i> {{ $item['views'] }}</span>
                            <span class="ppv-rating"><i class="lucide-star"></i> {{ $item['rating'] }}</span>
                        </div>
                        <div class="ppv-price">
                            <span class="price-tag">R$ {{ number_format($item['price'], 2, ',', '.') }}</span>
                            <button class="buy-btn" data-id="{{ $item['id'] }}">Comprar</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="ppv-more">
            <button class="load-more-btn">Carregar mais <i class="lucide-chevron-down"></i></button>
        </div>
        
        <div class="ppv-info-section">
            <div class="info-card">
                <i class="lucide-info"></i>
                <h3>Como funciona</h3>
                <p>Compre apenas os vídeos que desejar sem compromisso de assinatura. Após a compra, o conteúdo fica disponível por 72 horas para visualização ilimitada.</p>
            </div>
            
            <div class="info-card">
                <i class="lucide-credit-card"></i>
                <h3>Pagamento seguro</h3>
                <p>Aceitamos diversos métodos de pagamento, incluindo cartão de crédito, PIX e criptomoedas. Todas as transações são criptografadas e seguras.</p>
            </div>
            
            <div class="info-card">
                <i class="lucide-package"></i>
                <h3>Economize com pacotes</h3>
                <p>Prefere mais conteúdo? Confira nossos pacotes de vídeos com descontos especiais ou considere uma assinatura mensal para acesso ilimitado.</p>
                <a href="#" class="link-arrow">Ver planos <i class="lucide-arrow-right"></i></a>
            </div>
        </div>
        
        <div class="become-creator">
            <div class="creator-cta">
                <h2>É um criador de conteúdo?</h2>
                <p>Venda seus vídeos exclusivos na nossa plataforma e ganhe até 85% em cada venda. Tenha controle total sobre seus preços e conteúdos.</p>
                <a href="#" class="btn-primary">Torne-se um criador</a>
            </div>
        </div>
    </div>
    
    <!-- Modal de prévia (oculto por padrão) -->
    <div class="preview-modal" id="preview-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="preview-title">Título do vídeo</h3>
                <button class="close-modal"><i class="lucide-x"></i></button>
            </div>
            <div class="modal-body">
                <div class="preview-player">
                    <img src="/api/placeholder/640/360" alt="Prévia do vídeo" class="preview-placeholder">
                    <div class="preview-play-btn">
                        <i class="lucide-play"></i>
                    </div>
                    <div class="preview-duration">Prévia: 0:45</div>
                </div>
                <div class="preview-info">
                    <p class="preview-description">Esta é uma prévia de 45 segundos do conteúdo completo. Compre o vídeo para desbloquear o conteúdo integral e ter acesso por 72 horas.</p>
                    <div class="preview-price">
                        <span id="preview-price-tag">R$ 24,90</span>
                        <button class="buy-btn-large">Comprar agora</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Estilo geral da página */
    .ppv-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Seção introdutória */
    .ppv-intro {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    
    .ppv-intro h2 {
        font-size: 1.8rem;
        background: linear-gradient(90deg, var(--hot-red), #ff9966);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        margin-bottom: 0.5rem;
    }
    
    .ppv-intro p {
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto;
    }
    
    /* Busca e filtros */
    .ppv-search-filter {
        margin-bottom: 2rem;
    }
    
    .ppv-search {
        position: relative;
        margin-bottom: 1rem;
    }
    
    .ppv-search input {
        width: 100%;
        padding: 1rem 3rem 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .ppv-search input:focus {
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
    
    .ppv-filters {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .ppv-filters select {
        flex: 1;
        min-width: 200px;
        padding: 0.8rem 1rem;
        border-radius: 8px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23ff3333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .ppv-filters select:focus {
        outline: none;
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.2);
        border-color: var(--hot-red);
    }
    
    /* Grid de conteúdo */
    .ppv-content {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    
    .ppv-item {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .ppv-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 51, 51, 0.3);
    }
    
    /* Thumbnails */
    .ppv-thumbnail {
        position: relative;
        overflow: hidden;
        aspect-ratio: 16/9;
    }
    
    .ppv-thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .ppv-item:hover .ppv-thumbnail img {
        transform: scale(1.05);
    }
    
    .ppv-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
    }
    
    .ppv-preview-btn {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        color: white;
        font-weight: 500;
        cursor: pointer;
    }
    
    .ppv-preview-btn i {
        margin-right: 0.5rem;
    }
    
    .ppv-item:hover .ppv-preview-btn {
        opacity: 1;
    }
    
    .ppv-exclusive-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: linear-gradient(90deg, var(--hot-red), #ff6b31);
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
        z-index: 1;
    }
    
    /* Informações do vídeo */
    .ppv-info {
        padding: 1rem;
    }
    
    .ppv-info h3 {
        font-size: 1.1rem;
        margin: 0 0 0.5rem 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .ppv-creator {
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    
    .creator-avatar {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        margin-right: 0.5rem;
        object-fit: cover;
    }
    
    .verified-badge {
        color: var(--hot-red);
        margin-left: 0.3rem;
        font-size: 0.8rem;
    }
    
    .ppv-details {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
        margin-bottom: 0.7rem;
    }
    
    .ppv-views i, .ppv-rating i {
        margin-right: 0.3rem;
    }
    
    .ppv-rating i {
        color: #ffcc00;
    }
    
    .ppv-price {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .price-tag {
        font-size: 1.2rem;
        font-weight: 600;
        color: white;
    }
    
    .buy-btn {
        background: var(--hot-red);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .buy-btn:hover {
        background: #ff5e5e;
        transform: scale(1.05);
    }
    
    /* Carregar mais */
    .ppv-more {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .load-more-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.7rem 1.5rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .load-more-btn:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }
    
    /* Seção de informações */
    .ppv-info-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }
    
    .info-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        border-color: rgba(255, 51, 51, 0.3);
        transform: translateY(-5px);
    }
    
    .info-card i {
        color: var(--hot-red);
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .info-card h3 {
        margin-top: 0;
        margin-bottom: 0.7rem;
    }
    
    .info-card p {
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }
    
    .link-arrow {
        color: var(--hot-red);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .link-arrow:hover {
        color: #ff5e5e;
    }
    
    /* CTA para criadores */
    .become-creator {
        background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 102, 102, 0.1));
        border-radius: 15px;
        border: 1px solid rgba(255, 51, 51, 0.2);
        padding: 2rem;
        margin-bottom: 2rem;
    }
    
    .creator-cta {
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .creator-cta h2 {
        margin-top: 0;
        font-size: 1.8rem;
    }
    
    .creator-cta p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    .btn-primary {
        background: var(--hot-red);
        color: white;
        border: none;
        padding: 0.8rem 1.8rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        display: inline-block;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background: #ff5e5e;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 51, 51, 0.3);
    }
    
    /* Modal de prévia */
    .preview-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 1000;
        backdrop-filter: blur(5px);
    }
    
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -40%);
        opacity: 0;
        transition: all 0.3s ease;
        width: 90%;
        max-width: 800px;
        background: #1a1a1a;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
    }
    
    .modal-content.modal-active {
        transform: translate(-50%, -50%);
        opacity: 1;
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .modal-header h3 {
        margin: 0;
    }
    
    .close-modal {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }
    
    .close-modal:hover {
        color: var(--hot-red);
    }
    
    .modal-body {
        padding: 1.5rem;
    }
    
    .preview-player {
        position: relative;
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    
    .preview-placeholder {
        width: 100%;
        height: auto;
        display: block;
    }
    
    .preview-play-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: rgba(255, 51, 51, 0.8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .preview-play-btn:hover {
        background: var(--hot-red);
        transform: translate(-50%, -50%) scale(1.1);
    }
    
    .preview-duration {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.3rem 0.7rem;
        border-radius: 4px;
        font-size: 0.9rem;
    }
    
    .preview-description {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    .preview-price {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    #preview-price-tag {
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .buy-btn-large {
        background: var(--hot-red);
        color: white;
        border: none;
        padding: 0.8rem 1.8rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .buy-btn-large:hover {
        background: #ff5e5e;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(255, 51, 51, 0.3);
    }
    
    /* Estilos para estados vazios e feedback */
    .empty-state {
        padding: 3rem;
        text-align: center;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        grid-column: 1 / -1;
        margin: 2rem 0;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: var(--hot-red);
        opacity: 0.6;
        margin-bottom: 1rem;
        display: inline-block;
    }
    
    .empty-state h3 {
        margin-bottom: 1rem;
    }
    
    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }
    
    .btn-reset-filters {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-reset-filters:hover {
        background: rgba(255, 51, 51, 0.2);
        border-color: rgba(255, 51, 51, 0.4);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.8rem 1.8rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.05);
    }
    
    /* Popup de sucesso na compra */
    .success-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 2000;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease forwards;
    }
    
    .popup-closing {
        animation: fadeOut 0.3s ease forwards;
    }
    
    .success-content {
        background: #1a1a1a;
        border-radius: 15px;
        padding: 2.5rem;
        max-width: 500px;
        width: 90%;
        text-align: center;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
        animation: scaleIn 0.3s ease forwards;
    }
    
    .popup-closing .success-content {
        animation: scaleOut 0.3s ease forwards;
    }
    
    .success-content i {
        font-size: 4rem;
        color: #2ecc71;
        margin-bottom: 1.5rem;
    }
    
    .success-content h3 {
        font-size: 1.8rem;
        margin-bottom: 1rem;
    }
    
    .success-content p {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }
    
    .success-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }
    
    /* Animações */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    
    @keyframes scaleIn {
        from { transform: scale(0.9); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    
    @keyframes scaleOut {
        from { transform: scale(1); opacity: 1; }
        to { transform: scale(0.9); opacity: 0; }
    }
    
    .new-item {
        animation: slideInUp 0.5s ease forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Responsividade */
    @media (max-width: 768px) {
        .preview-price {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .buy-btn-large {
            width: 100%;
        }
        
        .ppv-filters {
            flex-direction: column;
        }
        
        .ppv-filters select {
            width: 100%;
        }
        
        .success-buttons {
            flex-direction: column;
        }
        
        .success-content {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtros de categoria, duração e preço
        const filterCategory = document.getElementById('filter-category');
        const filterDuration = document.getElementById('filter-duration');
        const filterPrice = document.getElementById('filter-price');
        const ppvItems = document.querySelectorAll('.ppv-item');
        
        function applyFilters() {
            const categoryValue = filterCategory.value;
            const durationValue = filterDuration.value;
            const priceValue = filterPrice.value;
            
            let visibleCount = 0;
            
            ppvItems.forEach(item => {
                const categoryMatch = categoryValue === 'all' || item.dataset.category === categoryValue;
                const durationMatch = durationValue === 'all' || item.dataset.duration === durationValue;
                const priceMatch = priceValue === 'all' || item.dataset.price === priceValue;
                
                if (categoryMatch && durationMatch && priceMatch) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Mostrar mensagem se não houver resultados
            const noResultsMessage = document.querySelector('.no-results-message');
            if (visibleCount === 0) {
                if (!noResultsMessage) {
                    const message = document.createElement('div');
                    message.className = 'no-results-message';
                    message.innerHTML = `
                        <div class="empty-state">
                            <i class="lucide-search-x"></i>
                            <h3>Nenhum conteúdo encontrado</h3>
                            <p>Tente ajustar seus filtros ou termos de busca.</p>
                            <button class="btn-reset-filters">Limpar filtros</button>
                        </div>
                    `;
                    document.querySelector('.ppv-content').appendChild(message);
                    
                    // Adicionar evento para o botão de limpar filtros
                    message.querySelector('.btn-reset-filters').addEventListener('click', resetFilters);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        }
        
        function resetFilters() {
            filterCategory.value = 'all';
            filterDuration.value = 'all';
            filterPrice.value = 'all';
            document.getElementById('ppv-search-input').value = '';
            applyFilters();
        }
        
        filterCategory.addEventListener('change', applyFilters);
        filterDuration.addEventListener('change', applyFilters);
        filterPrice.addEventListener('change', applyFilters);
        
        // Busca por texto
        const searchInput = document.getElementById('ppv-search-input');
        
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            
            if (searchTerm.length < 2) {
                // Reseta a exibição e aplica os filtros atuais
                applyFilters();
                return;
            }
            
            let visibleCount = 0;
            
            ppvItems.forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                const creator = item.querySelector('.ppv-creator span').textContent.toLowerCase();
                const category = item.dataset.category.toLowerCase();
                
                if (title.includes(searchTerm) || creator.includes(searchTerm) || category.includes(searchTerm)) {
                    item.style.display = 'block';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Mostrar mensagem se não houver resultados
            const noResultsMessage = document.querySelector('.no-results-message');
            if (visibleCount === 0) {
                if (!noResultsMessage) {
                    const message = document.createElement('div');
                    message.className = 'no-results-message';
                    message.innerHTML = `
                        <div class="empty-state">
                            <i class="lucide-search-x"></i>
                            <h3>Nenhum resultado para "${searchTerm}"</h3>
                            <p>Tente usar termos diferentes ou navegue por categorias.</p>
                            <button class="btn-reset-filters">Limpar busca</button>
                        </div>
                    `;
                    document.querySelector('.ppv-content').appendChild(message);
                    
                    // Adicionar evento para o botão de limpar filtros
                    message.querySelector('.btn-reset-filters').addEventListener('click', resetFilters);
                }
            } else if (noResultsMessage) {
                noResultsMessage.remove();
            }
        });
        
        // Modal de prévia
        const previewModal = document.getElementById('preview-modal');
        const previewBtns = document.querySelectorAll('.ppv-preview-btn');
        const closeModalBtn = document.querySelector('.close-modal');
        const previewTitle = document.getElementById('preview-title');
        const previewPriceTag = document.getElementById('preview-price-tag');
        
        previewBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Obtém dados do vídeo
                const ppvItem = btn.closest('.ppv-item');
                const title = ppvItem.querySelector('h3').textContent;
                const price = ppvItem.querySelector('.price-tag').textContent;
                const thumbnail = ppvItem.querySelector('img').src.replace('400', '640').replace('225', '360');
                
                // Atualiza o modal
                previewTitle.textContent = title;
                previewPriceTag.textContent = price;
                document.querySelector('.preview-placeholder').src = thumbnail;
                
                // Mostra o modal
                previewModal.style.display = 'block';
                document.body.style.overflow = 'hidden'; // Impede rolagem
                
                // Adiciona animação de entrada
                setTimeout(() => {
                    document.querySelector('.modal-content').classList.add('modal-active');
                }, 10);
            });
        });
        
        closeModalBtn.addEventListener('click', () => {
            document.querySelector('.modal-content').classList.remove('modal-active');
            
            // Espera a animação terminar antes de esconder o modal
            setTimeout(() => {
                previewModal.style.display = 'none';
                document.body.style.overflow = 'auto'; // Restaura rolagem
            }, 300);
        });
        
        // Fecha modal ao clicar fora dele
        previewModal.addEventListener('click', (e) => {
            if (e.target === previewModal) {
                document.querySelector('.modal-content').classList.remove('modal-active');
                
                // Espera a animação terminar antes de esconder o modal
                setTimeout(() => {
                    previewModal.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        });
        
        // Botões de compra
        const buyButtons = document.querySelectorAll('.buy-btn, .buy-btn-large');
        buyButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id || this.closest('.ppv-item')?.querySelector('.buy-btn').dataset.id;
                
                // Simular início do processo de compra
                this.innerHTML = '<i class="lucide-loader"></i> Processando...';
                this.disabled = true;
                
                // Simular processamento
                setTimeout(() => {
                    // Criar um popup de sucesso
                    const successPopup = document.createElement('div');
                    successPopup.className = 'success-popup';
                    successPopup.innerHTML = `
                        <div class="success-content">
                            <i class="lucide-check-circle"></i>
                            <h3>Compra realizada com sucesso!</h3>
                            <p>Você já pode começar a assistir seu conteúdo.</p>
                            <div class="success-buttons">
                                <button class="btn-primary">Assistir agora</button>
                                <button class="btn-secondary close-popup">Continuar navegando</button>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(successPopup);
                    
                    // Resetar botão
                    this.innerHTML = 'Comprar';
                    this.disabled = false;
                    
                    // Se estiver no modal, fechar o modal
                    if (previewModal.style.display === 'block') {
                        closeModalBtn.click();
                    }
                    
                    // Adicionar evento para fechar o popup
                    successPopup.querySelector('.close-popup').addEventListener('click', () => {
                        successPopup.classList.add('popup-closing');
                        setTimeout(() => {
                            successPopup.remove();
                        }, 300);
                    });
                    
                    // Adicionar evento para o botão "Assistir agora"
                    successPopup.querySelector('.btn-primary').addEventListener('click', () => {
                        alert('Redirecionando para a página de visualização do conteúdo...');
                        successPopup.remove();
                    });
                    
                    // Fechar automaticamente após 10 segundos
                    setTimeout(() => {
                        if (document.body.contains(successPopup)) {
                            successPopup.classList.add('popup-closing');
                            setTimeout(() => {
                                if (document.body.contains(successPopup)) {
                                    successPopup.remove();
                                }
                            }, 300);
                        }
                    }, 10000);
                }, 1500);
            });
        });
        
        // Botão "Carregar mais"
        const loadMoreBtn = document.querySelector('.load-more-btn');
        
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                // Simular carregamento
                loadMoreBtn.innerHTML = '<i class="lucide-loader"></i> Carregando...';
                loadMoreBtn.disabled = true;
                
                // Simular atraso de rede
                setTimeout(() => {
                    // Clonar itens existentes para demonstração
                    const container = document.querySelector('.ppv-content');
                    const items = Array.from(ppvItems).slice(0, 4); // Pegar primeiros 4 itens
                    
                    // Adicionar novos itens com pequenas modificações
                    items.forEach(item => {
                        const clone = item.cloneNode(true);
                        const title = clone.querySelector('h3');
                        title.textContent = 'Novo: ' + title.textContent;
                        
                        // Adicionar classe para animação de entrada
                        clone.classList.add('new-item');
                        
                        // Diferente data-id para evitar conflitos
                        const randomId = Math.floor(Math.random() * 1000) + 100;
                        clone.querySelector('.buy-btn').dataset.id = randomId;
                        clone.querySelector('.ppv-preview-btn').dataset.id = randomId;
                        
                        // Adicionar ao container
                        container.appendChild(clone);
                        
                        // Atualizar handlers para novos elementos
                        clone.querySelector('.ppv-preview-btn').addEventListener('click', function() {
                            const title = this.closest('.ppv-item').querySelector('h3').textContent;
                            const price = this.closest('.ppv-item').querySelector('.price-tag').textContent;
                            const thumbnail = this.closest('.ppv-item').querySelector('img').src.replace('400', '640').replace('225', '360');
                            
                            previewTitle.textContent = title;
                            previewPriceTag.textContent = price;
                            document.querySelector('.preview-placeholder').src = thumbnail;
                            
                            previewModal.style.display = 'block';
                            document.body.style.overflow = 'hidden';
                            
                            setTimeout(() => {
                                document.querySelector('.modal-content').classList.add('modal-active');
                            }, 10);
                        });
                        
                        clone.querySelector('.buy-btn').addEventListener('click', function() {
                            this.innerHTML = '<i class="lucide-loader"></i> Processando...';
                            this.disabled = true;
                            
                            setTimeout(() => {
                                const successPopup = document.createElement('div');
                                successPopup.className = 'success-popup';
                                successPopup.innerHTML = `
                                    <div class="success-content">
                                        <i class="lucide-check-circle"></i>
                                        <h3>Compra realizada com sucesso!</h3>
                                        <p>Você já pode começar a assistir seu conteúdo.</p>
                                        <div class="success-buttons">
                                            <button class="btn-primary">Assistir agora</button>
                                            <button class="btn-secondary close-popup">Continuar navegando</button>
                                        </div>
                                    </div>
                                `;
                                document.body.appendChild(successPopup);
                                
                                this.innerHTML = 'Comprar';
                                this.disabled = false;
                                
                                successPopup.querySelector('.close-popup').addEventListener('click', () => {
                                    successPopup.classList.add('popup-closing');
                                    setTimeout(() => {
                                        successPopup.remove();
                                    }, 300);
                                });
                                
                                successPopup.querySelector('.btn-primary').addEventListener('click', () => {
                                    alert('Redirecionando para a página de visualização do conteúdo...');
                                    successPopup.remove();
                                });
                                
                                setTimeout(() => {
                                    if (document.body.contains(successPopup)) {
                                        successPopup.classList.add('popup-closing');
                                        setTimeout(() => {
                                            if (document.body.contains(successPopup)) {
                                                successPopup.remove();
                                            }
                                        }, 300);
                                    }
                                }, 10000);
                            }, 1500);
                        });
                    });
                    
                    // Atualizar estado do botão
                    loadMoreBtn.innerHTML = 'Carregar mais <i class="lucide-chevron-down"></i>';
                    loadMoreBtn.disabled = false;
                    
                    // Aplicar filtros atuais aos novos itens
                    applyFilters();
                }, 1500);
            });
        }
    });
</script>
@endpush