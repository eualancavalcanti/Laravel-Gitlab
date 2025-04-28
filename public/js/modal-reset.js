/**
 * Script de segurança para resetar modais em caso de problemas
 * 
 * Este script adiciona uma função de emergência para resetar
 * todos os modais quando o usuário detectar problemas.
 * Também inclui uma detecção automática de backdrop preso.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Adicionar botão de emergência para resetar modais (invisível até necessário)
    const resetButton = document.createElement('div');
    resetButton.className = 'modal-failsafe';
    resetButton.textContent = 'Resetar Interface';
    resetButton.style.display = 'none';
    document.body.appendChild(resetButton);
    
    // Adicionar evento de clique ao botão
    resetButton.addEventListener('click', function() {
        resetAllModals();
        this.style.display = 'none';
    });
    
    // Verificar se há backdrop preso após carregamento da página
    setTimeout(checkForStuckBackdrop, 2000);
    
    // Verificar periodicamente se há backdrop preso
    setInterval(checkForStuckBackdrop, 10000);
    
    // Adicionar detector de problemas de modais via tecla de escape
    document.addEventListener('keydown', function(e) {
        // Triplo ESC para ativar reset de emergência
        if (e.key === 'Escape') {
            const now = Date.now();
            if (!window.lastEscTime) window.lastEscTime = 0;
            if (!window.escCount) window.escCount = 0;
            
            if (now - window.lastEscTime < 500) {
                window.escCount++;
            } else {
                window.escCount = 1;
            }
            
            window.lastEscTime = now;
            
            // Após 3 ESC rápidos, ativar reset
            if (window.escCount >= 3) {
                window.escCount = 0;
                resetAllModals();
                
                // Mostrar mensagem de feedback
                showTemporaryMessage('Interface resetada com sucesso');
            }
        }
    });
    
    /**
     * Verifica se há backdrop preso ou body com modal-open
     */
    function checkForStuckBackdrop() {
        // Verificar se há backdrop sem modal aberto
        const backdrop = document.querySelector('.modal-backdrop');
        const openModal = document.querySelector('.modal.show');
        
        if (backdrop && !openModal) {
            // Há backdrop mas não há modal aberto - problema!
            resetButton.style.display = 'block';
            resetButton.textContent = 'Corrigir Interface Travada';
        }
        
        // Verificar se corpo está com modal-open mas não há modal aberto
        if (document.body.classList.contains('modal-open') && !openModal) {
            // Body travado sem modal aberto - problema!
            resetButton.style.display = 'block';
            resetButton.textContent = 'Desbloquear Rolagem';
        }
    }
    
    /**
     * Reseta todos os modais e remove qualquer backdrop
     */
    function resetAllModals() {
        // Remover todos os backdrops
        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
            backdrop.remove();
        });
        
        // Fechar todos os modais
        document.querySelectorAll('.modal').forEach(function(modal) {
            modal.classList.remove('show');
            modal.style.display = 'none';
            
            // Limpar qualquer iframe dentro de modal
            modal.querySelectorAll('iframe').forEach(function(iframe) {
                iframe.src = 'about:blank';
                if (iframe.parentNode) {
                    iframe.parentNode.innerHTML = '';
                }
            });
        });
        
        // Resetar o body
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
        
        // Adicionar e remover classe para forçar redraw
        document.documentElement.classList.add('modal-error');
        setTimeout(function() {
            document.documentElement.classList.remove('modal-error');
        }, 100);
    }
    
    /**
     * Mostra mensagem temporária de feedback
     */
    function showTemporaryMessage(message) {
        const messageDiv = document.createElement('div');
        messageDiv.textContent = message;
        messageDiv.style.position = 'fixed';
        messageDiv.style.bottom = '20px';
        messageDiv.style.left = '50%';
        messageDiv.style.transform = 'translateX(-50%)';
        messageDiv.style.background = '#FF3333';
        messageDiv.style.color = 'white';
        messageDiv.style.padding = '10px 20px';
        messageDiv.style.borderRadius = '5px';
        messageDiv.style.zIndex = '9999';
        messageDiv.style.boxShadow = '0 3px 10px rgba(0,0,0,0.3)';
        messageDiv.style.fontWeight = 'bold';
        
        document.body.appendChild(messageDiv);
        
        // Remover após 3 segundos
        setTimeout(function() {
            messageDiv.style.opacity = '0';
            messageDiv.style.transition = 'opacity 0.5s ease';
            setTimeout(function() {
                if (messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 500);
        }, 3000);
    }
    
    /**
     * Detecta se um modal está preso e adiciona timeout de segurança
     */
    const originalModalOpen = window.openModal;
    if (typeof originalModalOpen === 'function') {
        window.openModal = function(modal) {
            // Chamar função original
            originalModalOpen(modal);
            
            // Adicionar verificação de segurança
            if (modal) {
                // Definir timeout para verificar se o modal está preso
                setTimeout(function() {
                    const isStillOpen = modal.classList.contains('show');
                    const hasAnyUserAction = false; // Você pode implementar detecção de atividade do usuário aqui
                    
                    if (isStillOpen && !hasAnyUserAction) {
                        // O modal está aberto por muito tempo sem atividade do usuário
                        // Exibir botão de reset
                        resetButton.style.display = 'block';
                        resetButton.textContent = 'Resetar Modal';
                    }
                }, 60000); // Verificar após 1 minuto
            }
        };
    }
});