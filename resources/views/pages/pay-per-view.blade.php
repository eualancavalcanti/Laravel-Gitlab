<!-- resources/views/pages/pay-per-view.blade.php -->
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
            <div class="ppv-item" data-category="professional" data-duration="medium" data-price="medium">
                <div class="ppv-thumbnail">
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">22:15</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Noite Quente em São Paulo</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>Lucas Silva</span>
                        <i class="lucide-badge-check verified-badge"></i>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 12.4k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.8</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 24,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
            
            <div class="ppv-item" data-category="amateur" data-duration="short" data-price="low">
                <div class="ppv-thumbnail">
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">08:45</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Primera Vez</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>Pedro Alvarez</span>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 5.2k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.5</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 12,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
            
            <div class="ppv-item" data-category="exclusive" data-duration="long" data-price="high">
                <div class="ppv-thumbnail">
                    <div class="ppv-exclusive-badge">Exclusivo</div>
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">45:20</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Encontro Inesquecível no Rio</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>Bruno Costa</span>
                        <i class="lucide-badge-check verified-badge"></i>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 24.7k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.9</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 39,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
            
            <div class="ppv-item" data-category="fetish" data-duration="medium" data-price="medium">
                <div class="ppv-thumbnail">
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">18:30</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Dominação Total</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>Master Felipe</span>
                        <i class="lucide-badge-check verified-badge"></i>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 18.3k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.7</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 27,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
            
            <div class="ppv-item" data-category="professional" data-duration="long" data-price="high">
                <div class="ppv-thumbnail">
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">32:10</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Massagem Especial</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>André Martins</span>
                        <i class="lucide-badge-check verified-badge"></i>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 32.1k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.9</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 34,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
            
            <div class="ppv-item" data-category="amateur" data-duration="short" data-price="low">
                <div class="ppv-thumbnail">
                    <img src="/api/placeholder/320/180" alt="Thumbnail do vídeo">
                    <span class="ppv-duration">09:55</span>
                    <div class="ppv-preview-btn">
                        <i class="lucide-play"></i> Prévia
                    </div>
                </div>
                
                <div class="ppv-info">
                    <h3>Experiência na Praia</h3>
                    <div class="ppv-creator">
                        <img src="/api/placeholder/30/30" alt="Avatar do criador" class="creator-avatar">
                        <span>Gustavo Menezes</span>
                    </div>
                    <div class="ppv-details">
                        <span class="ppv-views"><i class="lucide-eye"></i> 7.8k</span>
                        <span class="ppv-rating"><i class="lucide-star"></i> 4.3</span>
                    </div>
                    <div class="ppv-price">
                        <span class="price-tag">R$ 14,90</span>
                        <button class="buy-btn">Comprar</button>
                    </div>
                </div>
            </div>
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
                <a href="{{ route('plans') }}" class="link-arrow">Ver planos <i class="lucide-arrow-right"></i></a>
            </div>
        </div>
        
        <div class="become-creator">
            <div class="creator-cta">
                <h2>É um criador de conteúdo?</h2>
                <p>Venda seus vídeos exclusivos na nossa plataforma e ganhe até 85% em cada venda. Tenha controle total sobre seus preços e conteúdos.</p>
                <a href="{{ route('become-creator') }}" class="btn-primary">Torne-se um criador</a>
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
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 800px;
        background: #1a1a1a;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.5);
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
            
            ppvItems.forEach(item => {
                const categoryMatch = categoryValue === 'all' || item.dataset.category === categoryValue;
                const durationMatch = durationValue === 'all' || item.dataset.duration === durationValue;
                const priceMatch = priceValue === 'all' || item.dataset.price === priceValue;
                
                if (categoryMatch && durationMatch && priceMatch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
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
            
            ppvItems.forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                const creator = item.querySelector('.ppv-creator span').textContent.toLowerCase();
                const category = item.dataset.category.toLowerCase();
                
                if (title.includes(searchTerm) || creator.includes(searchTerm) || category.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
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
                
                // Atualiza o modal
                previewTitle.textContent = title;
                previewPriceTag.textContent = price;
                
                // Mostra o modal
                previewModal.style.display = 'block';
                document.body.style.overflow = 'hidden'; // Impede rolagem
            });
        });
        
        closeModalBtn.addEventListener('click', () => {
            previewModal.style.display = 'none';
            document.body.style.overflow = 'auto'; // Restaura rolagem
        });
        
        // Fecha modal ao clicar fora dele
        previewModal.addEventListener('click', (e) => {
            if (e.target === previewModal) {
                previewModal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
        
        // Botão "Carregar mais"
        const loadMoreBtn = document.querySelector('.load-more-btn');
        
        loadMoreBtn.addEventListener('click', () => {
            // Aqui você implementaria a lógica para carregar mais conteúdo
            // Por enquanto, apenas uma simulação com alerta
            loadMoreBtn.innerHTML = '<i class="lucide-loader"></i> Carregando...';
            
            setTimeout(() => {
                alert('Esta funcionalidade carregaria mais vídeos em uma implementação real.');
                loadMoreBtn.innerHTML = 'Carregar mais <i class="lucide-chevron-down"></i>';
            }, 1500);
        });
    });
</script>
@endpush