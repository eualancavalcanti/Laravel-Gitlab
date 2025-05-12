/**
 * Gerenciador de Modal de Assinatura para HotBoys
 * Adiciona opções de assinatura para usuários não VIP
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('[subscription-handler] Inicializando gerenciador de assinatura...');
    
    // Obter elementos relevantes
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) {
        console.error('[subscription-handler] Modal de vídeo não encontrado!');
        return;
    }
    
    const subscribeBtn = videoModal.querySelector('.btn-subscribe');
    const playButton = videoModal.querySelector('.play-button-wrapper');
    
    if (!subscribeBtn || !playButton) {
        console.error('[subscription-handler] Botões de ação não encontrados!');
        return;
    }
    
    // Configurar botões de ação para o comportamento de assinatura
    function configureSubscriptionButtons() {
        // Configurar botão de assinatura para ir para a página de planos
        subscribeBtn.innerHTML = `
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="8.5" cy="7" r="4"></circle>
                <polyline points="17 11 19 13 23 9"></polyline>
            </svg>
            Assinar Agora
        `;
        
        // Atualizar ação do botão para ir para a página de planos
        subscribeBtn.onclick = function() {
            fecharModal();
            window.location.href = '/plans';
        };
        
        // Atualizar ação do botão de play
        playButton.onclick = function() {
            fecharModal();
            window.location.href = '/plans';
        };
        
        console.log('[subscription-handler] Botões de assinatura configurados');
    }
    
    // Detectar quando o modal é aberto para configurar botões
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && 
                mutation.attributeName === 'style' && 
                videoModal.style.display === 'flex') {
                console.log('[subscription-handler] Modal aberto detectado, configurando botões');
                configureSubscriptionButtons();
            }
        });
    });
    
    observer.observe(videoModal, { attributes: true });
    
    /**
     * Fecha o modal de vídeo
     */
    function fecharModal() {
        videoModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Configurar botão de fechar nos modais
    const modalCloseButtons = videoModal.querySelectorAll('.modal-close');
    modalCloseButtons.forEach(button => {
        button.addEventListener('click', fecharModal);
    });
    
    console.log('[subscription-handler] Inicialização completa');
}); 