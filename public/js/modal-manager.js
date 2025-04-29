/**
 * Modal Manager - Gerenciador unificado de modais para HotBoys
 * Solução para problemas de conflito entre modais e backdrops persistentes
 */
document.addEventListener('DOMContentLoaded', function() {
    // Referências para modais principais do sistema
    const videoModal = document.getElementById('videoModal');
    const loginModal = document.getElementById('loginModal');
    const exclusiveModal = document.getElementById('exclusiveModal');
    
    // Array de todos os modais gerenciados
    const allModals = [videoModal, loginModal, exclusiveModal].filter(modal => modal !== null);
    
    // Inicializar o gerenciador de modais
    initModalManager();
    
    /**
     * Inicializa o gerenciador central de modais
     */
    function initModalManager() {
        // Remover qualquer backdrop residual no carregamento da página
        removeBackdrops();
        resetBodyState();
        
        // Configurar botões para fechar modais
        document.querySelectorAll('[data-dismiss="modal"], .modal-close, .close').forEach(button => {
            // Remover eventos antigos para evitar duplicação
            const newButton = button.cloneNode(true);
            if (button.parentNode) {
                button.parentNode.replaceChild(newButton, button);
            }
            
            // Adicionar novo handler
            newButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // Impedir propagação do evento
                
                const modal = this.closest('.modal');
                if (modal) {
                    closeModal(modal);
                }
            });
        });
        
        // Configurar fechamento de modal ao clicar fora
        allModals.forEach(modal => {
            // Remover eventos antigos para evitar duplicação
            const newModal = modal.cloneNode(false);
            Array.from(modal.children).forEach(child => newModal.appendChild(child));
            
            if (modal.parentNode) {
                modal.parentNode.replaceChild(newModal, modal);
                
                // Adicionar novo handler
                newModal.addEventListener('click', function(e) {
                    // Fechar apenas se o clique foi no backdrop (fora do conteúdo do modal)
                    if (e.target === this) {
                        closeModal(this);
                    }
                });
            }
        });
        
        // Configurar fechamento ao pressionar ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const openModal = document.querySelector('.modal.show');
                if (openModal) {
                    closeModal(openModal);
                }
            }
        });
        
        // Configurar botões que abrem modais
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
        
        // Limpar qualquer resíduo de modal ao carregar a página
        resetModalState();
        
        // Adicionar botão de emergência (invisível por padrão)
        addEmergencyButton();
        
        // Monitorar o DOM para detectar backdrops persistentes
        monitorBackdrops();
    }
    
    /**
     * Abre um modal garantindo que outros modais estejam fechados
     */
    function openModal(modal) {
        console.log("Abrindo modal:", modal.id);
        
        // Certificar-se de que qualquer modal aberto seja fechado primeiro
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(openModal => {
            if (openModal !== modal) {
                // Fechar modais sem animação para evitar conflitos
                closeModalImmediately(openModal);
            }
        });
        
        // Remover backdrops existentes
        removeBackdrops();
        
        // Criar um novo backdrop limpo
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
        
        // Abrir o novo modal
        modal.classList.add('show');
        modal.style.display = 'block';
        modal.setAttribute('aria-hidden', 'false');
        
        // Bloquear scrolling
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Compensar largura da scrollbar
        const scrollbarWidth = window.innerWidth - document.documentElement.clientWidth;
        if (scrollbarWidth > 0) {
            document.body.style.paddingRight = scrollbarWidth + 'px';
        }
    }
    
    /**
     * Fecha um modal com animação suave - VERSÃO CORRIGIDA
     */
    function closeModal(modal) {
        console.log("Fechando modal:", modal.id);
        
        // Remover players de vídeo para interromper reprodução
        modal.querySelectorAll('iframe').forEach(iframe => {
            // Primeiro parar a reprodução mudando o src
            iframe.src = '';
            
            // Depois limpar o conteúdo do container
            const parent = iframe.parentNode;
            if (parent) {
                parent.innerHTML = '';
            }
        });
        
        // Esconder o modal
        modal.classList.remove('show');
        modal.style.display = 'none'; // Remover imediatamente para evitar problemas
        modal.setAttribute('aria-hidden', 'true');
        
        // IMPORTANTE: Sempre remover todos os backdrops, independentemente de outros modais abertos
        removeBackdrops();
        
        // IMPORTANTE: Sempre resetar o estado do body
        resetBodyState();
        
        // Se houver outro modal aberto que precisa ser mostrado, reabri-lo explicitamente
        const nextModal = document.querySelector('.modal.show');
        if (nextModal) {
            setTimeout(() => {
                openModal(nextModal);
            }, 10);
        }
    }
    
    /**
     * Fecha um modal imediatamente sem animação
     */
    function closeModalImmediately(modal) {
        // Remover players de vídeo
        modal.querySelectorAll('iframe').forEach(iframe => {
            iframe.src = '';
            
            const parent = iframe.parentNode;
            if (parent) {
                parent.innerHTML = '';
            }
        });
        
        // Esconder o modal sem animação
        modal.classList.remove('show');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
    }
    
    /**
     * Remove todos os backdrops da página
     */
    function removeBackdrops() {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    }
    
    /**
     * Restaura o estado normal do body
     */
    function resetBodyState() {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    /**
     * Reseta completamente o estado de modais
     */
    function resetModalState() {
        // Fechar todos os modais
        document.querySelectorAll('.modal').forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
            modal.setAttribute('aria-hidden', 'true');
        });
        
        // Remover backdrops
        removeBackdrops();
        
        // Restaurar body
        resetBodyState();
    }
    
    /**
     * Monitora o DOM para detectar e corrigir backdrops persistentes
     */
    function monitorBackdrops() {
        // Criar um MutationObserver para detectar mudanças no DOM
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                // Verificar se foi adicionado algum elemento
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Verificar se há backdrop sem modal ativo
                    setTimeout(function() {
                        const hasBackdrop = document.querySelector('.modal-backdrop');
                        const hasActiveModal = document.querySelector('.modal.show');
                        
                        if (hasBackdrop && !hasActiveModal) {
                            console.log("Detectado backdrop sem modal ativo. Removendo...");
                            removeBackdrops();
                            resetBodyState();
                        }
                    }, 100);
                }
            });
        });
        
        // Iniciar a observação do body para novas adições
        observer.observe(document.body, { childList: true });
    }
    
    /**
     * Adiciona um botão de emergência para casos onde modais travem
     */
    function addEmergencyButton() {
        // Remover botão existente para evitar duplicação
        const existingButton = document.getElementById('modal-emergency-reset');
        if (existingButton) {
            existingButton.remove();
        }
        
        // Criar botão de emergência
        const resetButton = document.createElement('button');
        resetButton.textContent = 'Resetar Modais';
        resetButton.id = 'modal-emergency-reset';
        resetButton.className = 'modal-reset-button';
        resetButton.style.position = 'fixed';
        resetButton.style.bottom = '10px';
        resetButton.style.right = '10px';
        resetButton.style.zIndex = '9999';
        resetButton.style.background = '#FF3333';
        resetButton.style.color = 'white';
        resetButton.style.border = 'none';
        resetButton.style.borderRadius = '5px';
        resetButton.style.padding = '10px 15px';
        resetButton.style.fontWeight = 'bold';
        resetButton.style.display = 'none';
        resetButton.style.cursor = 'pointer';
        
        // Adicionar ao body
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
        
        // Mostrar botão após sequência de ESC rápidos
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
        
        // Comportamento do botão
        resetButton.addEventListener('click', function() {
            resetModalState();
            this.style.display = 'none';
            
            // Notificar o usuário que os modais foram resetados
            alert('Interface de modais restaurada com sucesso!');
        });
    }
    
    // Verificação periódica para backdrops persistentes
    setInterval(function() {
        const hasBackdrop = document.querySelector('.modal-backdrop');
        const hasActiveModal = document.querySelector('.modal.show');
        
        if (hasBackdrop && !hasActiveModal) {
            console.log("Detectado backdrop persistente na verificação periódica. Removendo...");
            removeBackdrops();
            resetBodyState();
        }
    }, 5000); // Verificar a cada 5 segundos
    
    // Expor funções para uso global
    window.modalManager = {
        open: openModal,
        close: closeModal,
        reset: resetModalState
    };
});