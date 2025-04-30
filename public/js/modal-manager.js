/**
 * Modal Manager - Gerenciador universal de modais para HotBoys
 * Versão 2.0 - Suporte para todos os tipos de modais (.modal e .content-modal)
 * Solução para problemas de fechamento e backdrops persistentes
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando gerenciador universal de modais');
    
    // Identificar todos os modais no sistema
    const standardModals = Array.from(document.querySelectorAll('.modal'));
    const contentModals = Array.from(document.querySelectorAll('.content-modal'));
    const allModals = [...standardModals, ...contentModals];
    
    // Verificar modais conhecidos por ID
    const videoModal = document.getElementById('videoModal');
    const loginModal = document.getElementById('loginModal');
    
    // Inicializar o gerenciador
    initUniversalModalManager();
    
    /**
     * Inicializa o gerenciador central de modais
     */
    function initUniversalModalManager() {
        // Limpeza inicial - remover quaisquer resíduos
        removeBackdrops();
        resetBodyState();
        
        // Configurar TODOS os botões de fechar modal no documento
        configurarBotoesFechar();
        
        // Configurar fechamento ao clicar fora do modal
        configurarFechamentoFora();
        
        // Configurar fechamento com ESC
        configurarTeclaESC();
        
        // Configurar botões de abertura de modal
        configurarBotoesAbrir();
        
        // Adicionar botão de emergência
        adicionarBotaoEmergencia();
        
        // Iniciar monitoramento de problemas
        iniciarMonitoramento();
    }
    
    /**
     * Configura todos os botões que fecham modais
     */
    function configurarBotoesFechar() {
        // Selecionar todos os possíveis botões de fechar
        const botoesFechar = document.querySelectorAll('.modal-close, .close, [data-dismiss="modal"]');
        
        botoesFechar.forEach(botao => {
            // Criar novo botão para substituir (remove eventos antigos)
            const novoBotao = botao.cloneNode(true);
            
            // Substituir o botão original pelo novo
            if (botao.parentNode) {
                botao.parentNode.replaceChild(novoBotao, botao);
            }
            
            // Adicionar evento de clique ao novo botão
            novoBotao.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Encontrar o modal pai (qualquer tipo)
                const modal = this.closest('.modal') || this.closest('.content-modal');
                
                if (modal) {
                    fecharModal(modal);
                    console.log('Modal fechado pelo botão X:', modal.id || 'sem id');
                }
            });
        });
    }
    
    /**
     * Configura fechamento ao clicar fora do conteúdo do modal
     */
    function configurarFechamentoFora() {
        allModals.forEach(modal => {
            // Criar clone para remover eventos existentes
            const novoModal = modal.cloneNode(false);
            
            // Transferir o conteúdo para o novo modal
            while (modal.firstChild) {
                novoModal.appendChild(modal.firstChild);
            }
            
            // Substituir o modal original
            if (modal.parentNode) {
                modal.parentNode.replaceChild(novoModal, modal);
                
                // Adicionar novo evento de clique
                novoModal.addEventListener('click', function(e) {
                    // Verificar se o clique foi no fundo do modal, não em seu conteúdo
                    if (e.target === this) {
                        fecharModal(this);
                        console.log('Modal fechado por clique fora:', this.id || 'sem id');
                    }
                });
            }
        });
    }
    
    /**
     * Configura fechamento com tecla ESC
     */
    function configurarTeclaESC() {
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Procurar qualquer modal aberto
                const modalAberto = document.querySelector('.modal.show, .content-modal.show');
                
                if (modalAberto) {
                    fecharModal(modalAberto);
                    console.log('Modal fechado pela tecla ESC:', modalAberto.id || 'sem id');
                }
            }
        });
    }
    
    /**
     * Configura botões que abrem modais
     */
    function configurarBotoesAbrir() {
        const botoesAbrir = document.querySelectorAll('[data-toggle="modal"]');
        
        botoesAbrir.forEach(botao => {
            botao.addEventListener('click', function(e) {
                e.preventDefault();
                
                const seletorAlvo = this.getAttribute('data-target');
                const modalAlvo = document.querySelector(seletorAlvo);
                
                if (modalAlvo) {
                    abrirModal(modalAlvo);
                    console.log('Modal aberto:', modalAlvo.id || 'sem id');
                }
            });
        });
    }
    
    /**
     * Abre um modal com animação suave
     */
    function abrirModal(modal) {
        // Se há outro modal aberto, fechar primeiro
        const modaisAbertos = document.querySelectorAll('.modal.show, .content-modal.show');
        modaisAbertos.forEach(modalAberto => {
            if (modalAberto !== modal) {
                fecharModalImediatamente(modalAberto);
            }
        });
        
        // Remover backdrops existentes
        removeBackdrops();
        
        // Criar novo backdrop
        const backdrop = document.createElement('div');
        backdrop.className = 'modal-backdrop fade show';
        document.body.appendChild(backdrop);
        
        // Mostrar o modal
        modal.classList.add('show');
        modal.style.display = 'block';
        
        // Bloquear rolagem da página
        document.body.classList.add('modal-open');
        document.body.style.overflow = 'hidden';
        
        // Compensar largura da barra de rolagem
        const larguraScrollbar = window.innerWidth - document.documentElement.clientWidth;
        if (larguraScrollbar > 0) {
            document.body.style.paddingRight = larguraScrollbar + 'px';
        }
    }
    
    /**
     * Fecha um modal com animação suave
     */
    function fecharModal(modal) {
        // Parar reprodução de vídeos
        const iframes = modal.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            iframe.src = ''; // Parar reprodução
            
            // Limpar container
            if (iframe.parentNode) {
                iframe.parentNode.innerHTML = '';
            }
        });
        
        // Esconder o modal
        modal.classList.remove('show');
        modal.style.display = 'none';
        
        // Remover TODOS os backdrops
        removeBackdrops();
        
        // Restaurar estado do body
        resetBodyState();
    }
    
    /**
     * Fecha um modal imediatamente sem animação
     */
    function fecharModalImediatamente(modal) {
        // Parar reprodução de vídeos
        const iframes = modal.querySelectorAll('iframe');
        iframes.forEach(iframe => {
            iframe.src = '';
            
            if (iframe.parentNode) {
                iframe.parentNode.innerHTML = '';
            }
        });
        
        // Esconder imediatamente
        modal.classList.remove('show');
        modal.style.display = 'none';
    }
    
    /**
     * Remove todos os backdrops
     */
    function removeBackdrops() {
        document.querySelectorAll('.modal-backdrop').forEach(backdrop => {
            backdrop.remove();
        });
    }
    
    /**
     * Reseta o estado do body
     */
    function resetBodyState() {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }
    
    /**
     * Reseta todo o sistema de modais
     */
    function resetModalSystem() {
        // Fechar todos os modais
        document.querySelectorAll('.modal, .content-modal').forEach(modal => {
            modal.classList.remove('show');
            modal.style.display = 'none';
        });
        
        // Remover backdrops
        removeBackdrops();
        
        // Resetar body
        resetBodyState();
        
        // Reconfigurar event listeners
        configurarBotoesFechar();
        configurarFechamentoFora();
    }
    
    /**
     * Adiciona botão de emergência
     */
    function adicionarBotaoEmergencia() {
        // Remover botão existente para evitar duplicação
        const botaoExistente = document.getElementById('emergency-modal-reset');
        if (botaoExistente) {
            botaoExistente.remove();
        }
        
        // Criar botão de emergência
        const botaoReset = document.createElement('button');
        botaoReset.id = 'emergency-modal-reset';
        botaoReset.textContent = 'Resetar Modais';
        botaoReset.style.position = 'fixed';
        botaoReset.style.bottom = '10px';
        botaoReset.style.right = '10px';
        botaoReset.style.zIndex = '9999';
        botaoReset.style.background = '#FF3333';
        botaoReset.style.color = 'white';
        botaoReset.style.border = 'none';
        botaoReset.style.borderRadius = '5px';
        botaoReset.style.padding = '10px 15px';
        botaoReset.style.fontWeight = 'bold';
        botaoReset.style.cursor = 'pointer';
        botaoReset.style.display = 'none';
        botaoReset.style.boxShadow = '0 2px 10px rgba(0, 0, 0, 0.3)';
        
        // Adicionar ao body
        document.body.appendChild(botaoReset);
        
        // Adicionar evento de clique
        botaoReset.addEventListener('click', function() {
            resetModalSystem();
            this.style.display = 'none';
            
            // Exibir mensagem
            const mensagem = document.createElement('div');
            mensagem.textContent = 'Sistema de modais resetado com sucesso';
            mensagem.style.position = 'fixed';
            mensagem.style.bottom = '60px';
            mensagem.style.left = '50%';
            mensagem.style.transform = 'translateX(-50%)';
            mensagem.style.background = 'rgba(0, 0, 0, 0.8)';
            mensagem.style.color = 'white';
            mensagem.style.padding = '10px 20px';
            mensagem.style.borderRadius = '5px';
            mensagem.style.zIndex = '9999';
            
            document.body.appendChild(mensagem);
            
            // Remover mensagem após 3 segundos
            setTimeout(() => {
                mensagem.remove();
            }, 3000);
        });
        
        // Configurar detecção de sequência de ESC
        let contadorESC = 0;
        let ultimoESCTempo = 0;
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const agora = Date.now();
                
                // Verificar se foi uma sequência rápida
                if (agora - ultimoESCTempo < 500) {
                    contadorESC++;
                } else {
                    contadorESC = 1;
                }
                
                ultimoESCTempo = agora;
                
                // Após 3 ESCs rápidos, mostrar botão
                if (contadorESC >= 3) {
                    botaoReset.style.display = 'block';
                    contadorESC = 0;
                }
            }
        });
    }
    
    /**
     * Inicia monitoramento para problemas com modais
     */
    function iniciarMonitoramento() {
        // Verificar problemas iniciais após carregamento
        setTimeout(verificarProblemas, 3000);
        
        // Verificação periódica
        setInterval(verificarProblemas, 10000);
        
        // Observar mudanças no DOM
        const observer = new MutationObserver(function(mutations) {
            mutations.forEach(function(mutation) {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    setTimeout(verificarProblemas, 500);
                }
            });
        });
        
        observer.observe(document.body, { childList: true, subtree: true });
    }
    
    /**
     * Verifica problemas comuns com modais
     */
    function verificarProblemas() {
        const temBackdrop = document.querySelector('.modal-backdrop');
        const temModalAberto = document.querySelector('.modal.show, .content-modal.show');
        const bodyBloqueado = document.body.classList.contains('modal-open');
        
        // Problema: backdrop sem modal aberto
        if (temBackdrop && !temModalAberto) {
            console.warn('Problema detectado: backdrop sem modal aberto - corrigindo');
            removeBackdrops();
        }
        
        // Problema: body bloqueado sem modal aberto
        if (bodyBloqueado && !temModalAberto) {
            console.warn('Problema detectado: body bloqueado sem modal aberto - corrigindo');
            resetBodyState();
        }
        
        // Problema: modal aberto sem backdrop 
        if (temModalAberto && !temBackdrop) {
            console.warn('Problema detectado: modal aberto sem backdrop - corrigindo');
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
        
        // Mostrar botão de emergência se detectar problemas
        if ((temBackdrop && !temModalAberto) || (bodyBloqueado && !temModalAberto)) {
            const botaoEmergencia = document.getElementById('emergency-modal-reset');
            if (botaoEmergencia) {
                botaoEmergencia.style.display = 'block';
            }
        }
    }
    
    // Expor API para uso global
    window.modalManager = {
        open: abrirModal,
        close: fecharModal,
        reset: resetModalSystem
    };
});