/**
 * Migrador de Elementos Legados para Novos
 * Esse script faz uma migração dinâmica de classes antigas para novas
 * Permite funcionar enquanto os templates são atualizados gradualmente
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se a migração automática está habilitada
    window.HB_AUTOMIGRATION_ENABLED = 
        localStorage.getItem('hb-auto-migration') !== 'false';
    
    // Mapeamento de classes antigas para novas
    const classMapping = {
        // Classes do content-carousel
        'content-card': 'hb-content-card',
        'content-card-link': 'hb-content-card-link',
        'content-badge': 'hb-content-badge',
        'content-duration': 'hb-content-duration',
        'content-lock': 'hb-content-lock',
        'content-info': 'hb-content-info',
        'content-title': 'hb-content-title',
        'content-meta': 'hb-content-meta',
        'content-price': 'hb-content-price',
        'content-likes': 'hb-content-likes',
        'content-grid': 'hb-content-grid',
        'content-overlay': 'hb-content-overlay',
        'content-progress': 'hb-content-progress',
        'progress-bar': 'hb-progress-bar',
        'watching-info': 'hb-watching-info',
        'viewers-count': 'hb-viewers-count',
        'play-overlay': 'hb-play-overlay',
        'empty-state': 'hb-empty-state',
        
        // Classes do hero-carousel
        'hero': 'hb-hero',
        'hero-slides': 'hb-hero-slides',
        'hero-slide': 'hb-hero-slide',
        'hero-content': 'hb-hero-content',
        'hero-metadata': 'hb-hero-metadata',
        'hero-description': 'hb-hero-description',
        'hero-buttons': 'hb-hero-buttons',
        'hero-indicators': 'hb-hero-indicators',
        'indicator': 'hb-indicator',
        'date': 'hb-date',
        'vip-badge': 'hb-vip-badge',
        
        // Classes para thumbnails e componentes visuais
        'thumbnail': 'hb-thumbnail',
        'thumbnail-overlay': 'hb-thumbnail-overlay',
        'play-icon': 'hb-play-icon',
        'pack-card': 'hb-pack-card',
        'pack-icon': 'hb-pack-icon',
        'content-items': 'hb-content-items',
        'empty-content': 'hb-empty-content',
        'empty-icon': 'hb-empty-icon',
        'actors-carousel': 'hb-actors-carousel',
        'actor-card': 'hb-actor-card',
        'actor-image': 'hb-actor-image',
        'actor-tags': 'hb-actor-tags',
        'actor-stats': 'hb-actor-stats',
        'creators-carousel': 'hb-creators-carousel',
        'creator-card': 'hb-creator-card',
        'creator-card-premium': 'hb-creator-card-premium',
        'creator-header': 'hb-creator-header',
        'creator-image': 'hb-creator-image',
        'creator-info': 'hb-creator-info',
        'profile-photo': 'hb-profile-photo',
        'verified-badge': 'hb-verified-badge',
        'creator-role': 'hb-creator-role',
        'creator-stats': 'hb-creator-stats',
        'stat': 'hb-stat',
        'stat-info': 'hb-stat-info',
        'stat-value': 'hb-stat-value',        'stat-label': 'hb-stat-label',
        'tag': 'hb-tag',

        // Classes da página de busca
        'search-container': 'hb-search-container',
        'search-form': 'hb-search-form',
        'search-input': 'hb-search-input',
        'search-button': 'hb-search-button',
        'search-filters': 'hb-search-filters',
        'filter-categories': 'hb-filter-categories',
        'filter-btn': 'hb-filter-btn',
        'filter-controls': 'hb-filter-controls',
        'filter-group': 'hb-filter-group',
        'filter-select': 'hb-filter-select',
        'search-results': 'hb-search-results',
        'results-count': 'hb-results-count',
        'results-grid': 'hb-results-grid',
        'result-item': 'hb-result-item',
        'video-result': 'hb-video-result',
        'creator-result': 'hb-creator-result',
        'category-result': 'hb-category-result',
        'result-info': 'hb-result-info',
        'result-title': 'hb-result-title',
        'result-meta': 'hb-result-meta',
        'pagination': 'hb-pagination',
        'pagination-btn': 'hb-pagination-btn',
        'pagination-numbers': 'hb-pagination-numbers',
        'empty-search': 'hb-empty-search',
        'no-results': 'hb-no-results',
        'search-loading': 'hb-search-loading',
        'trending-creators': 'hb-trending-creators',
        'creator-banner': 'hb-creator-banner',
        'creator-overlay': 'hb-creator-overlay',
        'creator-main-content': 'hb-creator-main-content',
        'creator-profile': 'hb-creator-profile',
        'profile-link': 'hb-profile-link',
        'creator-metrics': 'hb-creator-metrics',
        'metric': 'hb-metric',
        'creator-action-btn': 'hb-creator-action-btn',
        'premium-badges': 'hb-premium-badges',
        'exclusive-badge': 'hb-exclusive-badge',
        'vip-badge': 'hb-vip-badge',
        'skeleton': 'hb-skeleton',
        'skeleton-circle': 'hb-skeleton-circle',
        'skeleton-line': 'hb-skeleton-line',
        'skeleton-pill': 'hb-skeleton-pill',
        'skeleton-button': 'hb-skeleton-button',
        'sm': 'hb-sm'
    };
    
    // Adicionar classes de perfil 
    const profileClasses = {
        'profile-container': 'hb-profile-container',
        'profile-banner': 'hb-profile-banner',
        'banner-overlay': 'hb-banner-overlay',
        'profile-header': 'hb-profile-header',
        'profile-photo': 'hb-profile-photo',
        'profile-info': 'hb-profile-info',
        'profile-name': 'hb-profile-name',
        'profile-username': 'hb-profile-username',
        'online-badge': 'hb-online-badge',
        'offline-badge': 'hb-offline-badge',
        'social-badges': 'hb-social-badges',
        'profile-stats': 'hb-profile-stats',
        'profile-actions': 'hb-profile-actions',
        'subscribe-btn': 'hb-subscribe-btn',
        'profile-tabs': 'hb-profile-tabs',
        'tab-btn': 'hb-tab-btn',
        'continue-watching': 'hb-continue-watching'
    };

    // Adicionar ao mapeamento principal
    Object.assign(classMapping, profileClasses);
      // Elementos que NÃO devem ser migrados (classes gerais ou de outros componentes)
    const excludedClasses = [
        'tab-content', 'tab-contents', 'bio-content', 'modal-content', 
        'login-tab-content', 'active', 'disabled', 'show', 'carousel-container',
        'section-container', 'section-header', 'carousel-nav', 'nav-btn', 'prev', 'next'
    ];
    
    // Elementos com tags específicos que devem ser ignorados na migração
    const excludedTags = ['SCRIPT', 'STYLE', 'svg', 'path', 'rect', 'circle'];
    
    // Função para verificar se uma classe deve ser migrada
    function shouldMigrate(className) {
        if (!className) return false;
        if (excludedClasses.includes(className)) return false;
        if (className.startsWith('hb-')) return false; // Já migrado
        return classMapping.hasOwnProperty(className);
    }
    
    // Função para verificar se um elemento deve ser ignorado pela migração
    function shouldIgnoreElement(element) {
        if (!element || !element.tagName) return true;
        return excludedTags.includes(element.tagName);
    }
      // Função para migrar classes de um elemento
    function migrateElementClasses(element) {
        // Verificar se o elemento deve ser ignorado
        if (shouldIgnoreElement(element)) return;
        
        // Obter lista de classes atual
        const classList = element.classList;
        const classesToAdd = [];
        const classesToRemove = [];
        
        // Verificar cada classe para migração
        for (let i = 0; i < classList.length; i++) {
            const className = classList[i];
            if (shouldMigrate(className)) {
                classesToRemove.push(className);
                classesToAdd.push(classMapping[className]);
            }
        }
        
        // Aplicar alterações
        classesToRemove.forEach(cls => element.classList.remove(cls));
        classesToAdd.forEach(cls => element.classList.add(cls));
    }
    
    // Função para atualizar seletor em um elemento
    function updateSelector(element, attribute, oldSelector, newSelector) {
        if (!element || !element.hasAttribute(attribute)) return;
        
        const value = element.getAttribute(attribute);
        if (value.includes(oldSelector)) {
            const updatedValue = value.replace(
                new RegExp(oldSelector, 'g'), 
                newSelector
            );
            element.setAttribute(attribute, updatedValue);
        }
    }    // Função para migrar todos os elementos no documento que possuem classes a serem migradas
    function migrateAllElements() {
        // Verificar se a migração automática está desabilitada
        if (window.HB_AUTOMIGRATION_ENABLED === false) {
            console.log('Migração automática desabilitada pelo usuário');
            return;
        }
        
        // Verificar se a automigração está habilitada
        if (typeof window.HB_AUTOMIGRATION_ENABLED !== 'undefined' && window.HB_AUTOMIGRATION_ENABLED === false) {
            console.log('Migração automática desabilitada pelo console de administração');
            return;
        }
        
        // Contador para logging
        let migratedCount = 0;
        
        // Para cada classe antiga no mapeamento
        Object.keys(classMapping).forEach(oldClass => {
            // Selecionar todos os elementos com essa classe
            const elements = document.querySelectorAll(`.${oldClass}`);
            elements.forEach(element => {
                migrateElementClasses(element);
                migratedCount++;
            });
        });
        
        // Atualizar seletores em JavaScript inline
        const scriptElements = document.querySelectorAll('script:not([src])');
        scriptElements.forEach(script => {
            if (!script.textContent) return;
            
            let updatedContent = script.textContent;
            
            // Substituir seletores nas consultas de documento
            Object.keys(classMapping).forEach(oldClass => {
                const regex = new RegExp(`\\.${oldClass}\\b`, 'g');
                updatedContent = updatedContent.replace(regex, `.${classMapping[oldClass]}`);
            });
            
            if (updatedContent !== script.textContent) {
                script.textContent = updatedContent;
            }
        });
        
        // Atualizar seletores em atributos de eventos e data
        const elementsWithDataAttrs = document.querySelectorAll('[data-target], [data-selector]');
        elementsWithDataAttrs.forEach(element => {
            Object.keys(classMapping).forEach(oldClass => {
                updateSelector(element, 'data-target', `.${oldClass}`, `.${classMapping[oldClass]}`);
                updateSelector(element, 'data-selector', `.${oldClass}`, `.${classMapping[oldClass]}`);
            });
        });        // Log do resultado
        console.log(`Migração dinâmica concluída: ${migratedCount} elementos migrados`);
        
        // Atualizar o console de migração se estiver disponível
        if (window.updateMigrationStats) {
            window.updateMigrationStats();
        }
        
        // Notificar o console que a migração foi concluída
        if (typeof window.logMessage === 'function') {
            window.logMessage('Migração automática concluída');
        }
        
        return migratedCount;
    }
    
    // Expor a função de migração globalmente para o console de administração
    window.migrateAllElements = migrateAllElements;
      // Executar a migração
    setTimeout(function() {
        // Verificar se a migração automática está habilitada
        if (window.HB_AUTOMIGRATION_ENABLED !== false) {
            migrateAllElements();
        } else {
            console.log('Migração automática desabilitada no carregamento inicial');
        }
    }, 100); // Pequeno atraso para garantir que tudo carregou
      // Também executar a migração após Ajax ou carregamento dinâmico    // Observar mudanças no DOM
    const observer = new MutationObserver(function(mutations) {
        // Verificar se a migração automática está desabilitada
        if (window.HB_AUTOMIGRATION_ENABLED === false) {
            return;
        }
        
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                // Verificar se novos elementos foram adicionados
                const hasNewElements = Array.from(mutation.addedNodes).some(node => 
                    node.nodeType === 1 && !node.classList.contains('hb-')
                );
                
                if (hasNewElements) {
                    setTimeout(migrateAllElements, 50);
                }
            }
        });
    });
    
    // Iniciar observação das mudanças no DOM
    observer.observe(document.body, { childList: true, subtree: true });
    
    // Expor função adicional para estatísticas (para o console de migração)
    window.getMigrationStats = function() {
        return {
            oldCards: document.querySelectorAll('.content-card:not(.hb-content-card)').length,
            newCards: document.querySelectorAll('.hb-content-card').length,
            totalMigrated: document.querySelectorAll('[class*="hb-"]').length,
            totalElements: document.querySelectorAll('*').length
        };    };
    
    // Notificar o console que a migração foi concluída
    if (typeof window.logMessage === 'function') {
        window.logMessage('Migração automática concluída');
    }
});
