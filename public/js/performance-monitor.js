/**
 * Monitor de Performance para Migração HotBoys
 * Monitora e compara a performance antes e depois da migração
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se estamos em modo de desenvolvimento
    const isDev = document.querySelector('meta[name="environment"][content="development"]') !== null;
    if (!isDev) return;
    
    // Métricas de performance a serem monitoradas
    const metrics = {
        pageLoad: 0,
        firstPaint: 0,
        firstContentfulPaint: 0,
        domComplete: 0,
        resourcesLoad: 0,
        carouselInit: 0,
        totalScriptTime: 0
    };
    
    // Inicia a coleta de métricas quando a página carregar
    window.addEventListener('load', function() {
        // Coletar métricas de tempo de carregamento da página
        const perfData = window.performance.timing;
        metrics.pageLoad = perfData.loadEventEnd - perfData.navigationStart;
        metrics.domComplete = perfData.domComplete - perfData.domLoading;
        metrics.resourcesLoad = perfData.loadEventEnd - perfData.responseEnd;
        
        // Coletar métricas de pintura
        const paintMetrics = performance.getEntriesByType('paint');
        paintMetrics.forEach(paintMetric => {
            if (paintMetric.name === 'first-paint') {
                metrics.firstPaint = Math.round(paintMetric.startTime);
            }
            if (paintMetric.name === 'first-contentful-paint') {
                metrics.firstContentfulPaint = Math.round(paintMetric.startTime);
            }
        });
        
        // Calcular tempo total gasto em scripts
        const scriptTimes = performance.getEntriesByType('resource')
            .filter(resource => resource.initiatorType === 'script')
            .reduce((total, script) => total + script.duration, 0);
        metrics.totalScriptTime = Math.round(scriptTimes);
        
        // Medir tempo de inicialização dos carrosséis (aproximado)
        const carouselStart = performance.now();
        setTimeout(() => {
            const carouselElements = document.querySelectorAll('.hb-content-grid, .hb-actors-carousel');
            if (carouselElements.length > 0) {
                metrics.carouselInit = Math.round(performance.now() - carouselStart);
                
                // Exibir resultados após coletar todas as métricas
                displayPerformanceResults();
            }
        }, 500);
    });
    
    // Exibe os resultados de performance
    function displayPerformanceResults() {
        // Verificar se já existe histórico salvo
        let perfHistory = localStorage.getItem('hb-performance-history');
        perfHistory = perfHistory ? JSON.parse(perfHistory) : [];
        
        // Adicionar métricas atuais ao histórico
        const currentData = {
            timestamp: new Date().toISOString(),
            url: window.location.pathname,
            metrics: metrics,
            hasMigratedElements: document.querySelectorAll('[class*="hb-"]').length > 0
        };
          perfHistory.push(currentData);
        
        // Limitar histórico a 100 entradas para ter dados mais robustos para análise
        if (perfHistory.length > 100) {
            perfHistory.shift();
        }
        
        // Salvar histórico atualizado
        localStorage.setItem('hb-performance-history', JSON.stringify(perfHistory));
        
        // Verificar se o histórico atingiu um tamanho razoável para análise
        if (perfHistory.length >= 5 && perfHistory.filter(e => e.hasMigratedElements).length > 0) {
            // Adicionar notificação para analisar performance
            if (!document.getElementById('hb-performance-viewer-link')) {
                addPerformanceViewerLink();
            }
        }
        
        // Comparar com média anterior se houver dados suficientes
        if (perfHistory.length > 1) {
            const previousEntries = perfHistory.slice(0, -1).filter(entry => 
                entry.url === currentData.url
            );
            
            if (previousEntries.length > 0) {
                comparePerformance(currentData, previousEntries);
            }
        }
        
        // Mostrar dados no console para desenvolvedores
        console.groupCollapsed('📊 Métricas de Performance HotBoys');
        console.log('⏱️ Tempo de carregamento total:', metrics.pageLoad + 'ms');
        console.log('🎨 Primeira pintura:', metrics.firstPaint + 'ms');
        console.log('🖼️ Primeira pintura com conteúdo:', metrics.firstContentfulPaint + 'ms');
        console.log('📄 Tempo de carregamento do DOM:', metrics.domComplete + 'ms');
        console.log('📦 Tempo de carregamento de recursos:', metrics.resourcesLoad + 'ms');
        console.log('🎠 Tempo de inicialização dos carrosséis:', metrics.carouselInit + 'ms');
        console.log('📜 Tempo total gasto em scripts:', metrics.totalScriptTime + 'ms');
        console.groupEnd();
    }
    
    // Compara performance atual com dados anteriores
    function comparePerformance(current, previousEntries) {
        // Calcular médias anteriores
        const avgPrevious = {};
        Object.keys(current.metrics).forEach(metric => {
            avgPrevious[metric] = Math.round(
                previousEntries.reduce((sum, entry) => sum + (entry.metrics[metric] || 0), 0) / previousEntries.length
            );
        });
        
        // Calcular diferenças percentuais
        const differences = {};
        let hasSignificantRegression = false;
        
        Object.keys(current.metrics).forEach(metric => {
            if (avgPrevious[metric] > 0) {
                const diff = current.metrics[metric] - avgPrevious[metric];
                const percentDiff = Math.round((diff / avgPrevious[metric]) * 100);
                
                differences[metric] = {
                    absolute: diff,
                    percent: percentDiff
                };
                
                // Verificar se há regressão significativa (mais de 20% pior)
                if (percentDiff > 20) {
                    hasSignificantRegression = true;
                }
            }
        });
        
        // Mostrar comparação no console
        console.groupCollapsed('🔄 Comparação de Performance com Carregamentos Anteriores');
        
        Object.keys(differences).forEach(metric => {
            const diff = differences[metric];
            const symbol = diff.percent > 0 ? '⚠️ +' : (diff.percent < 0 ? '✅ ' : '');
            console.log(
                `${metric}: ${current.metrics[metric]}ms (${symbol}${diff.percent}% | ${diff.absolute}ms)`
            );
        });
        
        console.groupEnd();
        
        // Alertar sobre regressões significativas
        if (hasSignificantRegression) {
            console.warn('⚠️ Detectada regressão significativa de performance. Verifique as métricas acima.');
            
            // Gerar alerta visual apenas para desenvolvedores
            const performanceAlert = document.createElement('div');
            performanceAlert.style.position = 'fixed';
            performanceAlert.style.bottom = '10px';
            performanceAlert.style.left = '50%';
            performanceAlert.style.transform = 'translateX(-50%)';
            performanceAlert.style.backgroundColor = '#FFF3CD';
            performanceAlert.style.color = '#856404';
            performanceAlert.style.padding = '10px 15px';
            performanceAlert.style.borderRadius = '4px';
            performanceAlert.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
            performanceAlert.style.zIndex = '9999';
            performanceAlert.style.fontSize = '14px';
            performanceAlert.style.fontFamily = 'sans-serif';
            performanceAlert.innerHTML = `
                <strong>⚠️ Alerta de Performance:</strong> Detectada regressão significativa.<br>
                <small>Veja o console para mais detalhes (F12).</small>
                <span style="position:absolute; top:5px; right:10px; cursor:pointer;" onclick="this.parentNode.remove()">×</span>
            `;
            
            document.body.appendChild(performanceAlert);
            
            // Remover alerta após 10 segundos            setTimeout(() => {
                if (performanceAlert.parentNode) {
                    performanceAlert.remove();
                }
            }, 10000);
        }
    }
    
    // Adiciona link para visualizador de performance
    function addPerformanceViewerLink() {
        const link = document.createElement('div');
        link.id = 'hb-performance-viewer-link';
        link.style.position = 'fixed';
        link.style.top = '10px';
        link.style.right = '10px';
        link.style.backgroundColor = '#FF3333';
        link.style.color = 'white';
        link.style.padding = '8px 12px';
        link.style.borderRadius = '4px';
        link.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        link.style.zIndex = '9999';
        link.style.fontSize = '14px';
        link.style.fontFamily = 'sans-serif';
        link.style.cursor = 'pointer';
        link.innerHTML = '📊 Ver Análise de Performance';
        
        link.addEventListener('click', function() {
            window.location.href = window.location.pathname + '?perfview=true';
        });
        
        document.body.appendChild(link);
    }
});
