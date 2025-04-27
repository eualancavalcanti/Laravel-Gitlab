/**
 * HotBoys - Creator Profile JavaScript
 * Script para perfil de criador com suporte para indicadores online/offline
 */

document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidades de abas
    setupTabs();
    
    // Funcionalidades de modal
    setupModals();
    
    // Animações e interatividade
    setupAnimations();
    
    // Funcionalidade de prévia de conteúdo
    setupContentPreviews();
    
    // Controles para abas do modal de login
    setupLoginTabs();
    
    // Configurar indicadores de status online/offline
    setupOnlineIndicators();
    
    // Configurar tratamento de erro para imagens
    setupImageErrorHandling();
});

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
 * Configura as funcionalidades de modal
 */
function setupModals() {
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    const closeModalButtons = document.querySelectorAll('.close');
    
    // Abrir modais
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', function() {
            const targetModal = document.querySelector(this.getAttribute('data-target'));
            if (targetModal) {
                targetModal.classList.add('show');
                document.body.style.overflow = 'hidden';
            }
        });
    });
    
    // Fechar modais com o botão de fechar
    closeModalButtons.forEach(button => {
        button.addEventListener('click', function() {
            const modal = this.closest('.modal');
            if (modal) {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
    
    // Fechar modal ao clicar fora
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    });
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
 * Configura a funcionalidade de prévia do conteúdo
 */
function setupContentPreviews() {
    const contentCards = document.querySelectorAll('.content-card');
    
    contentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Verificar se tem título
            const titleElement = this.querySelector('.content-title');
            if (!titleElement) return;
            
            // Obter dados do card
            const title = titleElement.textContent;
            const isExclusive = this.querySelector('.content-badge.exclusive') !== null;
            const isVip = this.querySelector('.content-badge.vip') !== null;
            const isPack = this.querySelector('.content-badge.pack') !== null;
            const imgElement = this.querySelector('img');
            const imgSrc = imgElement ? imgElement.src : '/images/placeholder.jpg';
            
            // Criar modal de prévia
            const previewModal = document.createElement('div');
            previewModal.className = 'preview-modal';
            previewModal.innerHTML = `
                <div class="preview-container">
                    <div class="preview-header">
                        <h3>${title}</h3>
                        <button class="close-preview">&times;</button>
                    </div>
                    <div class="preview-content">
                        <div class="preview-image" style="background-image: url('${imgSrc}')">
                            <div class="preview-blur"></div>
                            <div class="preview-play">
                                <svg viewBox="0 0 24 24" width="64" height="64" fill="none" stroke="white" stroke-width="2">
                                    <polygon points="5 3 19 12 5 21 5 3"></polygon>
                                </svg>
                            </div>
                            <div class="preview-duration">Prévia: 0:30</div>
                        </div>
                        <div class="preview-info">
                            <p>Experimente ${isVip ? 'nosso plano VIP' : 'este conteúdo exclusivo'} para desbloquear o vídeo completo e muito mais!</p>
                            <div class="preview-action">
                                ${isVip ? 
                                    '<button class="btn-preview-vip">Assinar VIP</button>' : 
                                    `<button class="btn-preview-buy">Comprar por R$ ${(Math.random() * 30 + 19.9).toFixed(2).replace('.', ',')}</button>`
                                }
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            document.body.appendChild(previewModal);
            
            // Mostrar modal com animação
            setTimeout(() => {
                previewModal.classList.add('show');
            }, 10);
            
            // Fechar modal
            const closeButton = previewModal.querySelector('.close-preview');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    previewModal.classList.remove('show');
                    setTimeout(() => {
                        previewModal.remove();
                    }, 300);
                });
            }
            
            // Ações dos botões
            const buyBtn = previewModal.querySelector('.btn-preview-buy');
            const vipBtn = previewModal.querySelector('.btn-preview-vip');
            
            if (buyBtn) {
                buyBtn.addEventListener('click', () => {
                    window.location.href = '#loginModal';
                    previewModal.remove();
                    const loginModal = document.getElementById('loginModal');
                    if (loginModal) loginModal.classList.add('show');
                });
            }
            
            if (vipBtn) {
                vipBtn.addEventListener('click', () => {
                    window.location.href = '#loginModal';
                    previewModal.remove();
                    const loginModal = document.getElementById('loginModal');
                    if (loginModal) loginModal.classList.add('show');
                });
            }
        });
    });
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
 * Usa método GET para evitar problemas de CORS/cache em servidores Apache
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
        // Em caso de erro, manter o status atual sem alterações
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