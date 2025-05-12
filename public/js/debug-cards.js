/**
 * HotBoys - Depuração de Migração de Classes
 * Script para ativar a depuração visual de elementos migrados e não migrados
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se o modo de depuração está ativado via URL
    const urlParams = new URLSearchParams(window.location.search);
    const debugMode = urlParams.get('debug') === 'true';
    
    // Adicionar classe ao body se o modo de depuração estiver ativado
    if (debugMode) {
        document.body.classList.add('debug-migration');
        createDebugInfo();
    }
    
    // Função para criar painel de informações de depuração
    function createDebugInfo() {
        // Criar o elemento de informações
        const debugInfo = document.createElement('div');
        debugInfo.className = 'hb-migration-debug';
        
        // Função para atualizar estatísticas
        function updateStats() {
            // Contar elementos
            const oldCards = document.querySelectorAll('.content-card:not(.hb-content-card)').length;
            const newCards = document.querySelectorAll('.hb-content-card').length;
            const totalElements = document.querySelectorAll('[class*="hb-"]').length;
            
            // Atualizar conteúdo
            debugInfo.innerHTML = `
                <h4 style="margin: 0 0 5px 0; color: #FF3333;">Debug de Migração</h4>
                <div>Elementos antigos: <span style="color: red;">${oldCards}</span></div>
                <div>Elementos novos: <span style="color: green;">${newCards}</span></div>
                <div>Total elementos migrados: <span style="color: yellow;">${totalElements}</span></div>
                <div style="margin-top: 5px; font-size: 10px; color: #999;">Pressione CTRL+SHIFT+M para abrir o console de administração</div>
            `;
        }
        
        // Atualizar estatísticas iniciais
        updateStats();
        
        // Atualizar a cada 3 segundos
        setInterval(updateStats, 3000);
        
        // Adicionar ao documento
        document.body.appendChild(debugInfo);
    }
    
    // Adicionar opção de debug no console de migração
    if (typeof window.logMessage === 'function') {
        window.logMessage('Modo debug visual ' + (debugMode ? 'ativado' : 'desativado'));
        
        // Adicionar comando para alternar modo debug
        window.toggleDebugVisual = function() {
            if (document.body.classList.contains('debug-migration')) {
                document.body.classList.remove('debug-migration');
                window.logMessage('Modo debug visual desativado');
            } else {
                document.body.classList.add('debug-migration');
                window.logMessage('Modo debug visual ativado');
                createDebugInfo();
            }
        };
    }
});
