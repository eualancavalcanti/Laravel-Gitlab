/**
 * Card Click Handler - Sistema dedicado para gerenciar cliques em cards
 * Versão 1.0.0
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('[card-handler] Inicializando manipulador de cliques...');
    
    // Obter modal de vídeo
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) {
        console.error('[card-handler] Modal de vídeo não encontrado!');
        return;
    }

    // Obter elementos do modal
    const modalTitle = document.getElementById('videoModalTitle');
    const modalThumbnail = document.getElementById('videoModalThumbnail');
    const teaserContainer = videoModal.querySelector('.teaser-container');
    const teaserOverlay = videoModal.querySelector('.teaser-overlay');
    const loginOptions = videoModal.querySelector('.login-options');
    const playButton = videoModal.querySelector('.play-button-wrapper');
    
    // Aplicar manipuladores diretamente em todos os cards relevantes
    applyClickHandlersDirectly();
    
    /**
     * Aplica manipuladores de clique diretamente nos elementos
     */
    function applyClickHandlersDirectly() {
        // Cards de conteúdo
        document.querySelectorAll('.hb-content-card').forEach(card => {
            // Remover evento existente
            const newCard = card.cloneNode(true);
            if (card.parentNode) {
                card.parentNode.replaceChild(newCard, card);
            }
            
            // Adicionar novo evento explícito
            newCard.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleCardClick(this);
            });
        });
        
        // Elementos com classe open-video-modal
        document.querySelectorAll('.open-video-modal:not(.content-card)').forEach(element => {
            // Remover evento existente
            const newElement = element.cloneNode(true);
            if (element.parentNode) {
                element.parentNode.replaceChild(newElement, element);
            }
            
            // Adicionar novo evento explícito
            newElement.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleCardClick(this);
            });
        });
        
        // Elementos de HERO
        document.querySelectorAll('.hero .btn-primary.cta').forEach(button => {
            // Remover evento existente
            const newButton = button.cloneNode(true);
            if (button.parentNode) {
                button.parentNode.replaceChild(newButton, button);
            }
            
            // Adicionar novo evento explícito
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                handleCardClick(this);
            });
        });
        
        console.log('[card-handler] Manipuladores aplicados a todos os cards');
    }
    
    /**
     * Manipula o clique em um card
     */
    function handleCardClick(card) {
        console.log('[card-handler] Clique em card detectado:', card);
        
        // Verificar se é um card de pay-per-view
        if (card.getAttribute('data-ppv') === 'true') {
            const videoId = card.getAttribute('data-video-id') || '';
            console.log('[card-handler] Card PPV detectado, redirecionando para:', '/pay-per-view/' + videoId);
            window.location.href = '/pay-per-view/' + videoId;
            return;
        }
        
        // Buscar dados do card
        const title = card.getAttribute('data-title') || 
                      card.querySelector('.content-title')?.textContent || 
                      'Conteúdo';
                      
        const thumbnail = card.getAttribute('data-thumbnail') || 
                          card.querySelector('img')?.src || 
                          '';
                          
        const videoId = card.getAttribute('data-video-id') || '';
        
        const teaserCode = card.getAttribute('data-teaser-code') || '';
        
        // Determinar o tipo de conteúdo
        const isExclusive = card.hasAttribute('data-type') && card.getAttribute('data-type') === 'exclusive';
        const isVip = card.hasAttribute('data-type') && card.getAttribute('data-type') === 'vip';
        
        console.log('[card-handler] Dados do card:', { title, videoId, isExclusive, isVip });
        
        // Configurar o modal
        modalTitle.textContent = title;
        modalThumbnail.src = thumbnail;
        modalThumbnail.alt = title;
        teaserOverlay.style.display = 'flex';
        
        // Configurar modal para assinatura
        if (loginOptions) {
            loginOptions.style.display = 'block';
        }
        
        // Configurar botão de assinatura
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
            
            subscribeBtn.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        // Configurar comportamento do botão de play
        if (playButton) {
            playButton.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        // Exibir o modal
        videoModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    /**
     * Fecha o modal de vídeo
     */
    function fecharModal() {
        videoModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Configurar botão de fechar
    const modalClose = videoModal.querySelector('.modal-close');
    if (modalClose) {
        modalClose.addEventListener('click', fecharModal);
    }
    
    // Fechar ao clicar fora do conteúdo
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            fecharModal();
        }
    });
}); 