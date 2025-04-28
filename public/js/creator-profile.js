/**
 * HotBoys - Gerenciador de modais unificado
 * Versão otimizada para conteúdo exclusivo e VIP
 */

document.addEventListener('DOMContentLoaded', function() {
    // Configuração inicial
    setupTabs();
    setupLoginTabs();
    setupModalSystem();
    setupContentCards();
    setupOnlineIndicators();
    setupImageErrorHandling();
    setupAnimations();
});

/**
 * Sistema unificado de modais
 */
function setupModalSystem() {
    // Limpar quaisquer modais temporários que possam ter ficado de sessões anteriores
    const oldExclusiveModals = document.querySelectorAll('#exclusiveModal');
    oldExclusiveModals.forEach(modal => modal.remove());
    
    // Configurar botões de fechar para modais existentes
    const closeButtons = document.querySelectorAll('.modal .close, .modal .modal-close, [data-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const modal = this.closest('.modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });
    
    // Fechar ao clicar fora do modal
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal') || e.target.classList.contains('modal-backdrop')) {
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
    
    // Configurar gatilhos de modal padrão
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function(e) {
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
 * Abre um modal de forma consistente
 */
function openModal(modal) {
    // Fechar qualquer modal existente primeiro
    const openModals = document.querySelectorAll('.modal.show, .modal[style*="display: block"]');
    openModals.forEach(m => {
        if (m !== modal) closeModal(m);
    });
    
    // Mostrar o modal
    modal.classList.add('show');
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
    
    // Adicionar backdrop se não existir
    if (!document.querySelector('.modal-backdrop')) {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }
}

/**
 * Fecha um modal de forma consistente
 */
function closeModal(modal) {
    if (!modal) return;
    
    // Remover iframe players para evitar reprodução em segundo plano
    const iframes = modal.querySelectorAll('iframe');
    iframes.forEach(iframe => iframe.remove());
    
    // Esconder o modal
    modal.classList.remove('show');
    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
    
    // Remover backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
}

/**
 * Configuração de cards de conteúdo
 */
function setupContentCards() {
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Determinar tipo de conteúdo
            const isExclusive = this.closest('#exclusive') !== null || 
                              this.querySelector('.content-badge.exclusive') !== null;
            
            if (isExclusive) {
                // Mostrar modal do criador para conteúdo exclusivo
                handleExclusiveContent(this);
            } else {
                // Usar modal de vídeo para outros conteúdos (VIP)
                handleVipContent(this);
            }
        });
    });
}

/**
 * Manipulador de conteúdo exclusivo
 */
function handleExclusiveContent(card) {
    // Obter dados do perfil do criador
    const creatorName = document.querySelector('.profile-name')?.textContent || 'Modelo';
    const creatorImage = document.querySelector('.profile-photo img')?.src || '';
    const contentTitle = card.querySelector('.content-title')?.textContent || 'Conteúdo Exclusivo';

    // Abrir modal de login diretamente - abordagem simplificada
    const loginModal = document.getElementById('loginModal');
    
    if (loginModal) {
        // Configurar o título do modal para informar qual conteúdo está sendo acessado
        const loginTitle = loginModal.querySelector('.modal-title');
        if (loginTitle) {
            loginTitle.textContent = `Acesse o conteúdo exclusivo: ${contentTitle}`;
        }
        
        // Abrir o modal de login
        openModal(loginModal);
    }
}

/**
 * Manipulador de conteúdo VIP
 */
function handleVipContent(card) {
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) return;
    
    // Obter informações do card
    const title = card.querySelector('.content-title')?.textContent || 'Vídeo';
    const thumbnail = card.querySelector('img')?.src || '';
    const teaserCode = card.getAttribute('data-teaser-code') || '';
    
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
    const existingPlayers = teaserContainer.querySelectorAll('.teaser-player, iframe');
    existingPlayers.forEach(player => player.remove());
    
    // Iniciar carregamento do teaser
    if (loadingIndicator) loadingIndicator.style.display = 'block';
    if (modalThumbnail) modalThumbnail.style.display = 'none';
    if (teaserOverlay) teaserOverlay.style.display = 'none';
    
    // Inserir teaser se disponível
    if (teaserCode && teaserCode.trim() !== '') {
        const playerContainer = document.createElement('div');
        playerContainer.className = 'teaser-player';
        playerContainer.innerHTML = teaserCode;
        teaserContainer.appendChild(playerContainer);
        
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
        // Mostrar thumbnail se não houver teaser
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        if (modalThumbnail) modalThumbnail.style.display = 'block';
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
    }
    
    // Abrir modal
    openModal(videoModal);
}

// Manter as outras funções auxiliares (setupTabs, setupLoginTabs, etc)
// ...

/**
 * Configura os modais Bootstrap
 */
