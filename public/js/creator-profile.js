/**
 * HotBoys - Sistema Unificado de Modais
 * 
 * Este arquivo contém funções otimizadas para gerenciamento de modais
 * na nova versão do HotBoys. Resolve problemas com:
 * - Backdrop persistente após fechar modais
 * - Conflitos entre múltiplos modais
 * - Bloqueio da interface após fechar modais
 */

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar todos os sistemas
    setupTabs();
    setupLoginTabs();
    setupModalSystem();
    setupContentCards();
    setupImageErrorHandling();
    setupAnimations();
});

/**
 * Sistema unificado de modais - CORRIGIDO
 * Resolve problemas de backdrop persistente e modais congelados
 */
function setupModalSystem() {
    // Limpar quaisquer elementos de backdrop que possam ter ficado de sessões anteriores
    const oldBackdrops = document.querySelectorAll('.modal-backdrop');
    oldBackdrops.forEach(backdrop => backdrop.remove());
    
    // Remover classes de modal aberto do body
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    
    // Configurar botões de fechar para todos os modais
    const closeButtons = document.querySelectorAll('.modal .close, .modal .modal-close, [data-dismiss="modal"]');
    closeButtons.forEach(button => {
        // Limpar listeners antigos para evitar duplicação
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        newButton.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = this.closest('.modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });
    
    // Fechar ao clicar fora do modal
    document.addEventListener('click', function(e) {
        if ((e.target.classList.contains('modal') && !e.target.querySelector('.modal-dialog:hover')) || 
            e.target.classList.contains('modal-backdrop')) {
            const openModals = document.querySelectorAll('.modal.show, .modal[style*="display: block"]');
            openModals.forEach(modal => closeModal(modal));
        }
    });
    
    // Fechar com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal.show, .modal[style*="display: block"]');
            if (openModals.length > 0) {
                openModals.forEach(modal => closeModal(modal));
            }
        }
    });
    
    // Configurar gatilhos de modal
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    modalTriggers.forEach(trigger => {
        // Limpar listeners antigos para evitar duplicação
        const newTrigger = trigger.cloneNode(true);
        trigger.parentNode.replaceChild(newTrigger, trigger);
        
        newTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSelector = this.getAttribute('data-target');
            const targetModal = document.querySelector(targetSelector);
            
            if (targetModal) {
                openModal(targetModal);
            }
        });
    });
}

/**
 * Abre um modal de forma consistente - CORRIGIDO
 * Garante que apenas um modal esteja aberto por vez
 */
function openModal(modal) {
    if (!modal) return;
    
    // Fechar qualquer modal existente primeiro
    const openModals = document.querySelectorAll('.modal.show, .modal[style*="display: block"]');
    openModals.forEach(m => {
        if (m !== modal) closeModal(m);
    });
    
    // Mostrar o modal
    modal.classList.add('show');
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
    
    // Calcular a largura da barra de rolagem
    const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
    if (scrollbarWidth > 0) {
        document.body.style.paddingRight = scrollbarWidth + 'px';
    }
    
    // Bloquear rolagem
    document.body.style.overflow = 'hidden';
    
    // Adicionar backdrop se não existir
    if (!document.querySelector('.modal-backdrop')) {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }
}

/**
 * Fecha um modal de forma consistente - CORRIGIDO
 * Garante a limpeza completa de todos os elementos e estilos
 */
function closeModal(modal) {
    if (!modal) return;
    
    // Remover iframe players para evitar reprodução em segundo plano
    const iframes = modal.querySelectorAll('iframe');
    iframes.forEach(iframe => {
        // Clonar e substituir para parar reprodução
        const parent = iframe.parentNode;
        if (parent) {
            parent.innerHTML = '';
        }
    });
    
    // Esconder o modal
    modal.classList.remove('show');
    modal.style.display = 'none';
    
    // Verificar se ainda há modais abertos
    const anyModalOpen = document.querySelector('.modal.show, .modal[style*="display: block"]');
    if (!anyModalOpen) {
        // Restaurar rolagem apenas se não houver outros modais abertos
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Remover backdrop
        const backdrops = document.querySelectorAll('.modal-backdrop');
        backdrops.forEach(backdrop => backdrop.remove());
    }
}

