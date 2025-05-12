/**
 * Gerenciador de modais de vídeo para HotBoys
 * Correção de bugs e problemas com modais
 * 
 * Este arquivo corrige:
 * - Problemas de backdrop persistente
 * - Modais que não fecham corretamente
 * - Conflitos entre múltiplos modais
 * - Problemas de reprodução de vídeo
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elementos principais do modal
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) return;
    
    // Remover quaisquer eventos anteriores para evitar duplicação
    clearVideoModalEvents();
    
    // Obter referências aos elementos internos
    const modalClose = videoModal.querySelector('.modal-close');
    const modalTitle = document.getElementById('videoModalTitle');
    const modalThumbnail = document.getElementById('videoModalThumbnail');
    const teaserContainer = videoModal.querySelector('.teaser-container');
    const teaserOverlay = videoModal.querySelector('.teaser-overlay');
    const loginOptions = videoModal.querySelector('.login-options');
    const loadingIndicator = document.getElementById('videoLoading');
    const playButton = videoModal.querySelector('.play-button-wrapper');
    
    /**
     * Limpa eventos existentes para evitar duplicações
     */
    function clearVideoModalEvents() {
        // Limpar botão de fechar
        const closeBtn = videoModal.querySelector('.modal-close');
        if (closeBtn) {
            const newCloseBtn = closeBtn.cloneNode(true);
            closeBtn.parentNode.replaceChild(newCloseBtn, closeBtn);
        }
        
        // Limpar cliques no modal para fechamento
        const newModal = videoModal.cloneNode(false);
        while (videoModal.firstChild) {
            newModal.appendChild(videoModal.firstChild);
        }
        if (videoModal.parentNode) {
            videoModal.parentNode.replaceChild(newModal, videoModal);
        }
    }
    
    /**
     * Abre o modal de vídeo e configura com base no tipo de conteúdo
     */
    function openVideoModal(card) {
        if (!card) return;
        
        // Buscar informações do card
        const title = card.querySelector('.content-title')?.textContent || 'Vídeo';
        const thumbnail = card.querySelector('img')?.src || '';
        const videoId = card.getAttribute('data-video-id') || '';
        const teaserCode = card.getAttribute('data-teaser-code') || '';
        const duration = card.querySelector('.content-duration')?.textContent || '00:00';
        
        // Determinar o tipo de conteúdo
        const isExclusive = card.querySelector('.content-badge.exclusive') !== null || 
                           card.closest('#exclusive') !== null;
        const isVip = card.querySelector('.content-badge.vip') !== null;
        
        // Configurar o título e thumbnail
        if (modalTitle) modalTitle.textContent = title;
        if (modalThumbnail) {
            modalThumbnail.src = thumbnail;
            modalThumbnail.alt = title;
        }
        
        // Remover players anteriores para evitar múltiplos vídeos rodando
        if (teaserContainer) {
            teaserContainer.innerHTML = '';
        }
        
        // Configuração específica com base no tipo de conteúdo
        if (isExclusive) {
            // Configuração para Conteúdo Exclusivo
            configurarModoExclusivo(card);
        } else if (isVip) {
            // Configuração para Conteúdo VIP
            configurarModoVip(card, teaserCode, videoId);
        } else {
            // Configuração padrão (fallback)
            configurarModoPadrao(card);
        }
        
        // Mostrar o modal
        showVideoModal();
    }
    
    /**
     * Mostra o modal de vídeo - CORRIGIDO
     */
    function showVideoModal() {
        // Fechar outros modais se estiverem abertos
        const otherModals = document.querySelectorAll('.modal.show');
        otherModals.forEach(modal => {
            if (modal !== videoModal) {
                modal.classList.remove('show');
                modal.style.display = 'none';
            }
        });
        
        // Adicionar backdrop se não existir
        if (!document.querySelector('.modal-backdrop')) {
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
        
        // Mostrar o modal
        videoModal.classList.add('show');
        videoModal.style.display = 'block';
        
        // Bloquear rolagem do body
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Calcular e compensar a largura da barra de rolagem
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }
    }
    
    /**
     * Configuração para conteúdo exclusivo (que requer compra) - CORRIGIDO
     */
    function configurarModoExclusivo(card) {
        // Mostrar thumbnail com overlay para incentivar a compra
        if (modalThumbnail) modalThumbnail.style.display = 'block';
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loginOptions) loginOptions.style.display = 'block';
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        
        // Atualizar o texto e comportamento do botão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        if (subscribeBtn) {
            subscribeBtn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                Comprar Conteúdo
            `;
            
            // Remover eventos antigos e adicionar novo
            const newSubscribeBtn = subscribeBtn.cloneNode(true);
            subscribeBtn.parentNode.replaceChild(newSubscribeBtn, subscribeBtn);
            
            // Configurar o clique no botão de compra
            newSubscribeBtn.addEventListener('click', function() {
                abrirLoginModal();
            });
        }
        
        // Atualizar informações de preço se disponível
        const priceElement = card.querySelector('.content-price');
        if (priceElement) {
            const priceDisplay = videoModal.querySelector('.option-price .price');
            if (priceDisplay) {
                priceDisplay.textContent = priceElement.textContent;
            }
        }
        
        // Configurar o clique no botão de play para abrir login
        if (playButton) {
            // Remover eventos antigos e adicionar novo
            const newPlayButton = playButton.cloneNode(true);
            playButton.parentNode.replaceChild(newPlayButton, playButton);
            
            newPlayButton.addEventListener('click', function() {
                abrirLoginModal();
            });
        }
    }
    
    /**
     * Configuração para conteúdo VIP (que mostra teaser) - CORRIGIDO
     */
    function configurarModoVip(card, teaserCode, videoId) {
        // Preparar para mostrar o teaser
        if (modalThumbnail) modalThumbnail.style.display = 'none';
        if (teaserOverlay) teaserOverlay.style.display = 'none';
        if (loginOptions) loginOptions.style.display = 'block';
        if (loadingIndicator) loadingIndicator.style.display = 'block';
        
        let hasValidTeaser = false;
        
        // Se tiver código de teaser, inserir o player
        if (teaserCode && teaserCode.trim() !== '') {
            hasValidTeaser = true;
            insertTeaser(teaserCode);
        } 
        // Se não tiver código mas tiver ID, tentar gerar um player
        else if (videoId && videoId.trim() !== '') {
            hasValidTeaser = true;
            const generatedTeaser = `<iframe allow="autoplay; fullscreen;" allowfullscreen class="jmvplayer" frameborder="0" src="https://player.jmvstream.com/qAGjxuwNoNQIj2i9kkVHgLMIxUuMu7/${videoId}" width="100%" height="100%"></iframe>`;
            insertTeaser(generatedTeaser);
        } 
        // Caso não tenha nenhuma opção, mostrar fallback
        else {
            showFallbackThumbnail();
        }
        
        // Atualizar o texto e comportamento do botão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        if (subscribeBtn) {
            subscribeBtn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                Assinar VIP
            `;
            
            // Remover eventos antigos e adicionar novo
            const newSubscribeBtn = subscribeBtn.cloneNode(true);
            subscribeBtn.parentNode.replaceChild(newSubscribeBtn, subscribeBtn);
            
            // Configurar o clique no botão de assinatura
            newSubscribeBtn.addEventListener('click', function() {
                abrirLoginModal();
            });
        }
        
        // Configurar o clique no botão de play (caso o teaser não carregue)
        if (playButton) {
            // Remover eventos antigos e adicionar novo
            const newPlayButton = playButton.cloneNode(true);
            playButton.parentNode.replaceChild(newPlayButton, playButton);
            
            newPlayButton.addEventListener('click', function() {
                // Se estiver visível, significa que o teaser não carregou
                if (teaserOverlay && 
                    (teaserOverlay.style.display === 'flex' || 
                     getComputedStyle(teaserOverlay).display === 'flex')) {
                    abrirLoginModal();
                }
            });
        }
        
        /**
         * Insere o teaser no container com tratamento de erro
         */
        function insertTeaser(code) {
            if (!teaserContainer) return;
            
            // Criar elemento para o player
            const playerContainer = document.createElement('div');
            playerContainer.className = 'teaser-player';
            playerContainer.innerHTML = code;
            teaserContainer.appendChild(playerContainer);
            
            // Quando o iframe carregar, esconder o indicador de carregamento
            const iframe = playerContainer.querySelector('iframe');
            if (iframe) {
                iframe.onload = function() {
                    if (loadingIndicator) loadingIndicator.style.display = 'none';
                };
                
                // Tratar erro de carregamento do iframe
                iframe.onerror = function() {
                    showFallbackThumbnail();
                };
                
                // Se o iframe não carregar em 5 segundos, mostrar fallback
                setTimeout(function() {
                    if (loadingIndicator && 
                        (loadingIndicator.style.display === 'block' || 
                         getComputedStyle(loadingIndicator).display === 'block')) {
                        showFallbackThumbnail();
                    }
                }, 5000);
            } else {
                // Se não tiver iframe no código, mostrar fallback
                showFallbackThumbnail();
            }
        }
        
        /**
         * Mostra a thumbnail de fallback quando o teaser falha
         */
        function showFallbackThumbnail() {
            if (loadingIndicator) loadingIndicator.style.display = 'none';
            if (modalThumbnail) modalThumbnail.style.display = 'block';
            if (teaserOverlay) teaserOverlay.style.display = 'flex';
        }
    }
    
    /**
     * Configuração padrão para outros tipos de conteúdo - CORRIGIDO
     */
    function configurarModoPadrao(card) {
        // Mostrar thumbnail com overlay
        if (modalThumbnail) modalThumbnail.style.display = 'block';
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loginOptions) loginOptions.style.display = 'block';
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        
        // Atualizar botão para ação padrão
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        if (subscribeBtn) {
            subscribeBtn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                Assinar Agora
            `;
            
            // Remover eventos antigos e adicionar novo
            const newSubscribeBtn = subscribeBtn.cloneNode(true);
            subscribeBtn.parentNode.replaceChild(newSubscribeBtn, subscribeBtn);
            
            // Configurar o clique no botão de assinatura
            newSubscribeBtn.addEventListener('click', function() {
                abrirLoginModal();
            });
        }
        
        // Configurar o clique no botão de play
        if (playButton) {
            // Remover eventos antigos e adicionar novo
            const newPlayButton = playButton.cloneNode(true);
            playButton.parentNode.replaceChild(newPlayButton, playButton);
            
            newPlayButton.addEventListener('click', function() {
                abrirLoginModal();
            });
        }
    }
    
    /**
     * Abre o modal de login/registro - CORRIGIDO
     */
    function abrirLoginModal() {
        // Fechar o modal de vídeo corretamente
        fecharModal();
        
        // Limpar quaisquer modais em conflito
        setTimeout(function() {
            // Remover qualquer backdrop existente
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            
            // Abrir o modal de login (se existir)
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.classList.add('show');
                loginModal.style.display = 'block';
                
                // Adicionar backdrop novo
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
                
                // Manter corpo com rollagem bloqueada
                document.body.classList.add('modal-open');
                document.body.style.overflow = 'hidden';
            }
        }, 100); // Pequeno delay para garantir que o fechamento do modal anterior foi concluído
    }
    
    /**
     * Fecha o modal de vídeo - CORRIGIDO COMPLETAMENTE
     * Este é o principal ponto de correção onde o botão de fechar não funcionava corretamente
     */
    function fecharModal() {
        // Remover players para interromper a reprodução
        if (teaserContainer) {
            teaserContainer.innerHTML = '';
        }
        
        // Esconder o modal
        videoModal.classList.remove('show');
        videoModal.style.display = 'none';
        
        // IMPORTANTE: Remover TODOS os backdrops independentemente de outros modais
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => {
            backdrop.remove();
        });
        
        // IMPORTANTE: Limpar sempre o estado do body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Se houver algum outro modal para mostrar, ele deve adicionar seu próprio backdrop
        // e configurar o body novamente
    }
    
    // Configurar botão de fechar - CORREÇÃO PRINCIPAL
    if (modalClose) {
        modalClose.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Impedir propagação do evento
            fecharModal(); // Usar a função corrigida
        });
    }
    
    // Fechar modal ao clicar fora do conteúdo
    videoModal.addEventListener('click', function(e) {
        // Verificar se o clique foi diretamente no backdrop, não em seus filhos
        if (e.target === videoModal) {
            fecharModal();
        }
    });
    
    // Fechar modal ao pressionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.classList.contains('show')) {
            fecharModal();
        }
    });
    
    // Expor a função de abertura do modal para outros scripts
    window.openVideoModal = openVideoModal;
    
    // Configurar todos os cards de conteúdo
    const contentCards = document.querySelectorAll('.hb-content-card');
    contentCards.forEach(card => {
        card.addEventListener('click', function() {
            openVideoModal(this);
        });
    });
    
    // Adicionar botão de emergência (invisível por padrão)
    const resetButton = document.createElement('button');
    resetButton.textContent = 'Resetar Modais';
    resetButton.style.position = 'fixed';
    resetButton.style.bottom = '10px';
    resetButton.style.right = '10px';
    resetButton.style.zIndex = '9999';
    resetButton.style.background = '#FF3333';
    resetButton.style.color = 'white';
    resetButton.style.border = 'none';
    resetButton.style.borderRadius = '5px';
    resetButton.style.padding = '10px 15px';
    resetButton.style.display = 'none';
    resetButton.style.fontWeight = 'bold';
    resetButton.style.cursor = 'pointer';
    resetButton.className = 'modal-reset-button';
    
    document.body.appendChild(resetButton);
    
    // Verificar após 3 segundos se há problemas
    setTimeout(function() {
        const modalBackdrop = document.querySelector('.modal-backdrop');
        const openModal = document.querySelector('.modal.show');
        
        if ((modalBackdrop && !openModal) || 
            (document.body.classList.contains('modal-open') && !openModal)) {
            resetButton.style.display = 'block';
        }
    }, 3000);
    
    // Comportamento do botão de emergência
    resetButton.addEventListener('click', function() {
        // Remover todos os backdrops
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
        
        // Fechar todos os modais
        document.querySelectorAll('.modal.show').forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        
        // Limpar o body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Esconder botão
        this.style.display = 'none';
    });
});