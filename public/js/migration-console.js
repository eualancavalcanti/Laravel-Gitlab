/**
 * Console de Administração para Migração de Elementos
 * Permite monitorar e controlar o processo de migração
 * Acessível com CTRL+SHIFT+M
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se o modo debug está ativado
    const urlParams = new URLSearchParams(window.location.search);
    const adminMode = urlParams.get('admin') === 'true';
    
    // Variáveis de estado
    let isConsoleVisible = false;
    let autoMigrationEnabled = true;
    let devConsole;
    
    // Criar e configurar o console de administração
    function createAdminConsole() {
        // Criar o container principal
        devConsole = document.createElement('div');
        devConsole.className = 'hb-admin-console';
        devConsole.style.position = 'fixed';
        devConsole.style.bottom = '10px';
        devConsole.style.right = '10px';
        devConsole.style.width = '350px';
        devConsole.style.maxHeight = '500px';
        devConsole.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
        devConsole.style.color = '#00FF00';
        devConsole.style.fontFamily = 'monospace';
        devConsole.style.fontSize = '12px';
        devConsole.style.padding = '10px';
        devConsole.style.borderRadius = '5px';
        devConsole.style.boxShadow = '0 0 10px rgba(0, 0, 0, 0.5)';
        devConsole.style.zIndex = '99999';
        devConsole.style.overflowY = 'auto';
        devConsole.style.display = 'none';
        
        // Cabeçalho
        const header = document.createElement('div');
        header.style.display = 'flex';
        header.style.justifyContent = 'space-between';
        header.style.alignItems = 'center';
        header.style.marginBottom = '10px';
        header.style.borderBottom = '1px solid #333';
        header.style.paddingBottom = '5px';
        
        const title = document.createElement('h3');
        title.textContent = 'Console de Migração';
        title.style.margin = '0';
        title.style.color = '#FF3333';
        
        const closeBtn = document.createElement('button');
        closeBtn.innerHTML = '&times;';
        closeBtn.style.background = 'none';
        closeBtn.style.border = 'none';
        closeBtn.style.color = '#FF3333';
        closeBtn.style.fontSize = '16px';
        closeBtn.style.cursor = 'pointer';
        closeBtn.onclick = toggleConsole;
        
        header.appendChild(title);
        header.appendChild(closeBtn);
        
        // Corpo
        const body = document.createElement('div');
        body.style.marginBottom = '10px';
        
        // Contadores
        const counters = document.createElement('div');
        counters.className = 'hb-migration-stats';
        counters.style.display = 'grid';
        counters.style.gridTemplateColumns = '1fr 1fr';
        counters.style.gap = '5px';
        counters.style.marginBottom = '10px';
        
        // Função para criar contador
        function createCounter(label, id) {
            const counterDiv = document.createElement('div');
            counterDiv.style.border = '1px solid #333';
            counterDiv.style.padding = '5px';
            counterDiv.style.borderRadius = '3px';
            
            const counterLabel = document.createElement('div');
            counterLabel.textContent = label;
            counterLabel.style.fontSize = '10px';
            counterLabel.style.color = '#999';
            
            const counterValue = document.createElement('div');
            counterValue.id = id;
            counterValue.textContent = '0';
            counterValue.style.fontSize = '16px';
            counterValue.style.marginTop = '2px';
            
            counterDiv.appendChild(counterLabel);
            counterDiv.appendChild(counterValue);
            
            return counterDiv;
        }
        
        // Adicionar contadores
        counters.appendChild(createCounter('Cards Antigos', 'old-cards-count'));
        counters.appendChild(createCounter('Cards Novos', 'new-cards-count'));
        counters.appendChild(createCounter('Total de Elementos', 'total-elements'));
        counters.appendChild(createCounter('Elementos Migrados', 'migrated-elements'));
        
        // Controles e botões
        const controls = document.createElement('div');
        controls.style.marginBottom = '10px';
        
        // Toggle para migração automática
        const autoMigrationToggle = document.createElement('div');
        autoMigrationToggle.style.display = 'flex';
        autoMigrationToggle.style.alignItems = 'center';
        autoMigrationToggle.style.marginBottom = '5px';
        
        const toggleCheckbox = document.createElement('input');
        toggleCheckbox.type = 'checkbox';
        toggleCheckbox.id = 'auto-migration-toggle';
        toggleCheckbox.checked = autoMigrationEnabled;
        toggleCheckbox.style.marginRight = '5px';
        toggleCheckbox.addEventListener('change', function() {
            autoMigrationEnabled = this.checked;
            logMessage(`Migração automática ${autoMigrationEnabled ? 'ativada' : 'desativada'}`);
            
            // Atualizar variável global para o script de migração
            window.HB_AUTOMIGRATION_ENABLED = autoMigrationEnabled;
            
            // Salvar preferência no localStorage
            localStorage.setItem('hb-auto-migration', autoMigrationEnabled);
        });
        
        const toggleLabel = document.createElement('label');
        toggleLabel.htmlFor = 'auto-migration-toggle';
        toggleLabel.textContent = 'Migração Automática Ativa';
        
        autoMigrationToggle.appendChild(toggleCheckbox);
        autoMigrationToggle.appendChild(toggleLabel);
        
        // Botões de ação
        const actionButtons = document.createElement('div');
        actionButtons.style.display = 'grid';
        actionButtons.style.gridTemplateColumns = '1fr 1fr';
        actionButtons.style.gap = '5px';
        
        // Função para criar botão
        function createButton(label, onClick, color = '#333') {
            const button = document.createElement('button');
            button.textContent = label;
            button.style.backgroundColor = color;
            button.style.color = 'white';
            button.style.border = 'none';
            button.style.borderRadius = '3px';
            button.style.padding = '5px';
            button.style.cursor = 'pointer';
            button.onclick = onClick;
            return button;
        }
          // Botões de ação
        actionButtons.appendChild(createButton('Executar Migração', runMigration, '#007bff'));
        actionButtons.appendChild(createButton('Verificar Classes', checkClasses, '#28a745'));
        actionButtons.appendChild(createButton('Analisar Migração', analyzeClassesForMigration, '#fd7e14'));
        actionButtons.appendChild(createButton('Limpar Log', clearLog, '#dc3545'));
        
        controls.appendChild(autoMigrationToggle);
        controls.appendChild(actionButtons);
          // Log
        const logContainer = document.createElement('div');
        logContainer.style.backgroundColor = '#111';
        logContainer.style.padding = '5px';
        logContainer.style.borderRadius = '3px';
        logContainer.style.height = '150px';
        logContainer.style.overflowY = 'auto';
        logContainer.style.marginBottom = '10px';
        
        const logContent = document.createElement('div');
        logContent.id = 'migration-log';
        logContent.style.fontFamily = 'monospace';
        logContent.style.fontSize = '11px';
        logContent.style.color = '#ddd';
        logContent.style.whiteSpace = 'pre-wrap';
        
        logContainer.appendChild(logContent);
        
        // Rodapé com links de utilidade
        const footer = document.createElement('div');
        footer.style.display = 'flex';
        footer.style.justifyContent = 'space-between';
        footer.style.fontSize = '10px';
        footer.style.color = '#999';
        footer.style.marginTop = '5px';
        
        const debugLink = document.createElement('a');
        debugLink.textContent = 'Modo Debug';
        debugLink.href = '?migration=debug';
        debugLink.style.color = '#999';
        
        const resetLink = document.createElement('a');
        resetLink.textContent = 'Redefinir Configurações';
        resetLink.href = '#';
        resetLink.style.color = '#999';
        resetLink.onclick = function(e) {
            e.preventDefault();
            localStorage.removeItem('hb-auto-migration');
            logMessage('Configurações redefinidas. Recarregando...');
            setTimeout(() => window.location.reload(), 1500);
        };
        
        footer.appendChild(debugLink);
        footer.appendChild(resetLink);
        
        // Adicionar todos os elementos ao console
        body.appendChild(counters);
        body.appendChild(controls);
        body.appendChild(logContainer);
        body.appendChild(footer);
        
        devConsole.appendChild(header);
        devConsole.appendChild(body);
        
        // Adicionar ao documento
        document.body.appendChild(devConsole);
        
        // Iniciar com mensagem de boas-vindas
        logMessage('Console de Migração Inicializado');
        logMessage('Pressione CTRL+SHIFT+M para abrir/fechar');
          // Carregar preferência do localStorage
        if (localStorage.getItem('hb-auto-migration') !== null) {
            autoMigrationEnabled = localStorage.getItem('hb-auto-migration') === 'true';
            toggleCheckbox.checked = autoMigrationEnabled;
            window.HB_AUTOMIGRATION_ENABLED = autoMigrationEnabled;
            logMessage(`Configuração carregada: Migração automática ${autoMigrationEnabled ? 'ativada' : 'desativada'}`);
        } else {
            // Definir valor padrão no localStorage se não existir
            localStorage.setItem('hb-auto-migration', autoMigrationEnabled);
        }
        
        // Expor globalmente
        window.HB_AUTOMIGRATION_ENABLED = autoMigrationEnabled;
    }
      // Função para adicionar mensagem ao log
    function logMessage(message) {
        if (!devConsole) return;
        
        const logContent = document.getElementById('migration-log');
        if (!logContent) return;
        
        const timestamp = new Date().toLocaleTimeString();
        const logEntry = document.createElement('div');
        logEntry.innerHTML = `<span style="color:#999">[${timestamp}]</span> ${message}`;
        
        logContent.appendChild(logEntry);
        logContent.scrollTop = logContent.scrollHeight;
    }
    
    // Expor a função de log para outros scripts
    window.logMessage = logMessage;
    
    // Função para limpar o log
    function clearLog() {
        const logContent = document.getElementById('migration-log');
        if (logContent) {
            logContent.innerHTML = '';
            logMessage('Log limpo');
        }
    }
      // Função para executar migração manual
    function runMigration() {
        logMessage('Iniciando migração manual...');
        
        // Verificar se o script de migração está disponível
        if (typeof window.migrateAllElements === 'function') {
            const migratedCount = window.migrateAllElements();
            logMessage(`Migração concluída: ${migratedCount} elementos processados`);
        } else {
            logMessage('Erro: Script de migração não encontrado. Executando função interna.');
            
            // Executar migração interna
            let migratedCount = 0;
            
            // Mapeamento de classes
            const classMapping = {
                'content-card': 'hb-content-card',
                'content-grid': 'hb-content-grid',
                'hero-slide': 'hb-hero-slide',
                // Adicionar outros mapeamentos conforme necessário
            };
            
            // Migrar classes
            Object.keys(classMapping).forEach(oldClass => {
                const elements = document.querySelectorAll(`.${oldClass}:not(.${classMapping[oldClass]})`);
                elements.forEach(element => {
                    element.classList.add(classMapping[oldClass]);
                    migratedCount++;
                });
            });
            
            logMessage(`Migrados ${migratedCount} elementos.`);
        }
        
        // Atualizar contadores
        updateStats();
    }
    
    // Função para verificar classes
    function checkClasses() {
        logMessage('Verificando classes no documento...');
        
        // Lista de classes antigas
        const oldClasses = [
            'content-card', 'content-grid', 'hero-slide', 'actors-carousel',
            'actor-card', 'creator-card', 'creator-card-premium'
        ];
        
        // Lista de classes novas
        const newClasses = [
            'hb-content-card', 'hb-content-grid', 'hb-hero-slide', 'hb-actors-carousel',
            'hb-actor-card', 'hb-creator-card', 'hb-creator-card-premium'
        ];
        
        // Verificar cada classe
        oldClasses.forEach(className => {
            const count = document.querySelectorAll(`.${className}`).length;
            if (count > 0) {
                logMessage(`Classe antiga "${className}": ${count} elementos`);
            }
        });
        
        newClasses.forEach(className => {
            const count = document.querySelectorAll(`.${className}`).length;
            if (count > 0) {
                logMessage(`Classe nova "${className}": ${count} elementos`);
            }
        });
        
        // Atualizar contadores
        updateStats();
    }
      // Função para verificar JavaScript
    function checkJavaScript() {
        logMessage('Verificando scripts na página...');
        
        // Contar scripts
        const scripts = document.querySelectorAll('script');
        logMessage(`Total de scripts: ${scripts.length}`);
        
        // Verificar scripts inline
        const inlineScripts = document.querySelectorAll('script:not([src])');
        logMessage(`Scripts inline: ${inlineScripts.length}`);
        
        // Verificar referências às classes antigas nos scripts inline
        const oldReferences = [
            'content-card', 'content-grid', 'hero-slide', 'actors-carousel'
        ];
        
        // Contador de referências
        let totalReferences = 0;
        
        inlineScripts.forEach((script, index) => {
            if (!script.textContent) return;
            
            let scriptReferences = 0;
            
            oldReferences.forEach(reference => {
                const regex = new RegExp(`\\.${reference}\\b|"${reference}"|'${reference}'`, 'g');
                const matches = (script.textContent.match(regex) || []).length;
                if (matches > 0) {
                    scriptReferences += matches;
                }
            });
            
            if (scriptReferences > 0) {
                totalReferences += scriptReferences;
                logMessage(`Script #${index + 1}: ${scriptReferences} referências às classes antigas`);
            }
        });
        
        logMessage(`Total de referências às classes antigas: ${totalReferences}`);
    }
    
    // Função para analisar classes que precisam de migração usando class-analyzer.js
    function analyzeClassesForMigration() {
        logMessage('Iniciando análise profunda de classes para migração...');
        
        // Verificar se o script analisador está disponível
        if (typeof window.analyzeAllElements === 'function') {
            window.analyzeAllElements();
            logMessage('Análise concluída');
        } else {
            // Carregar o script dinamicamente se não estiver disponível
            logMessage('Carregando o script de análise de classes...');
            
            const script = document.createElement('script');
            script.src = '/js/class-analyzer.js';
            script.onload = function() {
                if (typeof window.analyzeAllElements === 'function') {
                    logMessage('Script carregado, iniciando análise...');
                    window.analyzeAllElements();
                } else {
                    logMessage('Erro: Função de análise não encontrada no script');
                }
            };
            script.onerror = function() {
                logMessage('Erro: Não foi possível carregar o script de análise');
            };
            
            document.head.appendChild(script);
        }
    }    // Função para atualizar estatísticas
    function updateStats() {
        // Usar as estatísticas do script de migração se disponível
        if (typeof window.getMigrationStats === 'function') {
            const stats = window.getMigrationStats();
            
            document.getElementById('old-cards-count').textContent = stats.oldCards;
            document.getElementById('new-cards-count').textContent = stats.newCards;
            document.getElementById('total-elements').textContent = stats.totalElements;
            document.getElementById('migrated-elements').textContent = stats.totalMigrated;
            
            // Registrar no log se for a primeira atualização
            if (!window.statUpdateCount) {
                window.statUpdateCount = 1;
                logMessage(`Estatísticas iniciais: ${stats.totalMigrated} elementos com prefixo hb-`);
            }
            
            return;
        }
        
        // Caso o script de migração não esteja disponível, usar contagens manuais
        const oldCards = document.querySelectorAll('.content-card:not(.hb-content-card)').length;
        document.getElementById('old-cards-count').textContent = oldCards;
        
        // Contar elementos novos
        const newCards = document.querySelectorAll('.hb-content-card').length;
        document.getElementById('new-cards-count').textContent = newCards;
        
        // Contar total de elementos (aproximado)
        const totalElements = document.querySelectorAll('*').length;
        document.getElementById('total-elements').textContent = totalElements;
        
        // Contar elementos migrados (aproximado - todos com prefixo hb-)
        const migratedElements = document.querySelectorAll('[class*="hb-"]').length;
        document.getElementById('migrated-elements').textContent = migratedElements;
        
        // Registrar no log se for a primeira atualização
        if (!window.statUpdateCount) {
            window.statUpdateCount = 1;
            logMessage(`Estatísticas iniciais: ${migratedElements} elementos com prefixo hb-`);
        }
    }
    
    // Expor função para atualização de estatísticas globalmente
    window.updateMigrationStats = updateStats;
      // Função para alternar visibilidade do console
    function toggleConsole() {
        if (!devConsole) {
            createAdminConsole();
        }
        
        isConsoleVisible = !isConsoleVisible;
        devConsole.style.display = isConsoleVisible ? 'block' : 'none';
        
        if (isConsoleVisible) {
            updateStats();
            
            // Iniciar atualização automática das estatísticas enquanto o console estiver visível
            if (!window.statsInterval) {
                window.statsInterval = setInterval(function() {
                    if (isConsoleVisible) {
                        updateStats();
                    } else {
                        clearInterval(window.statsInterval);
                        window.statsInterval = null;
                    }
                }, 3000); // Atualizar a cada 3 segundos
            }
        } else {
            // Parar a atualização quando o console for fechado
            if (window.statsInterval) {
                clearInterval(window.statsInterval);
                window.statsInterval = null;
            }
        }
    }
    
    // Adicionar keydown listener para CTRL+SHIFT+M
    document.addEventListener('keydown', function(e) {
        // CTRL+SHIFT+M (77 é o código para 'M')
        if (e.ctrlKey && e.shiftKey && e.keyCode === 77) {
            toggleConsole();
        }
    });
      // Inicializar console se em modo admin
    if (adminMode) {
        createAdminConsole();
        isConsoleVisible = true;
        devConsole.style.display = 'block';
        updateStats();
    }
    
    // Carregar automaticamente se a URL contiver parâmetro migration=debug
    if (urlParams.get('migration') === 'debug') {
        createAdminConsole();
        isConsoleVisible = true;
        devConsole.style.display = 'block';
        updateStats();
        logMessage('Console de migração iniciado via parâmetro URL');
    }
});
