<!-- resources/views/components/content-modal.blade.php -->
<div id="contentModal" class="content-modal" data-teaser-code="">
    <div class="modal-container">
        <div class="modal-header">
            <h3 id="modalTitle" class="modal-title">Título do Conteúdo</h3>
            <button class="modal-close" aria-label="Fechar">&times;</button>
        </div>
        
        <div class="modal-body">
            <div class="teaser-container">
                <div class="teaser-overlay">
                    <div class="play-button-wrapper">
                        <div class="play-button">
                            <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="currentColor" stroke-width="2">
                                <polygon points="5 3 19 12 5 21 5 3"></polygon>
                            </svg>
                        </div>
                    </div>
                    <div class="preview-badge">Prévia</div>
                    <div class="teaser-duration">0:30</div>
                </div>
                <div class="loading-indicator" id="videoLoading">
                    <div class="spinner"></div>
                    <span>Carregando...</span>
                </div>
                <img id="modalThumbnail" class="teaser-image" src="" alt="Miniatura do conteúdo">
                <!-- O vídeo ou iframe será inserido aqui via JavaScript -->
            </div>
            
            <div class="content-info-container">
                <div class="content-stats">
                    <div class="stat">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span id="modalDuration">58:15</span>
                    </div>
                    
                    <div class="stat">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span id="viewersCount">1.2K assistindo</span>
                    </div>
                </div>
                
                <div class="content-description">
                    <p>Para assistir ao conteúdo completo, você precisa estar logado. Escolha uma das opções abaixo:</p>
                </div>
                
                <div class="modal-actions">
                    <button class="btn-watch">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polygon points="10 8 16 12 10 16 10 8"></polygon>
                        </svg>
                        Assistir Completo
                    </button>
                </div>
                
                <div class="login-options">
                    <div class="login-option premium">
                        <div class="option-title">
                            <span class="highlight">Assine</span> e tenha acesso a todo o conteúdo
                        </div>
                        <div class="option-price">
                            <span class="price">R$ 29,90</span>
                            <span class="period">/mês</span>
                        </div>
                        
                        <div class="subscription-benefits">
                            <div class="benefit-item">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Mais de 800 títulos exclusivos</span>
                            </div>
                            <div class="benefit-item">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Novos vídeos adicionados semanalmente</span>
                            </div>
                            <div class="benefit-item">
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                                <span>Qualidade 4K Ultra HD sem restrições</span>
                            </div>
                        </div>
                        
                        <button class="btn-subscribe" data-toggle="modal" data-target="#loginModal">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="8.5" cy="7" r="4"></circle>
                                <polyline points="17 11 19 13 23 9"></polyline>
                            </svg>
                            Assinar Agora
                        </button>
                        
                        <a href="/plans" class="view-plans-link">Conheça outros planos</a>
                    </div>
                </div>
                
                <div class="login-security">
                    <div class="security-info">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span>Pagamento 100% seguro</span>
                    </div>
                    <div class="security-info">
                        <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Privacidade garantida</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Estilos adicionais para o spinner de carregamento e iframe */
.loading-indicator {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
    color: white;
    z-index: 5;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: var(--hot-red);
    animation: spin 1s ease-in-out infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.iframe-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 4;
}

.count-highlight {
    animation: highlight 0.5s ease-in-out;
}

@keyframes highlight {
    0% { color: var(--text-secondary); }
    50% { color: var(--hot-red); }
    100% { color: var(--text-secondary); }
}

/* Melhorias visuais na modal */
.teaser-container {
    position: relative;
    width: 100%;
    padding-top: 56.25%; /* Aspecto 16:9 */
    background-color: #0F0F11;
    border-radius: 8px;
    overflow: hidden;
}

.teaser-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 2;
}

.teaser-video, .teaser-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 4;
}

.teaser-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(0deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 50%, rgba(0,0,0,0.1) 100%);
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
}

.play-button-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
    cursor: pointer;
    transition: transform 0.2s ease;
}

.play-button-wrapper:hover {
    transform: scale(1.1);
}

.play-button {
    width: 64px;
    height: 64px;
    background-color: rgba(255, 51, 51, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 15px rgba(255, 51, 51, 0.5);
}

.preview-badge {
    position: absolute;
    top: 12px;
    right: 12px;
    background-color: var(--hot-red);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
    z-index: 3;
}

.teaser-duration {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background-color: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    z-index: 3;
}
</style>

