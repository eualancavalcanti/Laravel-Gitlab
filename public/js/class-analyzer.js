/**
 * Script Auxiliar para Identificação de Classes não Migradas
 * 
 * Este script deve ser carregado temporariamente durante o desenvolvimento
 * para ajudar a identificar classes que ainda não receberam o prefixo hb-
 */
document.addEventListener('DOMContentLoaded', function() {
    // Lista de classes gerais que não precisam ser migradas
    const commonClasses = [
        'container', 'row', 'col', 'btn', 'active', 'show', 'modal', 
        'fade', 'collapse', 'tab', 'nav', 'card', 'alert', 'badge',
        'text-center', 'text-right', 'text-left', 'mr', 'ml', 'mt', 'mb',
        'pt', 'pb', 'pl', 'pr', 'px', 'py', 'd-flex', 'd-block', 'd-none',
        'justify-content-center', 'align-items-center', 'flex-column',
        'w-100', 'h-100', 'img-fluid', 'shadow', 'rounded', 'section-header',
        'section-container', 'nav-btn', 'prev', 'next', 'carousel-nav',
        'lucide', 'search-icon'
    ];

    // Prefixos de classes que já estão no formato correto ou que são classes de terceiros
    const validPrefixes = [
        'hb-', 'btn-', 'fa-', 'fas ', 'far ', 'fab ', 'lucide-', 'swiper-',
        'modal-', 'carousel-', 'js-', 'text-', 'bg-', 'd-', 'p-', 'm-', 'w-', 'h-'
    ];

    // Função para verificar se uma classe precisa ser migrada
    function shouldBeMigrated(className) {
        if (!className || className.trim() === '') return false;
        if (commonClasses.includes(className)) return false;
        
        // Verificar prefixos válidos
        for (const prefix of validPrefixes) {
            if (className.startsWith(prefix)) return false;
        }
        
        return true;
    }

    // Analisar todos os elementos da página
    function analyzeAllElements() {
        const allElements = document.querySelectorAll('*');
        const candidateClasses = new Set();
        
        // Coletar todas as classes candidatas à migração
        allElements.forEach(element => {
            Array.from(element.classList).forEach(className => {
                if (shouldBeMigrated(className)) {
                    candidateClasses.add(className);
                }
            });
        });
        
        // Converter para array e ordenar
        const sortedCandidates = Array.from(candidateClasses).sort();
        
        // Gerar código para mapeamento
        let mappingCode = '// Novas classes para migração:\n';
        mappingCode += 'const newClassMapping = {\n';
        
        sortedCandidates.forEach(className => {
            mappingCode += `    '${className}': 'hb-${className}',\n`;
        });
        
        mappingCode += '};\n\n';
        mappingCode += '// Adicionar ao mapeamento principal\n';
        mappingCode += 'Object.assign(classMapping, newClassMapping);';
        
        // Resultado da análise
        console.log(`Identificadas ${sortedCandidates.length} classes candidatas para migração:`);
        console.log(sortedCandidates);
        console.log('\nCódigo para adicionar ao migrate-legacy-elements.js:');
        console.log(mappingCode);
        
        // Criar um elemento flutuante para mostrar o resultado
        createResultOverlay(sortedCandidates);
    }    // Criar uma sobreposição para mostrar o resultado
    function createResultOverlay(candidateClasses) {
        // Verificar se o console de migração já está ativo
        if (window.logMessage && typeof window.logMessage === 'function') {
            window.logMessage(`Análise concluída: ${candidateClasses.length} classes para migração encontradas`);
            candidateClasses.forEach(className => {
                window.logMessage(`Classe para migrar: ${className} → hb-${className}`);
            });
            return; // Não criar overlay se já temos o console
        }
        
        // Criar o elemento de sobreposição
        const overlay = document.createElement('div');
        overlay.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            width: 400px;
            max-height: 80vh;
            background: rgba(30, 30, 30, 0.95);
            border: 1px solid #FF3333;
            border-radius: 8px;
            padding: 15px;
            color: white;
            z-index: 9999;
            font-family: monospace;
            overflow-y: auto;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
        `;
        
        // Adicionar título
        const title = document.createElement('h3');
        title.textContent = 'Classes a serem migradas';
        title.style.cssText = `
            margin: 0 0 15px 0;
            color: #FF3333;
            font-size: 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 10px;
        `;
        overlay.appendChild(title);
        
        // Adicionar contagem
        const count = document.createElement('p');
        count.textContent = `Encontradas ${candidateClasses.length} classes para adicionar prefixo 'hb-'`;
        count.style.cssText = `
            margin: 0 0 10px 0;
            font-size: 14px;
        `;
        overlay.appendChild(count);
        
        // Adicionar lista de classes
        const list = document.createElement('ul');
        list.style.cssText = `
            margin: 0 0 15px 0;
            padding: 0 0 0 20px;
            font-size: 13px;
            line-height: 1.5;
        `;
        
        candidateClasses.forEach(className => {
            const item = document.createElement('li');
            item.textContent = `${className} → hb-${className}`;
            list.appendChild(item);
        });
        overlay.appendChild(list);
        
        // Adicionar botão para fechar
        const closeBtn = document.createElement('button');
        closeBtn.textContent = 'Fechar';
        closeBtn.style.cssText = `
            background: #FF3333;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 0 0 auto;
        `;
        closeBtn.onclick = function() {
            document.body.removeChild(overlay);
        };
        overlay.appendChild(closeBtn);
        
        // Adicionar à página
        document.body.appendChild(overlay);
    }

    // Executar a análise após um pequeno atraso
    setTimeout(analyzeAllElements, 1000);
    
    // Adicionar botão flutuante para análise manual
    const analyzeButton = document.createElement('button');
    analyzeButton.textContent = '🔍 Analisar Classes';
    analyzeButton.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #FF3333;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        cursor: pointer;
        z-index: 9999;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
    `;    analyzeButton.onclick = analyzeAllElements;
    document.body.appendChild(analyzeButton);
    
    // Expor função para uso externo (console de migração)
    window.analyzeAllElements = analyzeAllElements;
});