function setupBootstrapModals() {
    // 1. Botões para abrir modal (usando atributo data-target)
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    modalTriggers.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSelector = this.getAttribute('data-target');
            const targetModal = document.querySelector(targetSelector);
            
            if (targetModal) {
                openBootstrapModal(targetModal);
            }
        });
    });
    
    // 2. Botões para fechar modal (usando data-dismiss="modal")
    const closeButtons = document.querySelectorAll('[data-dismiss="modal"]');
    closeButtons.forEach(button => {
        button.addEventListener('click', function() {
            closeBootstrapModal(this);
        });
    });
    
    // 3. Fechar ao clicar fora do modal (no backdrop ou no próprio modal)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
            closeBootstrapModal(e.target);
        }
        
        if (e.target.classList.contains('modal-backdrop')) {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                closeBootstrapModal(openModal);
            }
        }
    });
    
    // 4. Fechar com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                closeBootstrapModal(openModal);
            }
        }
    });
}

/**
 * Abre um modal Bootstrap
 */
function openBootstrapModal(modal) {
    if (!modal) return;
    
    // Adicionar classe 'show' e display: block
    modal.classList.add('show');
    modal.style.display = 'block';
    document.body.classList.add('modal-open');
    
    // Adicionar backdrop se não existir
    if (!document.querySelector('.modal-backdrop')) {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }
}

/**
 * Fecha um modal Bootstrap
 */
function closeBootstrapModal(element) {
    // Encontrar o modal a partir do elemento clicado
    const modal = element.closest ? element.closest('.modal') : element;
    
    if (modal) {
        // Remover classes de exibição
        modal.classList.remove('show');
        modal.style.display = 'none';
        document.body.classList.remove('modal-open');
        
        // Remover backdrop
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.remove();
        }
    }
}

/**
 * Configura o sistema de abas do perfil
 */
function setupTabs() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover classe ativa de todos os botões e conteúdos
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Adicionar classe ativa ao botão clicado
            this.classList.add('active');
            
            // Mostrar conteúdo correspondente
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
            
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
 * Configura animações para elementos da página
 */
function setupAnimations() {
    // Animação para cards de conteúdo
    const contentCards = document.querySelectorAll('.content-card');
    contentCards.forEach((card, index) => {
        // Adicionar animação escalonada
        setTimeout(() => {
            card.classList.add('animated');
        }, index * 100);
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
 * Configura as abas do modal de login
 */
function setupLoginTabs() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.login-tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
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
 * Configura os indicadores de status online/offline
 */
function setupOnlineIndicators() {
    // Buscar status de usuários da API
    fetchUserStatus();
    
    // Verificar a cada 60 segundos se os usuários estão online
    setInterval(fetchUserStatus, 60000);
    
    // Ouvinte para mudanças de visibilidade da página
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            // Atualizar status quando a página voltar a ser visível
            fetchUserStatus();
        }
    });
}

/**
 * Busca o status online de usuários da API
 */
function fetchUserStatus() {
    // Obter IDs de usuário da página
    const userId = document.querySelector('.profile-header')?.dataset.userId;
    if (!userId) return;
    
    // Se a API não estiver disponível, simular status online (desenvolvimento)
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        // Em modo de desenvolvimento, alternar status para testes
        const onlineBadge = document.querySelector('.online-badge');
        if (onlineBadge) {
            const isCurrentlyOnline = !onlineBadge.classList.contains('offline-badge');
            updateOnlineStatus({ isOnline: !isCurrentlyOnline });
        }
        return;
    }
    
    // Em produção, usar fetch para obter status real
    fetch(`/api/users/status/${userId}`, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        cache: 'no-store'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erro ao buscar status');
        }
        return response.json();
    })
    .then(data => {
        updateOnlineStatus(data);
    })
    .catch(error => {
        console.error('Erro ao verificar status:', error);
    });
}

/**
 * Atualiza o indicador visual de status online/offline
 */
function updateOnlineStatus(statusData) {
    const onlineBadge = document.querySelector('.online-badge');
    if (!onlineBadge) return;
    
    // Se temos dados e o usuário está online
    if (statusData && statusData.isOnline) {
        onlineBadge.classList.remove('offline-badge');
        onlineBadge.classList.add('online-badge');
        onlineBadge.setAttribute('title', 'Online Agora');
        
        // Adicionar animação de pulse
        onlineBadge.classList.add('pulse-animation');
    } else {
        // Usuário offline
        onlineBadge.classList.remove('online-badge');
        onlineBadge.classList.add('offline-badge');
        onlineBadge.setAttribute('title', 'Offline');
        
        // Remover animação
        onlineBadge.classList.remove('pulse-animation');
    }
}

/**
 * Configura o tratamento de erros para imagens
 */
function setupImageErrorHandling() {
    const fallbackUrl = '/images/placeholder.jpg';
    
    // Adicionar evento onerror em todas as imagens
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
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