/**
 * Configuração de cards de conteúdo - CORRIGIDO
 * Evita problemas de propagação de eventos
 */
function setupContentCards() {
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        // Limpar listeners antigos para evitar duplicação
        const newCard = card.cloneNode(true);
        card.parentNode.replaceChild(newCard, card);
        
        newCard.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Evitar propagação
            
            // Determinar tipo de conteúdo
            const isExclusive = this.closest('#exclusive') !== null || 
                              this.querySelector('.content-badge.exclusive') !== null;
            
            // Usar variável para teaser_code
            const teaserCode = this.getAttribute('data-teaser-code') || '';
            const videoId = this.getAttribute('data-video-id') || '';
            
            if (isExclusive) {
                // Mostrar modal do criador para conteúdo exclusivo
                handleExclusiveContent(this);
            } else {
                // Usar modal de vídeo para outros conteúdos (VIP)
                handleVipContent(this, teaserCode, videoId);
            }
        });
    });
}

/**
 * Manipulador de conteúdo exclusivo - CORRIGIDO
 */
function handleExclusiveContent(card) {
    const title = card.querySelector('.content-title')?.textContent || 'Conteúdo Exclusivo';
    const loginModal = document.getElementById('loginModal');
    
    if (loginModal) {
        // Configurar o título do modal para informar qual conteúdo está sendo acessado
        const loginTitle = loginModal.querySelector('.modal-title');
        if (loginTitle) {
            loginTitle.textContent = `Acesse o conteúdo exclusivo: ${title}`;
        }
        
        // Abrir o modal de login
        openModal(loginModal);
    }
}

/**
 * Manipulador de conteúdo VIP - CORRIGIDO
 */
function handleVipContent(card, teaserCode, videoId) {
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) return;
    
    // Obter informações do card
    const title = card.querySelector('.content-title')?.textContent || 'Vídeo';
    const thumbnail = card.querySelector('img')?.src || '';
    
    // Obter elementos do modal
    const modalTitle = videoModal.querySelector('#videoModalTitle');
    const modalThumbnail = videoModal.querySelector('#videoModalThumbnail');
    const teaserContainer = videoModal.querySelector('.teaser-container');
    const teaserOverlay = videoModal.querySelector('.teaser-overlay');
    const loadingIndicator = videoModal.querySelector('#videoLoading');
    
    // Configurar título e thumbnail
    if (modalTitle) modalTitle.textContent = title;
    if (modalThumbnail) {
        modalThumbnail.src = thumbnail;
        modalThumbnail.alt = title;
    }
    
    // Limpar qualquer player existente
    if (teaserContainer) {
        teaserContainer.innerHTML = '';
    }
    
    // Iniciar carregamento do teaser
    if (loadingIndicator) loadingIndicator.style.display = 'block';
    if (modalThumbnail) modalThumbnail.style.display = 'none';
    if (teaserOverlay) teaserOverlay.style.display = 'none';
    
    // Inserir teaser se disponível
    if (teaserCode && teaserCode.trim() !== '') {
        const playerContainer = document.createElement('div');
        playerContainer.className = 'teaser-player';
        playerContainer.innerHTML = teaserCode;
        
        if (teaserContainer) {
            teaserContainer.appendChild(playerContainer);
        }
        
        // Ocultar loading quando o iframe carregar
        const iframe = playerContainer.querySelector('iframe');
        if (iframe) {
            iframe.onload = function() {
                if (loadingIndicator) loadingIndicator.style.display = 'none';
            };
            
            // Timeout de segurança
            setTimeout(function() {
                if (loadingIndicator && loadingIndicator.style.display !== 'none') {
                    loadingIndicator.style.display = 'none';
                    if (modalThumbnail) modalThumbnail.style.display = 'block';
                    if (teaserOverlay) teaserOverlay.style.display = 'flex';
                }
            }, 5000);
        }
    } else {
        // Se não tiver código teaser mas tiver ID de vídeo, tentar gerar
        if (videoId && videoId.trim() !== '') {
            const generatedTeaser = `<iframe allow="autoplay; fullscreen;" allowfullscreen class="jmvplayer" frameborder="0" src="https://player.jmvstream.com/qAGjxuwNoNQIj2i9kkVHgLMIxUuMu7/${videoId}" width="100%" height="100%"></iframe>`;
            
            const playerContainer = document.createElement('div');
            playerContainer.className = 'teaser-player';
            playerContainer.innerHTML = generatedTeaser;
            
            if (teaserContainer) {
                teaserContainer.appendChild(playerContainer);
            }
            
            // Timeout de segurança
            setTimeout(function() {
                if (loadingIndicator) loadingIndicator.style.display = 'none';
            }, 5000);
        } else {
            // Mostrar thumbnail se não houver teaser nem ID
            if (loadingIndicator) loadingIndicator.style.display = 'none';
            if (modalThumbnail) modalThumbnail.style.display = 'block';
            if (teaserOverlay) teaserOverlay.style.display = 'flex';
        }
    }
    
    // Abrir modal
    openModal(videoModal);
}

