@extends('layouts.page')

@section('title', $item['title'] . ' - Pay-per-view - HotBoys')

@section('page-title', 'Conteúdo Exclusivo')

@section('page-content')
    <div class="ppv-details-container">
        <div class="ppv-header">
            <div class="breadcrumbs">
                <a href="{{ route('pay-per-view.index') }}">Pay-Per-View</a> <i class="lucide-chevron-right"></i> <span>{{ $item['title'] }}</span>
            </div>
            <h1>{{ $item['title'] }}</h1>
        </div>
        
        <div class="ppv-content-wrapper">
            <div class="ppv-preview">
                <div class="preview-player">
                    <img src="{{ $item['thumbnail'] }}" alt="{{ $item['title'] }}" class="preview-image">
                    <div class="preview-overlay">
                        <div class="preview-play-button">
                            <i class="lucide-play"></i>
                        </div>
                        <div class="preview-badge">
                            <span>Prévia</span>
                        </div>
                        <div class="preview-duration">
                            <span>Duração: {{ $item['duration'] }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="ppv-creator-info">
                    <div class="creator-avatar">
                        <img src="{{ $item['creator']['avatar'] }}" alt="{{ $item['creator']['name'] }}">
                        @if($item['creator']['verified'])
                            <span class="verified-badge"><i class="lucide-badge-check"></i></span>
                        @endif
                    </div>
                    <div class="creator-details">
                        <h3>{{ $item['creator']['name'] }}</h3>
                        <div class="video-stats">
                            <span><i class="lucide-eye"></i> {{ $item['views'] }}</span>
                            <span><i class="lucide-star"></i> {{ $item['rating'] }}</span>
                            <span><i class="lucide-tag"></i> {{ ucfirst($item['category']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ppv-purchase-info">
                <div class="ppv-description">
                    <h2>Sobre este conteúdo</h2>
                    <p>{{ $item['description'] ?? 'Este é um conteúdo exclusivo produzido por ' . $item['creator']['name'] . '. Assista a vídeos de alta qualidade sem compromisso de assinatura recorrente.' }}</p>
                    
                    <div class="ppv-features">
                        <div class="feature">
                            <i class="lucide-film"></i>
                            <span>Vídeo em HD</span>
                        </div>
                        <div class="feature">
                            <i class="lucide-clock"></i>
                            <span>{{ $item['duration'] }} de conteúdo</span>
                        </div>
                        <div class="feature">
                            <i class="lucide-calendar"></i>
                            <span>Acesso por 72 horas</span>
                        </div>
                        <div class="feature">
                            <i class="lucide-download"></i>
                            <span>Disponível para download</span>
                        </div>
                    </div>
                </div>
                
                <div class="ppv-purchase-card">
                    <div class="purchase-header">
                        <h3>Comprar este conteúdo</h3>
                        <div class="purchase-price">
                            <span class="currency">R$</span>
                            <span class="amount">{{ number_format($item['price'], 2, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="purchase-options">
                        <div class="payment-methods">
                            <h4>Formas de pagamento</h4>
                            <div class="methods-list">
                                <div class="method">
                                    <input type="radio" name="payment-method" id="credit-card" checked>
                                    <label for="credit-card">
                                        <i class="lucide-credit-card"></i>
                                        <span>Cartão de Crédito</span>
                                    </label>
                                </div>
                                <div class="method">
                                    <input type="radio" name="payment-method" id="pix">
                                    <label for="pix">
                                        <i class="lucide-qr-code"></i>
                                        <span>PIX</span>
                                    </label>
                                </div>
                                <div class="method">
                                    <input type="radio" name="payment-method" id="crypto">
                                    <label for="crypto">
                                        <i class="lucide-bitcoin"></i>
                                        <span>Criptomoedas</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="purchase-agreement">
                        <input type="checkbox" id="terms-check">
                        <label for="terms-check">Concordo com os <a href="/terms" target="_blank">termos de uso</a> e política de reembolso</label>
                    </div>
                    
                    <button class="btn-purchase">
                        <i class="lucide-shopping-cart"></i>
                        Comprar Agora
                    </button>
                    
                    <div class="purchase-security">
                        <i class="lucide-shield"></i>
                        <span>Pagamento 100% seguro e criptografado</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="related-content">
            <h2>Conteúdos Relacionados</h2>
            <div class="related-items">
                @foreach(array_filter($this->getPpvItems(), function($relatedItem) use ($item) {
                    return $relatedItem['id'] != $item['id'] && $relatedItem['category'] == $item['category'];
                }) as $relatedItem)
                    <div class="related-item">
                        <a href="{{ route('pay-per-view.show', ['id' => $relatedItem['id']]) }}">
                            <img src="{{ $relatedItem['thumbnail'] }}" alt="{{ $relatedItem['title'] }}">
                            <div class="related-info">
                                <h3>{{ $relatedItem['title'] }}</h3>
                                <div class="related-price">R$ {{ number_format($relatedItem['price'], 2, ',', '.') }}</div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    /* Estilos para a página de detalhes do Pay-Per-View */
    .ppv-details-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .ppv-header {
        margin-bottom: 2rem;
    }
    
    .breadcrumbs {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        color: var(--text-secondary);
    }
    
    .breadcrumbs a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        color: var(--hot-red);
    }
    
    .breadcrumbs i {
        font-size: 0.8rem;
    }
    
    .ppv-header h1 {
        font-size: 2.2rem;
        margin: 0;
        background: linear-gradient(90deg, var(--hot-red), #ff9966);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }
    
    .ppv-content-wrapper {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .preview-player {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
    }
    
    .preview-image {
        width: 100%;
        display: block;
    }
    
    .preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    
    .preview-play-button {
        width: 80px;
        height: 80px;
        background: rgba(255, 51, 51, 0.8);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 1rem;
    }
    
    .preview-play-button:hover {
        background: rgba(255, 51, 51, 1);
        transform: scale(1.05);
    }
    
    .preview-play-button i {
        font-size: 32px;
        color: white;
    }
    
    .preview-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        background: rgba(255, 51, 51, 0.8);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
    }
    
    .preview-duration {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
    }
    
    .ppv-creator-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    
    .creator-avatar {
        position: relative;
    }
    
    .creator-avatar img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--hot-red);
    }
    
    .verified-badge {
        position: absolute;
        bottom: -5px;
        right: -5px;
        background: #4CAF50;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .verified-badge i {
        font-size: 12px;
    }
    
    .creator-details h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1.2rem;
    }
    
    .video-stats {
        display: flex;
        gap: 1rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .ppv-purchase-info {
        background: rgba(255, 255, 255, 0.03);
        border-radius: 12px;
        overflow: hidden;
    }
    
    .ppv-description {
        padding: 1.5rem;
    }
    
    .ppv-description h2 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-size: 1.5rem;
    }
    
    .ppv-features {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .feature {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.8rem;
        border-radius: 8px;
    }
    
    .feature i {
        color: var(--hot-red);
    }
    
    .ppv-purchase-card {
        background: rgba(255, 51, 51, 0.1);
        padding: 1.5rem;
        border-top: 1px solid rgba(255, 51, 51, 0.3);
    }
    
    .purchase-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .purchase-header h3 {
        margin: 0;
    }
    
    .purchase-price {
        display: flex;
        align-items: baseline;
    }
    
    .currency {
        font-size: 1.2rem;
        margin-right: 0.2rem;
        color: var(--hot-red);
    }
    
    .amount {
        font-size: 2rem;
        font-weight: 700;
    }
    
    .payment-methods {
        margin-bottom: 1.5rem;
    }
    
    .payment-methods h4 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-size: 1rem;
    }
    
    .methods-list {
        display: flex;
        flex-direction: column;
        gap: 0.8rem;
    }
    
    .method {
        display: flex;
        align-items: center;
    }
    
    .method input {
        margin-right: 0.8rem;
    }
    
    .method label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .purchase-agreement {
        margin: 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
    }
    
    .purchase-agreement a {
        color: var(--hot-red);
        text-decoration: none;
    }
    
    .btn-purchase {
        width: 100%;
        background: var(--hot-red);
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 5px;
        font-weight: 600;
        font-size: 1.1rem;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .btn-purchase:hover {
        background: #ff3333;
        transform: translateY(-2px);
    }
    
    .purchase-security {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }
    
    .related-content {
        margin-top: 3rem;
    }
    
    .related-content h2 {
        margin-bottom: 1.5rem;
    }
    
    .related-items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 1.5rem;
    }
    
    .related-item {
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .related-item:hover {
        transform: translateY(-5px);
    }
    
    .related-item a {
        text-decoration: none;
        color: white;
    }
    
    .related-item img {
        width: 100%;
        aspect-ratio: 16/9;
        object-fit: cover;
        display: block;
    }
    
    .related-info {
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
    }
    
    .related-info h3 {
        margin: 0 0 0.5rem 0;
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .related-price {
        color: var(--hot-red);
        font-weight: 600;
    }
    
    @media (max-width: 992px) {
        .ppv-content-wrapper {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .related-items {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Adicionar funcionalidade ao botão de prévia
        const previewButton = document.querySelector('.preview-play-button');
        
        previewButton.addEventListener('click', function() {
            // Aqui você pode adicionar o código para exibir a prévia do vídeo
            // Por exemplo, substituir a imagem por um iframe com o vídeo
            alert('Recurso de prévia será implementado em breve!');
        });
        
        // Habilitar botão de compra apenas quando os termos forem aceitos
        const termsCheck = document.getElementById('terms-check');
        const purchaseButton = document.querySelector('.btn-purchase');
        
        termsCheck.addEventListener('change', function() {
            purchaseButton.disabled = !this.checked;
            
            if (this.checked) {
                purchaseButton.style.opacity = '1';
                purchaseButton.style.cursor = 'pointer';
            } else {
                purchaseButton.style.opacity = '0.6';
                purchaseButton.style.cursor = 'not-allowed';
            }
        });
        
        // Desabilitar o botão inicialmente
        purchaseButton.disabled = true;
        purchaseButton.style.opacity = '0.6';
        purchaseButton.style.cursor = 'not-allowed';
        
        // Manipular clique no botão de compra
        purchaseButton.addEventListener('click', function(e) {
            if (!termsCheck.checked) {
                e.preventDefault();
                alert('Você precisa concordar com os termos antes de prosseguir.');
            } else {
                // Implementar lógica de compra
                alert('Processando sua compra... Em breve você receberá acesso ao conteúdo.');
            }
        });
    });
</script>
@endpush 