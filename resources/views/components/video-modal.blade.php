<div id="videoModal" class="content-modal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 id="videoModalTitle" class="modal-title">Título do Vídeo</h3>
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
                    <div class="teaser-duration" id="videoModalDuration">0:30</div>
                </div>
                <div class="loading-indicator" id="videoLoading"></div>
                <img id="videoModalThumbnail" class="teaser-image" src="" alt="Miniatura do vídeo">
                <!-- O vídeo será inserido aqui via JavaScript -->
            </div>
            
            <div class="content-info-container">
                <div class="content-stats">
                    <div class="stat">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <span id="videoViewersCount">1.2K assistindo</span>
                    </div>
                </div>
                
                <div class="content-description">
                    <p>Para assistir ao conteúdo completo, você precisa estar logado. Escolha uma das opções abaixo:</p>
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