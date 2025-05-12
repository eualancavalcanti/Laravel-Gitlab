/**
 * Manipulador Unificado de Modais - Versão V5 (Simplificada e Segura)
 * Solução para modais no HotBoys
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('[unified-modal-handler] Inicializando...');
    
    // Elementos principais do modal
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) {
        console.error('[unified-modal-handler] Modal de vídeo não encontrado no DOM!');
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
        console.error('[unified-modal-handler] Componentes essenciais do modal não encontrados!', {
            teaserContainer: !!teaserContainer,
            teaserOverlay: !!teaserOverlay,
            loginOptions: !!loginOptions,
            playButton: !!playButton
        });
    }
    
    // Adicionar event listeners para os links dos cards
    document.querySelectorAll('.hb-content-card-link').forEach(contentCardLinkElement => {
        contentCardLinkElement.addEventListener('click', function(event) {
            
            // Verifique se o clique foi no seu link de perfil "123"
            // Se o link "123" tiver uma classe específica, use-a aqui.
            // Exemplo: if (event.target.closest('.classe-especifica-do-link-123'))
            // Por agora, vou usar '.view-profile-btn' como placeholder para o link que não deve abrir modal
            if (event.target.closest('.view-profile-btn')) { 
                console.log('[unified-modal-handler] Clique em .view-profile-btn. Navegação permitida.');
                // Não chame event.preventDefault() e saia da função
                return; 
            }
            
            // Se não for o link de perfil, então previna o default e abra o modal
            event.preventDefault(); 
            console.log('[unified-modal-handler] Link clicado (para abrir modal):', this);
            
            const card = this.closest('.content-card');
            const videoId = this.getAttribute('data-video-id');
            const title = this.getAttribute('data-title');
            const thumbnail = card.querySelector('img')?.src || '';
            const teaserCode = card.getAttribute('data-teaser-code') || '';
            const duration = card.querySelector('.content-duration')?.textContent || '00:00';
            
            // Determinar o tipo de conteúdo
            const isExclusive = card.querySelector('.content-badge.exclusive') !== null || 
                              card.getAttribute('data-type') === 'exclusive';
            const isVip = card.querySelector('.content-badge.vip') !== null || 
                         card.getAttribute('data-type') === 'vip';
            
            console.log('[unified-modal-handler] Dados do card:', {
                videoId, title, isExclusive, isVip
            });
            
            // Configurar o título e thumbnail
            if (modalTitle) modalTitle.textContent = title;
            if (modalThumbnail) {
                modalThumbnail.src = thumbnail;
                modalThumbnail.alt = title;
            }
            
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
            abrirModal(videoModal);
        });
    });
    
    // Função para configurar modo exclusivo
    function configurarModoExclusivo(card) {
        console.log('[unified-modal-handler] Configurando modo exclusivo');
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        if (modalThumbnail) modalThumbnail.style.display = 'block';
    }
    
    // Função para configurar modo VIP
    function configurarModoVip(card, teaserCode) {
        console.log('[unified-modal-handler] Configurando modo VIP');
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        if (modalThumbnail) modalThumbnail.style.display = 'block';
    }
    
    // Função para configurar modo padrão
    function configurarModoPadrao(card) {
        console.log('[unified-modal-handler] Configurando modo padrão');
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        if (modalThumbnail) modalThumbnail.style.display = 'block';
    }
    
    // Função para abrir o modal
    function abrirModal(modal) {
        // Remover backdrops existentes
        removeBackdrops();
        
        // Criar novo backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
        
        // Mostrar o modal
        modal.classList.add('show');
        modal.style.display = 'flex';
        
        // Bloquear rolagem da página
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Compensar largura da barra de rolagem
        const larguraScrollbar = window.innerWidth - document.documentElement.clientWidth;
        if (larguraScrollbar > 0) {
            document.body.style.paddingRight = larguraScrollbar + 'px';
        }
    }
    
    // Função para fechar o modal
    function fecharModal(modal) {
        // Parar reprodução de vídeos
        const iframes = modal.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            iframe.src = ''; // Parar reprodução
            
            // Limpar container
            if (iframe.parentNode) {
                iframe.parentNode.innerHTML = '';
            }
        });
        
        // Esconder o modal
        modal.classList.remove('show');
        modal.style.display = 'none';
        
        // Remover TODOS os backdrops
        removeBackdrops();
        
        // Restaurar estado do body
        resetBodyState();
    }
    
    // Função para remover backdrops
    function removeBackdrops() {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    }
    
    // Função para resetar estado do body
    function resetBodyState() {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    // Configurar botão de fechar
    if (modalClose) {
        modalClose.addEventListener('click', () => fecharModal(videoModal));
    }
    
    // Fechar modal ao clicar fora do conteúdo
    videoModal.addEventListener('click', function(e) {
        if (e.target === videoModal) {
            fecharModal(videoModal);
        }
    });
    
    // Fechar modal ao pressionar ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && videoModal.classList.contains('show')) {
            fecharModal(videoModal);
        }
    });
}); 