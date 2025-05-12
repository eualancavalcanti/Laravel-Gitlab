/**
 * HotBoys - Validador de Migração
 * Este script verifica continuamente a migração de classes CSS e reporta problemas.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Configurações
    const config = {
        enableValidation: true,      // Habilitar validação automática
        reportToConsole: true,       // Reportar problemas no console do navegador
        notifyMigrationConsole: true, // Enviar problemas para o console de migração
        checkInterval: 5000,         // Intervalo entre verificações (ms)
        ignoredClasses: [            // Classes que não precisam ser migradas
            'container', 'row', 'col', 'active', 'show', 'fade',
            'btn', 'text-center', 'd-flex', 'w-100', 'modal',
            'form-control', 'card', 'navbar', 'nav', 'dropdown'
        ],
        classesToCheck: [            // Classes que devem ser migradas (adicione conforme necessário)
            'content-card', 'hero-slide', 'actor-card', 'creator-card',
            'content-grid', 'thumbnail', 'profile-photo', 'creator-info'
        ]
    };

    // Verificar se estamos em modo de desenvolvimento
    const isDevelopment = 
        window.location.hostname === 'localhost' || 
        window.location.hostname === '127.0.0.1' ||
        window.location.hostname.includes('test') ||
        window.location.hostname.includes('dev');
    
    // Desabilitar em produção
    if (!isDevelopment) {
        return;
    }
    
    // Criar contador global para estatísticas
    window.migrationStats = {
        elementsToMigrate: 0,
        elementsMigrated: 0,
        jsErrors: 0,
        lastCheck: null
    };
    
    // Executar a validação inicial após carregamento completo
    setTimeout(validateMigration, 1500);
    
    // Configurar validação recorrente
    if (config.enableValidation) {
        setInterval(validateMigration, config.checkInterval);
    }
    
    // Monitorar mudanças no DOM para validar após carregamentos dinâmicos
    const observer = new MutationObserver(function(mutations) {
        let shouldValidate = false;
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Verificar se algum dos novos elementos tem classes que precisamos verificar
                Array.from(mutation.addedNodes).forEach(node => {
                    if (node.nodeType === 1 && node.classList) { // Elemento DOM
                        config.classesToCheck.forEach(className => {
                            if (node.classList.contains(className)) {
                                shouldValidate = true;
                            }
                        });
                    }
                });
            }
        });
        
        if (shouldValidate) {
            setTimeout(validateMigration, 500);
        }
    });
    
    observer.observe(document.body, { childList: true, subtree: true });
    
    // Função principal de validação
    function validateMigration() {
        // 1. Verificar elementos não migrados
        const nonMigratedElements = findNonMigratedElements();
        
        // 2. Verificar erros de JS relacionados à migração
        const jsErrors = checkJSErrors();
        
        // 3. Verificar performance
        const performanceIssues = checkPerformance();
        
        // 4. Relatar resultados
        reportValidationResults(nonMigratedElements, jsErrors, performanceIssues);
        
        // 5. Atualizar estatísticas
        updateMigrationStats(nonMigratedElements.length);
        
        // 6. Armazenar data da última verificação
        window.migrationStats.lastCheck = new Date();
        
        return {
            nonMigratedCount: nonMigratedElements.length,
            jsErrorsCount: jsErrors.length,
            performanceIssues: performanceIssues
        };
    }
    
    // Encontrar elementos que ainda não foram migrados
    function findNonMigratedElements() {
        const nonMigratedElements = [];
        
        // Verificar cada classe que deve ser migrada
        config.classesToCheck.forEach(className => {
            const elements = document.querySelectorAll(`.${className}:not(.hb-${className})`);
            elements.forEach(element => {
                // Verificar se o elemento não está em uma lista de exceções
                if (
                    element.tagName !== 'SCRIPT' && 
                    element.tagName !== 'STYLE' && 
                    !element.closest('.no-migration') && // Ignorar elementos marcados para não migrar
                    !element.classList.contains('no-migration')
                ) {
                    nonMigratedElements.push({
                        element: element,
                        className: className,
                        location: getElementPath(element)
                    });
                }
            });
        });
        
        return nonMigratedElements;
    }
    
    // Verificar erros de JS que podem estar relacionados à migração
    function checkJSErrors() {
        // Não há como acessar diretamente os erros do console
        // Esta função serve como placeholder para integração futura
        // com sistemas de monitoramento de erros
        return [];
    }
    
    // Verificar possíveis problemas de performance
    function checkPerformance() {
        // Verificação simplificada de performance
        const performanceIssues = {
            hasPotentialIssues: false,
            details: []
        };
        
        // Se houver muitos elementos com ambas as classes (antiga e nova),
        // isso pode causar sobrecarga no CSS
        const dualClassElements = document.querySelectorAll(
            config.classesToCheck.map(c => `.${c}.hb-${c}`).join(',')
        );
        
        if (dualClassElements.length > 100) {
            performanceIssues.hasPotentialIssues = true;
            performanceIssues.details.push({
                type: 'dual-classes',
                message: `${dualClassElements.length} elementos têm ambas as classes (antiga e nova)`,
                severity: 'warning'
            });
        }
        
        return performanceIssues;
    }
    
    // Reportar resultados da validação
    function reportValidationResults(nonMigratedElements, jsErrors, performanceIssues) {
        if (nonMigratedElements.length === 0 && jsErrors.length === 0 && !performanceIssues.hasPotentialIssues) {
            // Tudo parece bem!
            return;
        }
        
        // 1. Reportar ao console do navegador
        if (config.reportToConsole) {
            if (nonMigratedElements.length > 0) {
                console.group(`%c🔍 Validação de Migração: ${nonMigratedElements.length} elementos não migrados`, 'color: #ff5050; font-weight: bold;');
                
                nonMigratedElements.forEach(item => {
                    console.log(
                        `%cClasse não migrada:%c ${item.className} %c→%c ${item.location}`, 
                        'color: #ff5050', 'color: #ffffff; background: #ff5050; padding: 2px 4px; border-radius: 2px;',
                        'color: gray',
                        'color: white'
                    );
                });
                
                console.groupEnd();
            }
            
            if (performanceIssues.hasPotentialIssues) {
                console.group('%c⚠️ Possíveis problemas de performance', 'color: #ffaa00; font-weight: bold;');
                
                performanceIssues.details.forEach(issue => {
                    console.warn(`${issue.message}`);
                });
                
                console.groupEnd();
            }
        }
        
        // 2. Notificar o console de migração
        if (config.notifyMigrationConsole && typeof window.logMessage === 'function') {
            if (nonMigratedElements.length > 0) {
                window.logMessage(`Encontrados ${nonMigratedElements.length} elementos não migrados`);
                
                // Limitar a quantidade de mensagens para não sobrecarregar o console
                const limit = Math.min(nonMigratedElements.length, 5);
                for (let i = 0; i < limit; i++) {
                    const item = nonMigratedElements[i];
                    window.logMessage(`Elemento não migrado: ${item.className} em ${item.location}`);
                }
                
                if (nonMigratedElements.length > limit) {
                    window.logMessage(`... e mais ${nonMigratedElements.length - limit} elementos`);
                }
            }
            
            if (performanceIssues.hasPotentialIssues) {
                window.logMessage('⚠️ Possíveis problemas de performance detectados');
                performanceIssues.details.forEach(issue => {
                    window.logMessage(`- ${issue.message}`);
                });
            }
        }
    }
    
    // Atualizar estatísticas globais de migração
    function updateMigrationStats(nonMigratedCount) {
        window.migrationStats.elementsToMigrate = 
            nonMigratedCount + window.migrationStats.elementsMigrated;
        
        // Expor função para outros scripts
        window.getMigrationValidationStats = function() {
            return {
                elementsToMigrate: window.migrationStats.elementsToMigrate,
                elementsMigrated: window.migrationStats.elementsMigrated,
                nonMigratedCount: nonMigratedCount,
                lastCheck: window.migrationStats.lastCheck,
                progress: window.migrationStats.elementsToMigrate > 0 
                    ? Math.round((window.migrationStats.elementsMigrated / window.migrationStats.elementsToMigrate) * 100)
                    : 100
            };
        };
    }
    
    // Função auxiliar para obter o caminho do elemento no DOM
    function getElementPath(element) {
        if (!element) return 'unknown';
        
        // Criar um caminho simples até o elemento
        let path = element.tagName.toLowerCase();
        
        // Adicionar ID se existir
        if (element.id) {
            path += `#${element.id}`;
        }
        
        // Adicionar componente ou seção se pudermos identificar
        const parentSection = element.closest('[class*="section"], [class*="component"], [class*="container"]');
        if (parentSection) {
            const sectionClass = Array.from(parentSection.classList)
                .find(cls => cls.includes('section') || cls.includes('component') || cls.includes('container'));
            
            if (sectionClass) {
                path = `${sectionClass} > ${path}`;
            }
        }
        
        return path;
    }
    
    // Expor a função de validação globalmente
    window.validateMigration = validateMigration;
    
    // Se o console de migração estiver disponível, adicionar comando
    if (typeof window.logMessage === 'function') {
        window.logMessage('Validador de migração inicializado');
    }
});