/**
 * Configura o sistema de abas do perfil - CORRIGIDO
 */
function setupTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        // Limpar listeners antigos para evitar duplicação
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        newButton.addEventListener('click', function() {
            // Remover classe ativa de todos os botões e conteúdos
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Adicionar classe ativa ao botão clicado
            this.classList.add('active');
            
            // Mostrar conteúdo correspondente
            const tabId = this.getAttribute('data-tab');
            const tabContent = document.getElementById(tabId);
            if (tabContent) {
                tabContent.classList.add('active');
            }
            
            // Opcional: salvar preferência
            if (window.localStorage) {
                localStorage.setItem('preferredTab', tabId);
            }
        });
    });
    
    // Restaurar última aba ativa
    if (window.localStorage) {
        const lastTab = localStorage.getItem('preferredTab');
        if (lastTab) {
            const targetTab = document.querySelector(`.tab-btn[data-tab="${lastTab}"]`);
            if (targetTab) {
                targetTab.click();
            }
        }
    }
}

/**
 * Configura animações para elementos da página - CORRIGIDO
 */
function setupAnimations() {
    // Animação para cards de conteúdo
    const contentCards = document.querySelectorAll('.content-card');
    contentCards.forEach((card, index) => {
        // Adicionar animação escalonada
        setTimeout(() => {
            card.classList.add('animated');
        }, index * 50); // Reduzido de 100 para 50ms para melhorar performance
    });
    
    // Interatividade para a foto do perfil
    const profilePhoto = document.querySelector('.profile-photo');
    if (profilePhoto) {
        profilePhoto.addEventListener('mouseenter', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = 'scale(1.05)';
            }
        });
        
        profilePhoto.addEventListener('mouseleave', function() {
            const img = this.querySelector('img');
            if (img) {
                img.style.transform = '';
            }
        });
    }
}

/**
 * Configura as abas do modal de login - CORRIGIDO
 */
function setupLoginTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.login-tab-content');
    
    tabButtons.forEach(button => {
        // Limpar listeners antigos para evitar duplicação
        const newButton = button.cloneNode(true);
        button.parentNode.replaceChild(newButton, button);
        
        newButton.addEventListener('click', function() {
            // Remover classes ativas
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Adicionar classe ativa ao botão clicado
            this.classList.add('active');
            
            // Mostrar conteúdo correspondente
            const tabId = this.getAttribute('data-tab') + '-tab';
            const tabContent = document.getElementById(tabId);
            if (tabContent) tabContent.classList.add('active');
        });
    });
}

/**
 * Configura o tratamento de erros para imagens - CORRIGIDO
 */
function setupImageErrorHandling() {
    // URL de fallback local - não depende de serviços externos
    const fallbackUrl = '/images/placeholder.jpg';
    
    // Adicionar evento onerror em todas as imagens
    document.querySelectorAll('img').forEach(img => {
        // Remover handler existente para evitar duplicação
        img.onerror = null;
        
        img.addEventListener('error', function() {
            // Evitar loop infinito
            this.onerror = null;
            
            // Verificar contexto da imagem
            if (this.closest('#exclusive .content-card')) {
                // Para conteúdo exclusivo, esconder a imagem para fundo preto
                this.style.display = 'none';
            } else {
                // Para outros conteúdos, usar fallback
                this.src = fallbackUrl;
            }
        });
    });
}