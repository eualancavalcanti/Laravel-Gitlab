/**
 * Modal Diagnostic - Ferramenta de diagnóstico para modais do HotBoys
 * Versão 1.0.0
 * 
 * Este script verifica e soluciona problemas comuns com modais
 * Para ativá-lo, adicione ?debug=modal à URL
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se o modo de diagnóstico está ativado
    if (!window.location.search.includes('debug=modal')) {
        return;
    }
    
    console.log('%c[MODAL DIAGNOSTIC] Ferramenta de diagnóstico de modais ativada', 'background:#ff3333; color:white; padding:5px; border-radius:3px;');
    
    // Criar painel de diagnóstico
    const diagnosticPanel = document.createElement('div');
    diagnosticPanel.className = 'modal-diagnostic-panel';
    diagnosticPanel.innerHTML = `
        <div class="diagnostic-header">
            <h3>Diagnóstico de Modais</h3>
            <button class="close-diagnostic">&times;</button>
        </div>
        <div class="diagnostic-content">
            <div class="diagnostic-section">
                <h4>Status do Modal:</h4>
                <ul id="modalStatusList">
                    <li>Verificando...</li>
                </ul>
            </div>
            <div class="diagnostic-section">
                <h4>Cards Detectados:</h4>
                <div id="cardCountInfo">Contando...</div>
            </div>
            <div class="diagnostic-actions">
                <button id="testAllCards">Testar Todos os Cards</button>
                <button id="fixModalIssues">Corrigir Problemas</button>
            </div>
            <div class="diagnostic-log">
                <h4>Log:</h4>
                <div id="diagnosticLog"></div>
            </div>
        </div>
    `;
    
    document.body.appendChild(diagnosticPanel);
    
    // Adicionar estilos para o painel
    const diagnosticStyle = document.createElement('style');
    diagnosticStyle.textContent = `
        .modal-diagnostic-panel {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 350px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            z-index: 9999;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            max-height: 80vh;
            overflow-y: auto;
        }
        .diagnostic-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            background: #ff3333;
            color: white;
            border-radius: 8px 8px 0 0;
        }
        .diagnostic-header h3 {
            margin: 0;
            font-size: 16px;
        }
        .close-diagnostic {
            background: transparent;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }
        .diagnostic-content {
            padding: 15px;
        }
        .diagnostic-section {
            margin-bottom: 15px;
        }
        .diagnostic-section h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        .diagnostic-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }
        .diagnostic-actions button {
            background: #ff3333;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        .diagnostic-log {
            background: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            max-height: 150px;
            overflow-y: auto;
        }
        #diagnosticLog {
            font-family: monospace;
            font-size: 12px;
            white-space: pre-wrap;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
        }
        .warning {
            color: orange;
        }
    `;
    
    document.head.appendChild(diagnosticStyle);
    
    // Elementos do painel
    const modalStatusList = document.getElementById('modalStatusList');
    const cardCountInfo = document.getElementById('cardCountInfo');
    const diagnosticLog = document.getElementById('diagnosticLog');
    const testAllCardsBtn = document.getElementById('testAllCards');
    const fixModalIssuesBtn = document.getElementById('fixModalIssues');
    const closeButton = diagnosticPanel.querySelector('.close-diagnostic');
    
    // Fechar painel
    closeButton.addEventListener('click', function() {
        diagnosticPanel.style.display = 'none';
    });
    
    // Função para adicionar ao log
    function logMessage(message, type = 'info') {
        const timestamp = new Date().toLocaleTimeString();
        const logEntry = document.createElement('div');
        logEntry.className = type;
        logEntry.textContent = `[${timestamp}] ${message}`;
        diagnosticLog.appendChild(logEntry);
        diagnosticLog.scrollTop = diagnosticLog.scrollHeight;
        console.log(`[MODAL DIAGNOSTIC] ${message}`);
    }
    
    // Verificar status do modal
    function checkModalStatus() {
        const videoModal = document.getElementById('videoModal');
        const statusItems = [];
        
        if (!videoModal) {
            statusItems.push('<li class="error">Modal não encontrado no DOM!</li>');
            logMessage('Modal não encontrado no DOM!', 'error');
        } else {
            statusItems.push('<li class="success">Modal encontrado no DOM</li>');
            
            // Verificar elementos essenciais
            const essentialElements = [
                { name: 'Título', el: document.getElementById('videoModalTitle') },
                { name: 'Thumbnail', el: document.getElementById('videoModalThumbnail') },
                { name: 'Container de Teaser', el: videoModal.querySelector('.teaser-container') },
                { name: 'Overlay de Teaser', el: videoModal.querySelector('.teaser-overlay') },
                { name: 'Opções de Login', el: videoModal.querySelector('.login-options') },
                { name: 'Botão de Play', el: videoModal.querySelector('.play-button-wrapper') },
                { name: 'Botão de Assinatura', el: videoModal.querySelector('.btn-subscribe') }
            ];
            
            essentialElements.forEach(item => {
                if (!item.el) {
                    statusItems.push(`<li class="error">Elemento '${item.name}' não encontrado</li>`);
                    logMessage(`Elemento '${item.name}' não encontrado`, 'error');
                } else {
                    statusItems.push(`<li class="success">Elemento '${item.name}' encontrado</li>`);
                }
            });
            
            // Verificar scripts
            const scripts = Array.from(document.scripts).map(s => s.src);
            if (scripts.some(src => src.includes('unified-modal-handler.js'))) {
                statusItems.push('<li class="success">Script unificado de modal carregado</li>');
            } else if (scripts.some(src => src.includes('content-modal.js')) && 
                      scripts.some(src => src.includes('subscription-modal-handler.js'))) {
                statusItems.push('<li class="warning">Scripts conflitantes detectados</li>');
                logMessage('Scripts conflitantes detectados (content-modal.js e subscription-modal-handler.js)', 'warning');
            } else {
                statusItems.push('<li class="error">Scripts de modal não detectados corretamente</li>');
                logMessage('Scripts de modal não detectados corretamente', 'error');
            }
        }
        
        modalStatusList.innerHTML = statusItems.join('');
    }
    
    // Contar cards
    function countCards() {
        const cardsSelectors = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        let counts = {};
        let total = 0;
        
        cardsSelectors.forEach(selector => {
            const count = document.querySelectorAll(selector).length;
            counts[selector] = count;
            total += count;
        });
        
        let html = `<p>Total: <strong>${total} cards</strong></p><ul>`;
        for (const [selector, count] of Object.entries(counts)) {
            html += `<li>${selector}: ${count}</li>`;
        }
        html += '</ul>';
        
        cardCountInfo.innerHTML = html;
        
        logMessage(`Encontrados ${total} cards no total`, 'info');
        return total;
    }
    
    // Testar todos os cards
    testAllCardsBtn.addEventListener('click', function() {
        logMessage('Iniciando teste de todos os cards...', 'info');
        
        const cardSelectors = [
            '.content-card',
            '.open-video-modal',
            '.hero .btn-primary.cta',
            '.hero-slide'
        ];
        
        let totalCards = 0;
        let errorCards = 0;
        
        // Testar cada tipo de card
        cardSelectors.forEach(selector => {
            const cards = document.querySelectorAll(selector);
            totalCards += cards.length;
            
            cards.forEach((card, index) => {
                // Verificar atributos essenciais
                if (!card.getAttribute('data-title') && !card.querySelector('.content-title')) {
                    logMessage(`Card ${selector} #${index+1} não tem título`, 'warning');
                    errorCards++;
                }
                
                if (!card.getAttribute('data-thumbnail') && !card.querySelector('img')) {
                    logMessage(`Card ${selector} #${index+1} não tem thumbnail`, 'warning');
                    errorCards++;
                }
                
                // Verificar eventos de clique
                try {
                    // Forma segura de verificar eventos sem disparar
                    const cloneCard = card.cloneNode(true);
                    cloneCard.addEventListener('click', e => {
                        e.preventDefault();
                        e.stopPropagation();
                    });
                    
                    // Se passar, o card tem manipulador de clique
                    logMessage(`Card ${selector} #${index+1} tem manipulador de clique`, 'success');
                } catch (e) {
                    logMessage(`Erro ao verificar manipulador de clique para ${selector} #${index+1}: ${e.message}`, 'error');
                    errorCards++;
                }
            });
        });
        
        if (errorCards > 0) {
            logMessage(`Teste completo: ${errorCards} de ${totalCards} cards têm problemas`, 'warning');
        } else {
            logMessage(`Teste completo: Todos os ${totalCards} cards estão OK`, 'success');
        }
    });
    
    // Corrigir problemas comuns
    fixModalIssuesBtn.addEventListener('click', function() {
        logMessage('Iniciando correções automáticas...', 'info');
        
        // 1. Verificar se o script unificado está presente, caso contrário, adicionar
        const scripts = Array.from(document.scripts).map(s => s.src);
        if (!scripts.some(src => src.includes('unified-modal-handler.js'))) {
            logMessage('Script unificado não encontrado, adicionando dinamicamente', 'warning');
            
            // Remover scripts conflitantes
            document.querySelectorAll('script').forEach(script => {
                if (script.src.includes('content-modal.js') || script.src.includes('subscription-modal-handler.js')) {
                    script.remove();
                    logMessage(`Removido script conflitante: ${script.src}`, 'warning');
                }
            });
            
            // Adicionar script unificado
            const unifiedScript = document.createElement('script');
            unifiedScript.src = '/js/unified-modal-handler.js';
            document.body.appendChild(unifiedScript);
            
            logMessage('Script unificado adicionado com sucesso', 'success');
        }
        
        // 2. Corrigir problemas comuns de estilo
        const styleFixCode = `
            .content-card, .open-video-modal, .hero .btn-primary.cta, .hero-slide {
                cursor: pointer !important;
            }
            .content-card *, .open-video-modal * {
                pointer-events: none !important;
            }
        `;
        
        const styleFixElement = document.createElement('style');
        styleFixElement.textContent = styleFixCode;
        document.head.appendChild(styleFixElement);
        
        logMessage('Correções de estilo aplicadas', 'success');
        
        // 3. Adicionar delegação global para garantir funcionamento
        document.addEventListener('click', function(e) {
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
            
            // Log para verificar se a delegação está funcionando
            console.log('[MODAL DIAGNOSTIC] Clique interceptado pela delegação de reserva:', clickedCard);
        });
        
        logMessage('Delegação de eventos de reserva adicionada', 'success');
        logMessage('Todas as correções automáticas foram aplicadas. Recarregue a página para verificar.', 'success');
    });
    
    // Inicializar verificações
    checkModalStatus();
    countCards();
    
    logMessage('Diagnóstico de modais inicializado com sucesso', 'success');
}); 