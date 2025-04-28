/**
 * HotBoys - Creator Profile JavaScript
 * Script para perfil de criador compatível com Bootstrap Modal
 */

document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidades de abas
    setupTabs();
    
    // Configurar abas do modal de login
    setupLoginTabs();
    
    // Configurar modais de Bootstrap
    setupBootstrapModals();
    
    // Configurar cards de conteúdo
    setupContentCards();
    
    // Configurar indicadores de status online/offline
    setupOnlineIndicators();
    
    // Configurar tratamento de erro para imagens
    setupImageErrorHandling();
    
    // Animações para elementos da página
    setupAnimations();
});

/**
 * Configura os cards de conteúdo para abrir modais diferentes
 */
function setupContentCards() {
    // Obter todos os cards de conteúdo
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        // Remover qualquer ouvinte anterior
        card.removeEventListener('click', handleCardClick);
        
        // Adicionar novo ouvinte
        card.addEventListener('click', handleCardClick);
    });
}

/**
 * Manipula o clique em um card de conteúdo
 */
function handleCardClick(event) {
    event.preventDefault();
    
    // Determinar o tipo de conteúdo
    const isExclusive = this.closest('#exclusive') !== null || 
                        this.querySelector('.content-badge.exclusive') !== null;
    
    const isVip = this.closest('#vip') !== null || 
                 this.querySelector('.content-badge.vip') !== null;
    
    if (isExclusive) {
        // Para conteúdo exclusivo, mostrar modal especial
        showExclusiveModal(this);
    } else if (isVip) {
        // Para conteúdo VIP, abrir o modal normal
        openVideoModal(this);
    } else {
        // Para outros tipos, abrir o modal normal
        openVideoModal(this);
    }
}

/**
 * Abre modal para conteúdo exclusivo
 */
function showExclusiveModal(card) {
    // Obter dados do card
    const title = card.querySelector('.content-title')?.textContent || 'Conteúdo Exclusivo';
    const creatorName = document.querySelector('.profile-name')?.textContent || 'Modelo';
    const creatorImage = document.querySelector('.profile-photo img')?.src || '';
    
    // Criar modal de conteúdo exclusivo se não existir
    let exclusiveModal = document.getElementById('exclusiveModal');
    
    if (!exclusiveModal) {
        exclusiveModal = document.createElement('div');
        exclusiveModal.id = 'exclusiveModal';
        exclusiveModal.className = 'modal';
        exclusiveModal.setAttribute('tabindex', '-1');
        exclusiveModal.setAttribute('role', 'dialog');
        exclusiveModal.setAttribute('aria-hidden', 'true');
        
        exclusiveModal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Conteúdo Exclusivo</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <div class="exclusive-preview">
                            <div class="creator-preview">
                                <img src="${creatorImage}" alt="${creatorName}" class="creator-image" />
                                <div class="exclusive-badge">
                                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                                    </svg>
                                    Exclusivo
                                </div>
                            </div>
                            <h4 class="exclusive-title mt-3"></h4>
                            <p class="exclusive-message">Cadastre-se para ver meus conteúdos exclusivos!</p>
                            <button class="btn btn-danger btn-lg mt-3 enter-button" data-toggle="modal" data-target="#loginModal">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" class="mr-2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                                    <polyline points="10 17 15 12 10 7"></polyline>
                                    <line x1="15" y1="12" x2="3" y2="12"></line>
                                </svg>
                                Entrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(exclusiveModal);
        
        // Adicionar evento para o botão "Entrar"
        const enterButton = exclusiveModal.querySelector('.enter-button');
        if (enterButton) {
            enterButton.addEventListener('click', function() {
                closeBootstrapModal(exclusiveModal);
                
                // Abrir modal de login após fechar o modal exclusivo
                setTimeout(() => {
                    const loginModal = document.getElementById('loginModal');
                    if (loginModal) {
                        openBootstrapModal(loginModal);
                    }
                }, 300);
            });
        }
        
        // Adicionar evento para botão de fechar
        const closeButton = exclusiveModal.querySelector('[data-dismiss="modal"]');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                closeBootstrapModal(exclusiveModal);
            });
        }
        
        // Fechar ao clicar fora do conteúdo
        exclusiveModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeBootstrapModal(this);
            }
        });
    }
    
    // Atualizar título do modal com o título do conteúdo
    const titleElement = exclusiveModal.querySelector('.exclusive-title');
    if (titleElement) {
        titleElement.textContent = title;
    }
    
    // Abrir o modal exclusivo
    openBootstrapModal(exclusiveModal);
}

/**
 * Abre modal para conteúdo VIP
 */
function openVideoModal(card) {
    // Obter o modal de vídeo
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) return;
    
    // Obter dados do card
    const title = card.querySelector('.content-title')?.textContent || 'Vídeo';
    const thumbnail = card.querySelector('img')?.src || '';
    const videoId = card.getAttribute('data-video-id') || '';
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
    
    // Remover players anteriores
    const existingPlayers = teaserContainer.querySelectorAll('.teaser-player, iframe');
    existingPlayers.forEach(player => player.remove());
    
    // Mostrar indicador de carregamento
    if (loadingIndicator) loadingIndicator.style.display = 'block';
    if (modalThumbnail) modalThumbnail.style.display = 'none';
    if (teaserOverlay) teaserOverlay.style.display = 'none';
    
    // Se tiver código teaser, inserir
    if (teaserCode && teaserCode.trim() !== '') {
        // Criar player
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
        // Se não tiver teaser, mostrar thumbnail
        if (loadingIndicator) loadingIndicator.style.display = 'none';
        if (modalThumbnail) modalThumbnail.style.display = 'block';
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
    }
    
    // Abrir o modal
    openBootstrapModal(videoModal);
}

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