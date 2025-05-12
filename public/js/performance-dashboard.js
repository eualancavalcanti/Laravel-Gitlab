/**
 * Performance Dashboard para Migração HotBoys
 * Exibe visualização gráfica dos dados de performance durante a migração
 */
(function() {
    // Verificar se estamos em modo de visualização de performance
    if (window.location.search.includes('perfview=true')) {
        document.addEventListener('DOMContentLoaded', function() {
            // Injetar o painel no corpo do documento
            injectPerformanceDashboard();
            
            // Carregar dados de performance do localStorage
            let perfHistory = localStorage.getItem('hb-performance-history');
            perfHistory = perfHistory ? JSON.parse(perfHistory) : [];
            
            if (perfHistory.length === 0) {
                showNoDataMessage();
                return;
            }
            
            // Processar dados para visualização
            processPerformanceData(perfHistory);
        });
    }
    
    // Injeta o painel no corpo da página
    function injectPerformanceDashboard() {
        // Salvar o conteúdo original da página
        const originalContent = document.body.innerHTML;
        
        // Substituir com o painel de performance
        document.body.innerHTML = `
            <div id="hb-performance-dashboard">
                <header class="hb-dash-header">
                    <h1>Painel de Performance - Migração HotBoys</h1>
                    <div class="hb-dash-controls">
                        <button id="hb-return-btn" class="hb-dash-btn">Voltar ao Site</button>
                        <button id="hb-clear-data-btn" class="hb-dash-btn hb-dash-btn-warning">Limpar Dados</button>
                    </div>
                </header>
                
                <div class="hb-dash-summary">
                    <div class="hb-dash-summary-card">
                        <h3>Total de Medições</h3>
                        <div id="hb-total-measurements" class="hb-dash-big-number">0</div>
                    </div>
                    <div class="hb-dash-summary-card">
                        <h3>Páginas Monitoradas</h3>
                        <div id="hb-monitored-pages" class="hb-dash-big-number">0</div>
                    </div>
                    <div class="hb-dash-summary-card">
                        <h3>% Elementos Migrados</h3>
                        <div id="hb-migration-progress" class="hb-dash-big-number">0%</div>
                    </div>
                </div>
                
                <div class="hb-dash-content">
                    <div class="hb-dash-chart-container">
                        <h2>Comparativo de Performance</h2>
                        <div class="hb-dash-tabs">
                            <button class="hb-dash-tab active" data-metric="pageLoad">Carregamento Total</button>
                            <button class="hb-dash-tab" data-metric="firstContentfulPaint">First Contentful Paint</button>
                            <button class="hb-dash-tab" data-metric="domComplete">DOM Complete</button>
                            <button class="hb-dash-tab" data-metric="totalScriptTime">Tempo de Scripts</button>
                        </div>
                        <div id="hb-main-chart" class="hb-dash-chart"></div>
                    </div>
                    
                    <div class="hb-dash-metrics-table">
                        <h2>Métricas por Página</h2>
                        <div id="hb-page-selector" class="hb-dash-dropdown">
                            <select id="hb-page-select">
                                <option value="all">Todas as Páginas</option>
                            </select>
                        </div>
                        <div id="hb-metrics-table-container">
                            <table id="hb-metrics-table" class="hb-dash-table">
                                <thead>
                                    <tr>
                                        <th>Métrica</th>
                                        <th>Antes da Migração</th>
                                        <th>Após Migração</th>
                                        <th>Diferença</th>
                                    </tr>
                                </thead>
                                <tbody id="hb-metrics-tbody">
                                    <!-- Conteúdo da tabela será inserido dinamicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div id="hb-no-data-message" style="display:none;">
                    <div class="hb-dash-no-data">
                        <h2>Sem dados de performance disponíveis</h2>
                        <p>Navegue pelo site com a ferramenta de migração ativa para coletar dados de performance.</p>
                        <button id="hb-return-from-empty" class="hb-dash-btn">Voltar ao Site</button>
                    </div>
                </div>
                
                <footer class="hb-dash-footer">
                    <p>Dashboard de Monitoramento de Performance para Migração HotBoys v1.0</p>
                </footer>
            </div>
            
            <style>
                #hb-performance-dashboard {
                    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                    background-color: #f8f9fa;
                    color: #212529;
                    padding: 0;
                    margin: 0;
                    min-height: 100vh;
                }
                
                .hb-dash-header {
                    background-color: #FF3333;
                    color: white;
                    padding: 1rem 2rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                
                .hb-dash-header h1 {
                    margin: 0;
                    font-size: 1.5rem;
                    font-weight: 600;
                }
                
                .hb-dash-controls {
                    display: flex;
                    gap: 0.5rem;
                }
                
                .hb-dash-btn {
                    background-color: white;
                    color: #FF3333;
                    border: none;
                    border-radius: 4px;
                    padding: 0.5rem 1rem;
                    font-weight: 500;
                    cursor: pointer;
                    transition: all 0.2s;
                }
                
                .hb-dash-btn:hover {
                    background-color: #f8f9fa;
                    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                }
                
                .hb-dash-btn-warning {
                    background-color: #FFC107;
                    color: #212529;
                }
                
                .hb-dash-btn-warning:hover {
                    background-color: #ffca2c;
                }
                
                .hb-dash-summary {
                    display: flex;
                    justify-content: space-between;
                    padding: 1rem 2rem;
                    background-color: white;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                    margin-bottom: 1.5rem;
                }
                
                .hb-dash-summary-card {
                    padding: 1rem;
                    text-align: center;
                    flex: 1;
                }
                
                .hb-dash-big-number {
                    font-size: 2.5rem;
                    font-weight: 600;
                    color: #FF3333;
                    margin-top: 0.5rem;
                }
                
                .hb-dash-content {
                    padding: 0 2rem 2rem;
                    display: grid;
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }
                
                @media (min-width: 992px) {
                    .hb-dash-content {
                        grid-template-columns: 1.5fr 1fr;
                    }
                }
                
                .hb-dash-chart-container, .hb-dash-metrics-table {
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                    padding: 1.5rem;
                }
                
                .hb-dash-chart-container h2, .hb-dash-metrics-table h2 {
                    margin-top: 0;
                    font-size: 1.25rem;
                    margin-bottom: 1rem;
                    border-bottom: 1px solid #eee;
                    padding-bottom: 0.5rem;
                }
                
                .hb-dash-tabs {
                    display: flex;
                    gap: 0.5rem;
                    margin-bottom: 1rem;
                    flex-wrap: wrap;
                }
                
                .hb-dash-tab {
                    background: none;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                    padding: 0.5rem 1rem;
                    cursor: pointer;
                    font-size: 0.875rem;
                    transition: all 0.2s;
                }
                
                .hb-dash-tab:hover {
                    background-color: #f8f9fa;
                }
                
                .hb-dash-tab.active {
                    background-color: #FF3333;
                    color: white;
                    border-color: #FF3333;
                }
                
                .hb-dash-chart {
                    height: 300px;
                    width: 100%;
                    background-color: #f8f9fa;
                    border-radius: 4px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                
                .hb-dash-dropdown {
                    margin-bottom: 1rem;
                }
                
                .hb-dash-dropdown select {
                    width: 100%;
                    padding: 0.5rem;
                    border: 1px solid #dee2e6;
                    border-radius: 4px;
                    font-size: 0.875rem;
                }
                
                .hb-dash-table {
                    width: 100%;
                    border-collapse: collapse;
                }
                
                .hb-dash-table th, .hb-dash-table td {
                    padding: 0.75rem;
                    text-align: left;
                    border-bottom: 1px solid #eee;
                }
                
                .hb-dash-table th {
                    font-weight: 600;
                    background-color: #f8f9fa;
                }
                
                .hb-dash-no-data {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    padding: 4rem 2rem;
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                }
                
                .hb-dash-no-data h2 {
                    margin-top: 0;
                    margin-bottom: 1rem;
                }
                
                .hb-dash-no-data button {
                    margin-top: 1rem;
                }
                
                .hb-dash-footer {
                    text-align: center;
                    padding: 1rem;
                    color: #6c757d;
                    font-size: 0.875rem;
                    border-top: 1px solid #eee;
                    margin-top: 2rem;
                }
                
                .hb-positive-diff {
                    color: #28a745;
                }
                
                .hb-negative-diff {
                    color: #dc3545;
                }
            </style>
        `;
        
        // Adicionar eventos
        document.getElementById('hb-return-btn').addEventListener('click', function() {
            // Restaurar conteúdo original e remover query string
            document.body.innerHTML = originalContent;
            window.history.pushState({}, '', window.location.pathname);
            // Recarregar scripts (necessário após substituir innerHTML)
            reloadScripts();
        });
        
        document.getElementById('hb-clear-data-btn').addEventListener('click', function() {
            if (confirm('Tem certeza que deseja limpar todos os dados de performance? Esta ação não pode ser desfeita.')) {
                localStorage.removeItem('hb-performance-history');
                showNoDataMessage();
            }
        });
        
        if (document.getElementById('hb-return-from-empty')) {
            document.getElementById('hb-return-from-empty').addEventListener('click', function() {
                document.body.innerHTML = originalContent;
                window.history.pushState({}, '', window.location.pathname);
                reloadScripts();
            });
        }
    }
    
    // Mostra mensagem quando não há dados disponíveis
    function showNoDataMessage() {
        document.querySelector('.hb-dash-summary').style.display = 'none';
        document.querySelector('.hb-dash-content').style.display = 'none';
        document.getElementById('hb-no-data-message').style.display = 'block';
    }
    
    // Processa e visualiza os dados de performance
    function processPerformanceData(perfHistory) {
        // Obter URLs únicas para selecionar páginas
        const uniqueUrls = [...new Set(perfHistory.map(entry => entry.url))];
        const pageSelect = document.getElementById('hb-page-select');
        
        uniqueUrls.forEach(url => {
            const option = document.createElement('option');
            option.value = url;
            option.textContent = url || 'Home';
            pageSelect.appendChild(option);
        });
        
        // Atualizar contagens de resumo
        document.getElementById('hb-total-measurements').textContent = perfHistory.length;
        document.getElementById('hb-monitored-pages').textContent = uniqueUrls.length;
        
        // Calcular progresso da migração
        const migratedEntries = perfHistory.filter(entry => entry.hasMigratedElements);
        const migrationProgress = Math.round((migratedEntries.length / perfHistory.length) * 100);
        document.getElementById('hb-migration-progress').textContent = migrationProgress + '%';
        
        // Dividir dados em antes e depois da migração
        const beforeMigration = perfHistory.filter(entry => !entry.hasMigratedElements);
        const afterMigration = perfHistory.filter(entry => entry.hasMigratedElements);
        
        // Exibir tabela de métricas para todas as páginas inicialmente
        updateMetricsTable('all', beforeMigration, afterMigration);
        
        // Exibir gráfico inicial com métrica de tempo de carregamento
        displayChart('pageLoad', beforeMigration, afterMigration);
        
        // Configurar listeners para tabs de métricas
        document.querySelectorAll('.hb-dash-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelector('.hb-dash-tab.active').classList.remove('active');
                this.classList.add('active');
                
                const metric = this.getAttribute('data-metric');
                displayChart(metric, beforeMigration, afterMigration);
            });
        });
        
        // Configurar listener para seletor de página
        pageSelect.addEventListener('change', function() {
            const selectedUrl = this.value;
            updateMetricsTable(selectedUrl, beforeMigration, afterMigration);
        });
    }
    
    // Atualiza a tabela de métricas com base na página selecionada
    function updateMetricsTable(selectedUrl, beforeMigration, afterMigration) {
        const metricsBody = document.getElementById('hb-metrics-tbody');
        metricsBody.innerHTML = '';
        
        // Filtrar entradas para a URL selecionada ou usar todas
        const filteredBefore = selectedUrl === 'all' ? 
            beforeMigration : 
            beforeMigration.filter(entry => entry.url === selectedUrl);
            
        const filteredAfter = selectedUrl === 'all' ? 
            afterMigration : 
            afterMigration.filter(entry => entry.url === selectedUrl);
        
        // Se não houver dados suficientes
        if (filteredBefore.length === 0 || filteredAfter.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td colspan="4" style="text-align: center;">
                    Dados insuficientes para comparação. Precisa de entradas antes e depois da migração.
                </td>
            `;
            metricsBody.appendChild(row);
            return;
        }
        
        // Calcular médias para cada métrica
        const metricNames = {
            pageLoad: 'Tempo de Carregamento Total',
            firstPaint: 'Primeira Pintura',
            firstContentfulPaint: 'Primeiro Conteúdo Visível',
            domComplete: 'DOM Completo',
            resourcesLoad: 'Carregamento de Recursos',
            carouselInit: 'Inicialização de Carrosséis',
            totalScriptTime: 'Tempo Total de Scripts'
        };
        
        Object.keys(metricNames).forEach(metric => {
            const beforeAvg = filteredBefore.reduce((sum, entry) => sum + (entry.metrics[metric] || 0), 0) / filteredBefore.length;
            const afterAvg = filteredAfter.reduce((sum, entry) => sum + (entry.metrics[metric] || 0), 0) / filteredAfter.length;
            
            const diff = afterAvg - beforeAvg;
            const percentDiff = (diff / beforeAvg) * 100;
            
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${metricNames[metric]}</td>
                <td>${Math.round(beforeAvg)}ms</td>
                <td>${Math.round(afterAvg)}ms</td>
                <td class="${diff < 0 ? 'hb-positive-diff' : diff > 0 ? 'hb-negative-diff' : ''}">
                    ${diff < 0 ? '↓' : diff > 0 ? '↑' : ''}
                    ${Math.abs(Math.round(diff))}ms
                    (${Math.abs(Math.round(percentDiff))}%)
                </td>
            `;
            
            metricsBody.appendChild(row);
        });
    }
    
    // Exibe um gráfico simplificado para a métrica selecionada
    function displayChart(metricName, beforeMigration, afterMigration) {
        const chartContainer = document.getElementById('hb-main-chart');
        chartContainer.innerHTML = `
            <div style="text-align: center; padding: 1rem;">
                <p>Gráfico de barras para <strong>${metricName}</strong> seria exibido aqui.</p>
                <p>Antes da Migração (Média): <strong>${calculateAvgMetric(beforeMigration, metricName)}ms</strong></p>
                <p>Após Migração (Média): <strong>${calculateAvgMetric(afterMigration, metricName)}ms</strong></p>
                <p><small>Implementação completa requer biblioteca de gráficos.</small></p>
            </div>
        `;
    }
    
    // Calcula a média de uma métrica específica
    function calculateAvgMetric(entries, metric) {
        if (!entries || entries.length === 0) return 'N/A';
        
        const sum = entries.reduce((total, entry) => {
            return total + (entry.metrics[metric] || 0);
        }, 0);
        
        return Math.round(sum / entries.length);
    }
    
    // Recarrega os scripts após restaurar o conteúdo original
    function reloadScripts() {
        const scripts = document.getElementsByTagName('script');
        for (let i = 0; i < scripts.length; i++) {
            const src = scripts[i].src;
            if (src) {
                const newScript = document.createElement('script');
                newScript.src = src;
                document.body.appendChild(newScript);
            }
        }
    }
})();
