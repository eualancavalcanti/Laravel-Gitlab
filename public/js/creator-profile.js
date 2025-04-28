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
    
    // Configurar indicadores de status online/offline
    setupOnlineIndicators();
    
    // Configurar tratamento de erro para imagens
    setupImageErrorHandling();
    
    // Animações para elementos da página
    setupAnimations();
});

/**
 * Configura os modais Bootstrap
 */
function setupBootstrapModals() {
    // Implementar comportamento do Bootstrap modal manualmente
    
    // 1. Botões para abrir modal (usando atributo data-target)
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    modalTriggers.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const targetSelector = this.getAttribute('data-target');
            const targetModal = document.querySelector(targetSelector);
            
            if (targetModal) {
                // Adicionar classe 'show' e display: block
                targetModal.classList.add('show');
                targetModal.style.display = 'block';
                document.body.classList.add('modal-open');
                
                // Adicionar backdrop se não existir
                if (!document.querySelector('.modal-backdrop')) {
                    const backdrop = document.createElement('div');
                    backdrop.className = 'modal-backdrop fade show';
                    document.body.appendChild(backdrop);
                }
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
    
    // 3. Fechar ao clicar fora do modal (no backdrop)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal') && e.target.classList.contains('show')) {
            closeBootstrapModal(e.target);
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