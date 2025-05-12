/**
 * Script para a página de busca do HotBoys
 * Compatível com o sistema de migração de classes com prefixo hb-
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se estamos na página de busca
    const searchContainer = document.querySelector('.hb-search-container');
    if (!searchContainer) return;
    
    // Elementos do DOM
    const searchForm = document.getElementById('hb-search-main-form');
    const searchInput = document.getElementById('hb-search-input');
    const filterButtons = document.querySelectorAll('.hb-filter-btn');
    const filterType = document.getElementById('hb-filter-type');
    const filterDuration = document.getElementById('hb-filter-duration');
    const filterSort = document.getElementById('hb-filter-sort');
    const resultItems = document.querySelectorAll('.hb-result-item');
    const resetSearchBtn = document.querySelector('.hb-reset-search-btn');
    const paginationLinks = document.querySelectorAll('.hb-pagination-numbers a');
    const prevBtn = document.querySelector('.hb-pagination-btn.hb-prev');
    const nextBtn = document.querySelector('.hb-pagination-btn.hb-next');
    const visibleCountElement = document.getElementById('hb-visible-count');
    const totalCountElement = document.getElementById('hb-total-count');
    const searchLoading = document.querySelector('.hb-search-loading');
    const noResults = document.querySelector('.hb-no-results');
    
    // Inicialização
    initSearch();
    
    /**
     * Inicializa as funcionalidades da página de busca
     */
    function initSearch() {
        // Exibir contadores
        updateCounters();
        
        // Simular conclusão do carregamento após delay (apenas para demonstração)
        if (searchLoading) {
            setTimeout(() => {
                searchLoading.style.display = 'none';
                
                // Verificar se há resultados
                if (resultItems.length === 0) {
                    if (noResults) noResults.style.display = 'block';
                } else {
                    updateCounters();
                }
            }, 1500);
        }
        
        // Adicionar eventos
        addEventListeners();
    }
    
    /**
     * Adiciona listeners de eventos aos elementos da interface
     */
    function addEventListeners() {
        // Eventos para os botões de filtro de categoria
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remover classe ativa de todos os botões
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Adicionar classe ativa ao botão clicado
                button.classList.add('active');
                
                // Aplicar filtro
                const filter = button.dataset.filter;
                applyFilters();
            });
        });
        
        // Eventos para os seletores de filtro
        if (filterType) filterType.addEventListener('change', applyFilters);
        if (filterDuration) filterDuration.addEventListener('change', applyFilters);
        if (filterSort) filterSort.addEventListener('change', applyFilters);
        
        // Evento para o botão de reset da busca
        if (resetSearchBtn) {
            resetSearchBtn.addEventListener('click', resetSearch);
        }
        
        // Eventos para paginação (simulação)
        paginationLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remover classe ativa de todos os links
                paginationLinks.forEach(l => l.classList.remove('active'));
                
                // Adicionar classe ativa ao link clicado
                link.classList.add('active');
                
                // Simulação de mudança de página com efeito
                const resultsContainer = document.getElementById('hb-search-results-container');
                
                if (resultsContainer) {
                    resultsContainer.style.opacity = '0.5';
                    
                    setTimeout(() => {
                        resultsContainer.style.opacity = '1';
                    }, 500);
                }
                
                // Atualizar estado dos botões de navegação
                updatePaginationButtons();
            });
        });
        
        // Eventos para botões de navegação
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                const activeLink = document.querySelector('.hb-pagination-numbers a.active');
                const prevLink = activeLink.previousElementSibling;
                
                if (prevLink && prevLink.tagName === 'A') {
                    prevLink.click();
                }
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                const activeLink = document.querySelector('.hb-pagination-numbers a.active');
                const nextLink = activeLink.nextElementSibling;
                
                if (nextLink && nextLink.tagName === 'A') {
                    nextLink.click();
                }
            });
        }
        
        // Inicializar estado dos botões de navegação
        updatePaginationButtons();
    }
    
    /**
     * Aplica os filtros selecionados aos resultados
     */
    function applyFilters() {
        // Obter valores dos filtros
        const typeFilter = filterType ? filterType.value : 'all';
        const durationFilter = filterDuration ? filterDuration.value : 'all';
        const activeTypeBtn = document.querySelector('.hb-filter-btn.active');
        const categoryFilter = activeTypeBtn ? activeTypeBtn.dataset.filter : 'all';
        
        let visibleCount = 0;
        
        // Aplicar filtros a cada item de resultado
        resultItems.forEach(item => {
            const typeMatch = typeFilter === 'all' || item.dataset.category === typeFilter;
            const durationMatch = durationFilter === 'all' || item.dataset.duration === durationFilter;
            const categoryMatch = categoryFilter === 'all' || item.dataset.type === categoryFilter;
            
            if (typeMatch && durationMatch && categoryMatch) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Atualizar contadores
        updateCounters(visibleCount);
        
        // Verificar se não há resultados após os filtros
        if (visibleCount === 0 && noResults) {
            noResults.style.display = 'block';
        } else if (noResults) {
            noResults.style.display = 'none';
        }
        
        // Aplicar ordenação
        if (filterSort) {
            applySorting(filterSort.value);
        }
    }
    
    /**
     * Aplica a ordenação aos resultados
     */
    function applySorting(sortType) {
        const resultsContainer = document.getElementById('hb-search-results-container');
        const visibleItems = Array.from(resultItems).filter(item => item.style.display !== 'none');
        
        // Ordenar itens (simulação para demonstração)
        switch (sortType) {
            case 'newest':
                // Aqui seria implementada uma lógica real de ordenação por data
                // Para demonstração, apenas embaralhamos os resultados
                visibleItems.sort(() => 0.5 - Math.random());
                break;
                
            case 'oldest':
                // Inverter a ordem atual (simulação)
                visibleItems.reverse();
                break;
                
            case 'popularity':
                // Ordenar por visualizações (simulação)
                visibleItems.sort(() => 0.5 - Math.random());
                break;
                
            case 'relevance':
            default:
                // Não fazer nada, manter ordem padrão
                break;
        }
        
        // Reordenar elementos no DOM (simulação)
        visibleItems.forEach(item => {
            resultsContainer.appendChild(item);
        });
    }
    
    /**
     * Atualiza os contadores de resultados
     */
    function updateCounters(visibleCount = null) {
        if (!visibleCountElement || !totalCountElement) return;
        
        const total = resultItems.length;
        
        // Se não for fornecido, contar itens visíveis
        if (visibleCount === null) {
            visibleCount = Array.from(resultItems).filter(item => item.style.display !== 'none').length;
        }
        
        visibleCountElement.textContent = visibleCount;
        totalCountElement.textContent = total;
    }
    
    /**
     * Atualiza o estado dos botões de paginação
     */
    function updatePaginationButtons() {
        if (!prevBtn || !nextBtn) return;
        
        const activeLink = document.querySelector('.hb-pagination-numbers a.active');
        if (!activeLink) return;
        
        // Verificar se há links anteriores ou próximos
        const hasPrev = activeLink.previousElementSibling && activeLink.previousElementSibling.tagName === 'A';
        const hasNext = activeLink.nextElementSibling && 
                        (activeLink.nextElementSibling.tagName === 'A' || 
                         (activeLink.nextElementSibling.tagName === 'SPAN' && activeLink.nextElementSibling.nextElementSibling));
        
        prevBtn.disabled = !hasPrev;
        nextBtn.disabled = !hasNext;
    }
    
    /**
     * Reseta a busca e os filtros
     */
    function resetSearch() {
        // Limpar campo de busca
        if (searchInput) searchInput.value = '';
        
        // Resetar filtros
        if (filterType) filterType.value = 'all';
        if (filterDuration) filterDuration.value = 'all';
        if (filterSort) filterSort.value = 'relevance';
        
        // Resetar botão de categoria
        filterButtons.forEach(btn => btn.classList.remove('active'));
        const allBtn = document.querySelector('.hb-filter-btn[data-filter="all"]');
        if (allBtn) allBtn.classList.add('active');
        
        // Mostrar todos os resultados
        resultItems.forEach(item => {
            item.style.display = 'block';
        });
        
        // Esconder mensagem de sem resultados
        if (noResults) noResults.style.display = 'none';
        
        // Atualizar contadores
        updateCounters();
        
        // Voltar para a primeira página
        const firstPageLink = document.querySelector('.hb-pagination-numbers a:first-child');
        if (firstPageLink) {
            paginationLinks.forEach(link => link.classList.remove('active'));
            firstPageLink.classList.add('active');
            updatePaginationButtons();
        }
        
        // Redirecionar para página de busca limpa
        if (searchForm) {
            // Remover os parâmetros de URL atuais
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
});

// Compatibilidade com sistema legado se necessário
if (typeof migrateAllElements === 'function') {
    document.addEventListener('DOMContentLoaded', function() {
        // Adicionar mapeamento de classes para busca
        const classMap = {
            'search-container': 'hb-search-container',
            'search-form': 'hb-search-form',
            'search-input': 'hb-search-input',
            'search-button': 'hb-search-button',
            'filter-btn': 'hb-filter-btn',
            'filter-select': 'hb-filter-select',
            'results-grid': 'hb-results-grid',
            'result-item': 'hb-result-item',
            'pagination-btn': 'hb-pagination-btn',
            'content-card': 'hb-result-item',
            'thumbnail': 'hb-thumbnail',
            'duration': 'hb-duration',
            'content-badge': 'hb-content-badge'
        };
        
        // Migrar elementos da página de busca
        if (document.querySelector('.search-container')) {
            migrateAllElements(classMap);
        }
    });
}
