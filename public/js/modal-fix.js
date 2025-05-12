/**
 * Modal Fix - Correção específica para modais que não abrem
 * Versão 1.0.0
 */
console.log('[modal-fix] Inicializando script de correção de modais...');

document.addEventListener('DOMContentLoaded', function() {
    // Detectar se os modais estão funcionando
    let modalFuncionando = false;
    
    // Verificar elementos do DOM necessários
    const videoModal = document.getElementById('videoModal');
    if (!videoModal) {
        console.error('[modal-fix] Modal de vídeo não encontrado no DOM! Isso é um problema crítico.');
        return;
    } else {
        console.log('[modal-fix] Modal de vídeo encontrado no DOM.');
    }
    
    // Registrar eventos de clique e log detalhado
    function registrarEventosDeClique() {
        console.log('[modal-fix] Registrando eventos de clique para diagnóstico...');
        
        const elementosClicaveis = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        // Adicionar monitoramento de eventos para todos os seletores
        elementosClicaveis.forEach(selector => {
            const elementos = document.querySelectorAll(selector);
            console.log(`[modal-fix] Encontrados ${elementos.length} elementos com seletor "${selector}"`);
            
            elementos.forEach((elemento, index) => {
                // Adicionar atributo para rastreamento
                elemento.setAttribute('data-modal-fix-id', `${selector.replace(/[^a-zA-Z0-9]/g, '')}-${index}`);
                
                // Adicionar evento de clique
                elemento.addEventListener('click', function(e) {
                    const id = this.getAttribute('data-modal-fix-id');
                    console.log(`[modal-fix] Clique detectado em elemento #${id}`);
                    
                    // Verificar se o clique está sendo tratado por outro script
                    let eventoTratado = e.defaultPrevented;
                    console.log(`[modal-fix] Evento já tratado por outro script? ${eventoTratado ? 'SIM' : 'NÃO'}`);
                    
                    if (!eventoTratado) {
                        // Verificar se o modal está visível após o clique
                        setTimeout(() => {
                            if (videoModal.style.display === 'flex' || videoModal.style.display === 'block') {
                                console.log('[modal-fix] Modal aberto com sucesso pelos scripts existentes');
                                modalFuncionando = true;
                            } else {
                                console.log('[modal-fix] Modal NÃO abriu pelos scripts existentes, aplicando correção');
                                abrirModalManualmente(this);
                            }
                        }, 100); // Pequeno atraso para permitir que outros scripts executem primeiro
                    }
                }, { capture: true }); // Usar captura para executar antes de outros manipuladores
            });
        });
    }
    
    // Função para abrir o modal manualmente
    function abrirModalManualmente(elemento) {
        console.log('[modal-fix] Tentando abrir modal manualmente para elemento:', elemento);
        
        // Extrair dados do elemento
        const title = elemento.getAttribute('data-title') || 
                     elemento.querySelector('.content-title')?.textContent || 
                     'Conteúdo';
                     
        const thumbnail = elemento.getAttribute('data-thumbnail') || 
                          elemento.querySelector('img')?.src || 
                          '';
        
        // Configurar o modal
        const modalTitle = document.getElementById('videoModalTitle');
        const modalThumbnail = document.getElementById('videoModalThumbnail');
        const teaserOverlay = videoModal.querySelector('.teaser-overlay');
        const loginOptions = videoModal.querySelector('.login-options');
        const playButton = videoModal.querySelector('.play-button-wrapper');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalThumbnail) {
            modalThumbnail.src = thumbnail;
            modalThumbnail.alt = title;
        }
        
        if (teaserOverlay) teaserOverlay.style.display = 'flex';
        if (loginOptions) loginOptions.style.display = 'block';
        
        // Configurar botão de assinatura
        const subscribeBtn = videoModal.querySelector('.btn-subscribe');
        if (subscribeBtn) {
            subscribeBtn.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        // Configurar botão de play
        if (playButton) {
            playButton.onclick = function() {
                fecharModal();
                window.location.href = '/plans';
            };
        }
        
        // Mostrar o modal
        videoModal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        
        console.log('[modal-fix] Modal aberto manualmente com sucesso');
    }
    
    // Função para fechar o modal
    function fecharModal() {
        videoModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    
    // Configurar botão de fechar
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
    
    // Verificar integridade dos scripts
    const scriptsNecessarios = ['unified-modal-handler.js', 'content-modal.js', 'subscription-modal-handler.js'];
    const scriptsEncontrados = Array.from(document.scripts).map(s => s.src);
    
    console.log('[modal-fix] Verificando scripts carregados:');
    scriptsNecessarios.forEach(script => {
        const encontrado = scriptsEncontrados.some(src => src.includes(script));
        console.log(`[modal-fix] - ${script}: ${encontrado ? 'ENCONTRADO' : 'NÃO ENCONTRADO'}`);
    });
    
    // Adicionar delegação de eventos para garantir funcionamento
    document.addEventListener('click', function(e) {
        // Se já estiver funcionando após a correção inicial, não interferir mais
        if (modalFuncionando) return;
        
        // Verificar se o clique foi em um card ou seus elementos filhos
        const cardSelectors = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        let clickedCard = null;
        
        // Encontrar o elemento clicável mais próximo
        for (const selector of cardSelectors) {
            if (e.target.matches(selector) || e.target.closest(selector)) {
                clickedCard = e.target.matches(selector) ? e.target : e.target.closest(selector);
                break;
            }
        }
        
        // Se não encontramos um card clicável, retornar
        if (!clickedCard) return;
        
        // Verificar se o modal está visível após um pequeno atraso
        setTimeout(() => {
            if (videoModal.style.display !== 'flex' && videoModal.style.display !== 'block') {
                console.log('[modal-fix] Modal não abriu após clique em:', clickedCard);
                console.log('[modal-fix] Aplicando correção de emergência');
                
                // Prevenir comportamento padrão para evitar navegação
                e.preventDefault();
                e.stopPropagation();
                
                // Abrir o modal manualmente
                abrirModalManualmente(clickedCard);
            }
        }, 200);
    }, true); // Usar captura para executar antes de outros manipuladores
    
    // Iniciar o processo de diagnóstico
    registrarEventosDeClique();
    
    console.log('[modal-fix] Inicialização completa');
}); 