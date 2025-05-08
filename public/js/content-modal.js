/**
 * Gerenciador de modais de vídeo para HotBoys
 * Lida com conteúdo VIP e Exclusivo de maneira otimizada
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('[content-modal] Inicializando gerenciador de modais de vídeo...');
    
    // Elementos principais do modal
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) {
        console.error('[content-modal] Modal de vídeo não encontrado no DOM!');
        return;
    }
    
    const modalClose = videoModal.querySelector('.modal-close');
    const modalTitle = document.getElementById('videoModalTitle');
    const modalThumbnail = document.getElementById('videoModalThumbnail');
    const teaserContainer = videoModal.querySelector('.teaser-container');
    const teaserOverlay = videoModal.querySelector('.teaser-overlay');
    const loginOptions = videoModal.querySelector('.login-options');
    const loadingIndicator = document.getElementById('videoLoading');
    const playButton = videoModal.querySelector('.play-button-wrapper');
    
    // Verificar componentes essenciais
    if (!teaserContainer || !teaserOverlay || !loginOptions || !playButton) {
        console.error('[content-modal] Componentes essenciais do modal não encontrados!', {
            teaserContainer: !!teaserContainer,
            teaserOverlay: !!teaserOverlay,
            loginOptions: !!loginOptions,
            playButton: !!playButton
        });
    }
    
    console.log('[content-modal] Registrando manipuladores de clique para todos os tipos de cards...');
    
    // A solução mais eficaz - usar um event listener único no documento
    document.addEventListener('click', function(e) {
        // Verificar todos os possíveis seletores de cards em ordem de especificidade
        const targetSelectors = [
            '.content-card',                // Cards de conteúdo padrão
            '.open-video-modal',            // Classe genérica para abrir modal
            '.hero .btn-primary.cta',       // Botão CTA do Hero
            '.hero-slide'                   // Slide do Hero (clicável)
        ];
        
        // Encontrar o elemento clicável mais próximo
        let clickedElement = null;
        
        for (const selector of targetSelectors) {
            if (e.target.matches(selector) || e.target.closest(selector)) {
                clickedElement = e.target.matches(selector) ? e.target : e.target.closest(selector);
                break;
            }
        }
        
        // Se não encontramos nenhum elemento clicável, retornar
        if (!clickedElement) return;
        
        console.log('[content-modal] Clique detectado em:', clickedElement);
        
        // Verificar se é um elemento de pay-per-view
        const isPpv = clickedElement.getAttribute('data-ppv') === 'true';
        
        // Se for PPV, redirecionar para a página de pay-per-view
        if (isPpv) {
            const videoId = clickedElement.getAttribute('data-video-id') || '';
            console.log('[content-modal] Elemento PPV detectado, redirecionando para:', '/pay-per-view/' + videoId);
            window.location.href = '/pay-per-view/' + videoId;
            return;
        }
        
        // Impedir comportamento padrão para evitar navegação
        e.preventDefault();
        e.stopPropagation();
        
        // Abrir o modal
        openVideoModal(clickedElement);
    });
    
    /**
     * Abre o modal de vídeo e configura com base no tipo de conteúdo
     */
    function openVideoModal(card) {
        if (!card) {
            console.error('[content-modal] Tentativa de abrir modal sem card válido');
            return;
        }
        
        console.log('[content-modal] Abrindo modal para card:', card);
        
        // Buscar informações do card
        // Primeiro tenta buscar pelos novos elementos com classe, depois pelos atributos de dados
        const title = card.querySelector('.content-title')?.textContent || 
                     card.getAttribute('data-title') || 
                     'Vídeo';
                     
        const thumbnail = card.querySelector('img')?.src || 
                          card.getAttribute('data-thumbnail') || 
                          '';
                          
        const videoId = card.getAttribute('data-video-id') || '';
        
        const teaserCode = card.getAttribute('data-teaser-code') || '';
        
        const duration = card.querySelector('.content-duration')?.textContent || 
                        card.getAttribute('data-duration') || 
                        '00:00';
        
        // Determinar o tipo de conteúdo
        const isExclusive = card.querySelector('.content-badge.exclusive') !== null || 
                           card.getAttribute('data-type') === 'exclusive';
                           
        const isVip = card.querySelector('.content-badge.vip') !== null || 
                     card.getAttribute('data-type') === 'vip';
        
        console.log('[content-modal] Dados do card:', {
            title, videoId, isExclusive, isVip
        });
        
        // Configurar o título e thumbnail
        modalTitle.textContent = title;
        modalThumbnail.src = thumbnail;
        modalThumbnail.alt = title;
        
        // Atualizar o contador de visualizações
        const viewersCount = card.querySelector('.viewers-count')?.textContent || '1.2K';
        const viewersElement = document.getElementById('videoViewersCount');
        if (viewersElement) {
            viewersElement.textContent = viewersCount + ' assistindo';
        }
        
        // Atualizar duração
        const durationElement = document.getElementById('videoModalDuration');
        if (durationElement) {
            durationElement.textContent = duration;
        }
        
        // Remover players anteriores para evitar múltiplos vídeos rodando
        const existingPlayers = teaserContainer.querySelectorAll('.teaser-player, iframe');
        existingPlayers.forEach(player => player.remove());
        
        // Configuração específica com base no tipo de conteúdo
        if (isExclusive) {
            // Configuração para Conteúdo Exclusivo
            configurarModoExclusivo(card);
        } else if (isVip) {
            // Configuração para Conteúdo VIP
            configurarModoVip(card, teaserCode);
        } else {
            // Configuração padrão (fallback)
            configurarModoPadrao(card);
        }
        
        // Mostrar o modal
        videoModal.style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevenir rolagem da página
    }
    
    /**
     * Configuração para conteúdo exclusivo (que requer compra)
     */
    function configurarModoExclusivo(card) {
        // Mostrar thumbnail com overlay para incentivar a compra
        modalThumbnail.style.display = 'block';
        teaserOverlay.style.display = 'flex';
        loginOptions.style.display = 'block';
        
        // Atualizar o texto e comportamento do botão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        subscribeBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Comprar Conteúdo
        `;
        
        // Atualizar informações de preço se disponível
        const priceElement = card.querySelector('.content-price');
        if (priceElement) {
            const priceDisplay = videoModal.querySelector('.option-price .price');
            if (priceDisplay) {
                priceDisplay.textContent = priceElement.textContent;
            }
        }
        
        // Configurar o clique no botão de play para abrir login
        playButton.onclick = function() {
            abrirLoginModal();
        };
        
        // Configurar o clique no botão de compra
        subscribeBtn.onclick = function() {
            abrirLoginModal();
        };
    }
    
    /**
     * Configuração para conteúdo VIP (que mostra teaser)
     */
    function configurarModoVip(card, teaserCode) {
        // Preparar para mostrar o teaser
        modalThumbnail.style.display = 'none';
        teaserOverlay.style.display = 'none';
        loginOptions.style.display = 'block';
        loadingIndicator.style.display = 'block';
        
        // Se tiver código de teaser, inserir o player
        if (teaserCode && teaserCode.trim() !== '') {
            // Criar elemento para o player
            const playerContainer = document.createElement('div');
            playerContainer.className = 'teaser-player';
            playerContainer.innerHTML = teaserCode;
            teaserContainer.appendChild(playerContainer);
            
            // Quando o iframe carregar, esconder o indicador de carregamento
            const iframe = playerContainer.querySelector('iframe');
            if (iframe) {
                iframe.onload = function() {
                    loadingIndicator.style.display = 'none';
                };
                
                // Se o iframe não carregar em 5 segundos, mostrar fallback
                setTimeout(function() {
                    if (loadingIndicator.style.display !== 'none') {
                        loadingIndicator.style.display = 'none';
                        modalThumbnail.style.display = 'block';
                        teaserOverlay.style.display = 'flex';
                    }
                }, 5000);
            }
        } else {
            // Se não tiver teaser, mostrar thumbnail com overlay
            loadingIndicator.style.display = 'none';
            modalThumbnail.style.display = 'block';
            teaserOverlay.style.display = 'flex';
        }
        
        // Atualizar o texto e comportamento do botão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        subscribeBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Assinar VIP
        `;
        
        // Configurar o clique no botão de assinatura
        subscribeBtn.onclick = function() {
            abrirLoginModal();
        };
        
        // Configurar o clique no botão de play (caso o teaser não carregue)
        playButton.onclick = function() {
            // Se estiver visível, significa que o teaser não carregou
            if (teaserOverlay.style.display === 'flex') {
                abrirLoginModal();
            }
        };
    }
    
    /**
     * Configuração padrão para outros tipos de conteúdo
     */
    function configurarModoPadrao(card) {
        // Mostrar thumbnail com overlay
        modalThumbnail.style.display = 'block';
        teaserOverlay.style.display = 'flex';
        loginOptions.style.display = 'block';
        
        // Atualizar botão para ação padrão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        subscribeBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Assinar Agora
        `;
        
        // Configurar ações para botões
        playButton.onclick = function() {
            abrirLoginModal();
        };
        
        subscribeBtn.onclick = function() {
            abrirLoginModal();
        };
    }
    
    /**
     * Abre o modal de login/registro
     */
    function abrirLoginModal() {
        // Fechar o modal de vídeo
        fecharModal();
        
        // Abrir o modal de login (se existir)
        const loginModal = document.getElementById('loginModal');
        if (loginModal) {
            loginModal.classList.add('show');
        }
    }
    
    /**
     * Fecha o modal de vídeo
     */
    function fecharModal() {
        // Remover players para interromper a reprodução
        const players = teaserContainer.querySelectorAll('.teaser-player, iframe');
        players.forEach(player => player.remove());
        
        // Esconder o modal
        videoModal.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restaurar rolagem da página
    }
    
    // Configurar botão de fechar
    if (modalClose) {
        modalClose.addEventListener('click', fecharModal);
    }
    
    // Fechar modal ao clicar fora do conteúdo
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            fecharModal();
        }
    });
    
    // Fechar modal ao pressionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.style.display === 'flex') {
            fecharModal();
        }
    });
});