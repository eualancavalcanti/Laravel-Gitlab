/**
 * Event Propagation Fix - Correção de propagação de eventos
 * Versão 1.0.0
 */
console.log('[event-fix] Inicializando correção de propagação de eventos...');

// Executar assim que possível, sem esperar DOMContentLoaded
(function() {
    // Função para aplicar correção
    function aplicarCorrecaoPropagacao() {
        console.log('[event-fix] Aplicando correção de propagação de eventos...');
        
        // Seletores dos elementos clicáveis
        const seletores = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        // Para cada tipo de elemento
        seletores.forEach(seletor => {
            const elementos = document.querySelectorAll(seletor);
            console.log(`[event-fix] Encontrados ${elementos.length} elementos para seletor "${seletor}"`);
            
            // Aplicar interceptação em cada elemento
            elementos.forEach((elemento, indice) => {
                // Identificar o elemento para debug
                elemento.setAttribute('data-event-fix-id', `${seletor.replace(/[^a-zA-Z0-9]/g, '')}-${indice}`);
                
                // Garantir que não tenha eventos de clique adicionados diretamente a elementos filhos
                Array.from(elemento.children).forEach(filho => {
                    if (!(filho instanceof HTMLAnchorElement)) {
                        filho.style.pointerEvents = 'none';
                    }
                });
                
                // Criar um interceptador para os eventos de clique
                const interceptador = document.createElement('div');
                interceptador.className = 'event-propagation-fix';
                interceptador.style.cssText = `
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    z-index: 5;
                    cursor: pointer;
                    background: transparent;
                `;
                
                // Adicionar eventos de clique diretamente ao interceptador
                interceptador.addEventListener('click', function(e) {
                    const id = elemento.getAttribute('data-event-fix-id');
                    console.log(`[event-fix] Clique interceptado para ${id}`);
                    
                    // Prevenção de evento padrão
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Executar a função de abertura do modal
                    abrirModal(elemento);
                    
                    return false;
                });
                
                // Verificar posicionamento atual do elemento
                const estiloAtual = window.getComputedStyle(elemento);
                if (estiloAtual.position === 'static') {
                    elemento.style.position = 'relative';
                }
                
                // Adicionar o interceptador se ainda não existir
                if (!elemento.querySelector('.event-propagation-fix')) {
                    elemento.appendChild(interceptador);
                    console.log(`[event-fix] Interceptador adicionado para elemento ${indice+1} (${seletor})`);
                }
            });
        });
        
        console.log('[event-fix] Correção de propagação aplicada com sucesso');
    }
    
    // Função para abrir o modal
    function abrirModal(elemento) {
        console.log('[event-fix] Tentando abrir modal para:', elemento);
        
        // Obter referências ao modal
        const videoModal = document.getElementById('videoModal');
        if (!videoModal) {
            console.error('[event-fix] Modal de vídeo não encontrado!');
            return;
        }
        
        // Extrair dados do elemento
        const title = elemento.getAttribute('data-title') || 
                     elemento.querySelector('.content-title')?.textContent || 
                     'Conteúdo';
                     
        const thumbnail = elemento.getAttribute('data-thumbnail') || 
                          elemento.querySelector('img')?.src || 
                          '';
                          
        const videoId = elemento.getAttribute('data-video-id') || '';
        
        // Verificar se é pay-per-view
        if (elemento.getAttribute('data-ppv') === 'true' && videoId) {
            console.log('[event-fix] Redirecionando para pay-per-view:', videoId);
            window.location.href = '/pay-per-view/' + videoId;
            return;
        }
        
        // Configurar modal
        const modalTitle = document.getElementById('videoModalTitle');
        const modalThumbnail = document.getElementById('videoModalThumbnail');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalThumbnail) {
            modalThumbnail.src = thumbnail;
            modalThumbnail.alt = title;
        }
        
        // Configurar elementos do modal
        const teaserOverlay = videoModal.querySelector('.teaser-overlay');
        const loginOptions = videoModal.querySelector('.login-options');
        
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loginOptions) loginOptions.style.display = 'block';
        
        // Configurar botões
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        const playButton = videoModal.querySelector('.play-button-wrapper');
        
        if (subscribeBtn) {
            subscribeBtn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <polyline points="17 11 19 13 23 9"></polyline>
                </svg>
                Assinar Agora
            `;
            
            subscribeBtn.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        if (playButton) {
            playButton.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        // Mostrar o modal
        videoModal.style.display = 'flex';
        videoModal.classList.add('js-modal-open');
        document.body.style.overflow = 'hidden';
        
        console.log('[event-fix] Modal aberto com sucesso');
        
        // Configurar evento de fechamento
        const modalClose = videoModal.querySelector('.modal-close');
        if (modalClose) {
            modalClose.addEventListener('click', fecharModal);
        }
        
        // Fechar ao clicar fora do conteúdo
        videoModal.addEventListener('click', function(e) {
            if (e.target === videoModal) {
                fecharModal();
            }
        });
    }
    
    // Função para fechar o modal
    function fecharModal() {
        const videoModal = document.getElementById('videoModal');
        if (videoModal) {
            videoModal.style.display = 'none';
            videoModal.classList.remove('js-modal-open');
            document.body.style.overflow = 'auto';
        }
    }
    
    // Aplicar correção quando o DOM estiver pronto
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', aplicarCorrecaoPropagacao);
    } else {
        // O DOM já está pronto, aplicar imediatamente
        aplicarCorrecaoPropagacao();
    }
    
    // Aplicar novamente após um tempo para garantir que todos os cards foram carregados
    setTimeout(aplicarCorrecaoPropagacao, 1000);
    
    // Para o caso de carregamento lazy ou AJAX, verificar periodicamente novos elementos
    setInterval(function() {
        // Verificar se há novos elementos que precisam da correção
        const seletores = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        let novosElementos = 0;
        
        seletores.forEach(seletor => {
            const elementos = document.querySelectorAll(`${seletor}:not([data-event-fix-id])`);
            novosElementos += elementos.length;
        });
        
        if (novosElementos > 0) {
            console.log(`[event-fix] Encontrados ${novosElementos} novos elementos, reaplicando correção`);
            aplicarCorrecaoPropagacao();
        }
    }, 2000);
    
    console.log('[event-fix] Inicialização completa');
})(); 