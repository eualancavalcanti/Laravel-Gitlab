/**
 * Correção simples para o problema dos modais
 * Substitua o conteúdo do seu creator-profile.js por este código
 */
document.addEventListener('DOMContentLoaded', function() {
    // Sistema simples de modais
    setupBasicModals();
    
    // Configurar as abas de perfil
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
        });
    });
    
    // Configurar as abas do modal de login
    const loginTabButtons = document.querySelectorAll('.tab-button');
    const loginTabContents = document.querySelectorAll('.login-tab-content');
    
    loginTabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remover classes ativas
            loginTabButtons.forEach(btn => btn.classList.remove('active'));
            loginTabContents.forEach(content => content.classList.remove('active'));
            
            // Adicionar classe ativa ao botão clicado
            this.classList.add('active');
            
            // Mostrar conteúdo correspondente
            const tabId = this.getAttribute('data-tab') + '-tab';
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Configurar cards de conteúdo
    const contentCards = document.querySelectorAll('.hb-content-card');
    contentCards.forEach(card => {
        card.addEventListener('click', function(e) {
            e.preventDefault();
            
            const isExclusive = this.closest('#exclusive') !== null || 
                              this.querySelector('.content-badge.exclusive') !== null;
            
            if (isExclusive) {
                // Conteúdo exclusivo - abrir modal de login
                const loginModal = document.getElementById('loginModal');
                if (loginModal) {
                    const title = this.querySelector('.content-title')?.textContent || 'Conteúdo Exclusivo';
                    const modalTitle = loginModal.querySelector('.modal-title');
                    if (modalTitle) {
                        modalTitle.textContent = `Acesse o conteúdo exclusivo: ${title}`;
                    }
                    openModal(loginModal);
                }
            } else {
                // Conteúdo VIP - abrir modal de vídeo
                const videoModal = document.getElementById('videoModal');
                if (videoModal) {
                    const title = this.querySelector('.content-title')?.textContent || 'Vídeo';
                    const thumbnail = this.querySelector('img')?.src || '';
                    const teaserCode = this.getAttribute('data-teaser-code') || '';
                    
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
                    
                    // Exibir loading e esconder thumbnail
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
                        
                        // Esconder loading quando iframe carregar
                        const iframe = playerContainer.querySelector('iframe');
                        if (iframe) {
                            iframe.onload = function() {
                                if (loadingIndicator) loadingIndicator.style.display = 'none';
                            };
                        }
                    } else {
                        // Mostrar thumbnail se não houver teaser
                        if (loadingIndicator) loadingIndicator.style.display = 'none';
                        if (modalThumbnail) modalThumbnail.style.display = 'block';
                        if (teaserOverlay) teaserOverlay.style.display = 'flex';
                    }
                    
                    openModal(videoModal);
                }
            }
        });
    });
    
    // Configuração para tratamento de erros em imagens
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', function() {
            // Verificar contexto da imagem
            if (this.closest('#exclusive .content-card')) {
                // Para conteúdo exclusivo, esconder a imagem para fundo preto
                this.style.display = 'none';
            } else {
                // Para outros conteúdos, usar fallback
                this.src = '/images/placeholder.jpg';
            }
        });
    });
});

/**
 * Configura sistema básico de modais
 * Esta é a função corrigida para resolver o problema de fechamento
 */
function setupBasicModals() {
    // Limpar qualquer backdrop existente e resetar o body
    document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    
    // Configurar botões para abrir modais
    document.querySelectorAll('[data-toggle="modal"]').forEach(trigger => {
        trigger.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSelector = this.getAttribute('data-target');
            const targetModal = document.querySelector(targetSelector);
            if (targetModal) {
                openModal(targetModal);
            }
        });
    });
    
    // CORREÇÃO: Configurar botões para fechar modais
    // Abordagem com event listener direto em cada botão
    document.querySelectorAll('.modal .close, .modal .modal-close, [data-dismiss="modal"]').forEach(button => {
        // Remover event listeners antigos
        const newButton = button.cloneNode(true);
        if (button.parentNode) {
            button.parentNode.replaceChild(newButton, button);
        }
        
        // Adicionar novo event listener
        newButton.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Prevenir propagação do evento
            
            // Encontrar o modal pai e fechá-lo
            const modal = this.closest('.modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });
    
    // CORREÇÃO: Fechar modal ao clicar fora
    document.querySelectorAll('.modal').forEach(modal => {
        // Criar uma cópia do modal para remover event listeners existentes
        const clonedModal = modal.cloneNode(false); // Shallow clone
        
        // Transferir filhos para o clone
        while (modal.firstChild) {
            clonedModal.appendChild(modal.firstChild);
        }
        
        // Substituir o modal original pelo clone
        if (modal.parentNode) {
            modal.parentNode.replaceChild(clonedModal, modal);
            
            // Adicionar novo event listener
            clonedModal.addEventListener('click', function(e) {
                if (e.target === this) { // Clique direto no fundo do modal
                    closeModal(this);
                }
            });
        }
    });
    
    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                closeModal(openModal);
            }
        }
    });
}

/**
 * Abre um modal
 */
function openModal(modal) {
    // Fechar outros modais primeiro
    document.querySelectorAll('.modal.show').forEach(m => {
        if (m !== modal) {
            closeModal(m);
        }
    });
    
    // Mostrar backdrop
    if (!document.querySelector('.modal-backdrop')) {
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
    }
    
    // Mostrar modal
    modal.classList.add('show');
    modal.style.display = 'block';
    
    // Bloquear scroll do body
    document.body.classList.add('modal-open');
    document.body.style.overflow = 'hidden';
}

/**
 * Fecha um modal
 */
function closeModal(modal) {
    // Remover players de vídeo para parar reprodução
    modal.querySelectorAll('iframe').forEach(iframe => {
        if (iframe.parentNode) {
            iframe.parentNode.innerHTML = '';
        }
    });
    
    // Esconder modal
    modal.classList.remove('show');
    modal.style.display = 'none';
    
    // Remover backdrop se não houver outros modais abertos
    const anotherModalOpen = document.querySelector('.modal.show');
    if (!anotherModalOpen) {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
    }
}

// Botão de emergência para resetar modais
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar botão de reset (invisível inicialmente)
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
    
    document.body.appendChild(resetButton);
    
    // Mostrar após 3 segundos se detectar problemas
    setTimeout(function() {
        const modalBackdrop = document.querySelector('.modal-backdrop');
        const openModal = document.querySelector('.modal.show');
        
        if ((modalBackdrop && !openModal) || 
            (document.body.classList.contains('modal-open') && !openModal)) {
            resetButton.style.display = 'block';
        }
    }, 3000);
    
    // Detectar 3 ESCs em sequência para mostrar botão
    let escCount = 0;
    let lastEscTime = 0;
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const now = Date.now();
            if (now - lastEscTime < 500) {
                escCount++;
                if (escCount >= 3) {
                    resetButton.style.display = 'block';
                    escCount = 0;
                }
            } else {
                escCount = 1;
            }
            lastEscTime = now;
        }
    });
    
    // Adicionar evento de reset
    resetButton.addEventListener('click', function() {
        // Remover todos os backdrops
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
        
        // Fechar todos os modais
        document.querySelectorAll('.modal.show').forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        
        // Resetar o body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Esconder botão
        this.style.display = 'none';
        
        // Mostrar mensagem
        alert('Interface resetada com sucesso');
    });
});