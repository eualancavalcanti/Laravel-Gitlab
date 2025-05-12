/**
 * Visualizador de Performance para Migração HotBoys
 * Interface para visualizar e analisar dados de performance coletados
 */
document.addEventListener('DOMContentLoaded', function() {
    // Verificar se estamos em modo de visualização de performance
    const urlParams = new URLSearchParams(window.location.search);
    const showPerfViewer = urlParams.get('perfview') === 'true';
    
    if (!showPerfViewer) return;
    
    // Carregar histórico de performance
    let perfHistory = localStorage.getItem('hb-performance-history');
    perfHistory = perfHistory ? JSON.parse(perfHistory) : [];
    
    if (perfHistory.length === 0) {
        alert('Não há dados de performance para exibir. Navegue pelo site para coletar dados primeiro.');
        return;
    }
    
    // Criar e mostrar a interface de visualização
    createPerfViewer(perfHistory);
    
    // Função para criar a interface de visualização
    function createPerfViewer(data) {
        // Esconder conteúdo da página
        document.body.innerHTML = '';
        document.body.style.background = '#f8f9fa';
        document.body.style.padding = '20px';
        document.body.style.fontFamily = 'Arial, sans-serif';
        
        // Criar container
        const container = document.createElement('div');
        container.style.maxWidth = '1200px';
        container.style.margin = '0 auto';
        container.style.background = '#fff';
        container.style.padding = '20px';
        container.style.borderRadius = '8px';
        container.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
        
        // Título
        const title = document.createElement('h1');
        title.textContent = 'Análise de Performance - HotBoys';
        title.style.color = '#FF3333';
        title.style.marginBottom = '20px';
        title.style.display = 'flex';
        title.style.justifyContent = 'space-between';
        title.style.alignItems = 'center';
        
        // Botão de voltar
        const backBtn = document.createElement('button');
        backBtn.textContent = 'Voltar ao Site';
        backBtn.style.padding = '8px 16px';
        backBtn.style.background = '#FF3333';
        backBtn.style.color = 'white';
        backBtn.style.border = 'none';
        backBtn.style.borderRadius = '4px';
        backBtn.style.cursor = 'pointer';
        backBtn.style.fontSize = '14px';
        backBtn.onclick = () => {
            window.location.href = window.location.pathname;
        };
        
        title.appendChild(backBtn);
        container.appendChild(title);
        
        // Criar abas para diferentes visualizações
        const tabs = document.createElement('div');
        tabs.style.display = 'flex';
        tabs.style.borderBottom = '1px solid #ddd';
        tabs.style.marginBottom = '20px';
        
        const tabData = [
            { id: 'summary', label: 'Resumo' },
            { id: 'history', label: 'Histórico' },
            { id: 'comparison', label: 'Comparação' },
            { id: 'bypage', label: 'Por Página' }
        ];
        
        // Conteúdo de abas
        const tabContents = document.createElement('div');
        tabContents.style.padding = '15px 0';
        
        // Criar cada aba
        tabData.forEach(tab => {
            const tabElement = document.createElement('div');
            tabElement.textContent = tab.label;
            tabElement.dataset.tab = tab.id;
            tabElement.style.padding = '10px 20px';
            tabElement.style.cursor = 'pointer';
            tabElement.style.borderBottom = '2px solid transparent';
            
            tabElement.addEventListener('click', () => {
                // Remover classe ativa de todas as abas
                tabs.querySelectorAll('div').forEach(t => {
                    t.style.borderBottom = '2px solid transparent';
                    t.style.fontWeight = 'normal';
                });
                
                // Adicionar classe ativa à aba clicada
                tabElement.style.borderBottom = '2px solid #FF3333';
                tabElement.style.fontWeight = 'bold';
                
                // Mostrar conteúdo da aba
                showTabContent(tab.id, data);
            });
            
            tabs.appendChild(tabElement);
        });
        
        container.appendChild(tabs);
        container.appendChild(tabContents);
        
        // Adicionar ao body
        document.body.appendChild(container);
        
        // Mostrar a primeira aba por padrão
        tabs.querySelector('div').click();
        
        // Função para mostrar conteúdo da aba
        function showTabContent(tabId, perfData) {
            // Limpar conteúdo existente
            tabContents.innerHTML = '';
            
            switch(tabId) {
                case 'summary':
                    showSummaryTab(perfData);
                    break;
                case 'history':
                    showHistoryTab(perfData);
                    break;
                case 'comparison':
                    showComparisonTab(perfData);
                    break;
                case 'bypage':
                    showByPageTab(perfData);
                    break;
            }
        }
        
        // Aba de Resumo
        function showSummaryTab(perfData) {
            // Calcular estatísticas gerais
            const latestEntries = {};
            const urlsWithMigration = new Set();
            const urlsTotal = new Set();
            
            // Coletar dados mais recentes para cada URL
            perfData.forEach(entry => {
                urlsTotal.add(entry.url);
                
                if (!latestEntries[entry.url] || new Date(entry.timestamp) > new Date(latestEntries[entry.url].timestamp)) {
                    latestEntries[entry.url] = entry;
                }
                
                if (entry.hasMigratedElements) {
                    urlsWithMigration.add(entry.url);
                }
            });
            
            // Calcular médias globais
            const allMetricsSum = {
                pageLoad: 0,
                firstPaint: 0,
                firstContentfulPaint: 0,
                domComplete: 0,
                resourcesLoad: 0,
                carouselInit: 0,
                totalScriptTime: 0,
                count: 0
            };
            
            perfData.forEach(entry => {
                Object.keys(entry.metrics).forEach(metric => {
                    if (typeof entry.metrics[metric] === 'number') {
                        allMetricsSum[metric] += entry.metrics[metric];
                    }
                });
                allMetricsSum.count++;
            });
            
            const avgMetrics = {};
            Object.keys(allMetricsSum).forEach(metric => {
                if (metric !== 'count' && allMetricsSum.count > 0) {
                    avgMetrics[metric] = Math.round(allMetricsSum[metric] / allMetricsSum.count);
                }
            });
            
            // Criar painel de resumo
            const summaryPanel = document.createElement('div');
            summaryPanel.innerHTML = `
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #555;">Páginas Monitoradas</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #FF3333;">${urlsTotal.size}</div>
                    </div>
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #555;">Páginas com Migração</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #FF3333;">${urlsWithMigration.size}</div>
                    </div>
                    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
                        <h3 style="margin: 0 0 10px 0; font-size: 16px; color: #555;">Medições Realizadas</h3>
                        <div style="font-size: 32px; font-weight: bold; color: #FF3333;">${allMetricsSum.count}</div>
                    </div>
                </div>
                
                <h2 style="font-size: 18px; margin: 20px 0 15px 0;">Médias Globais de Performance</h2>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px;">
                    <thead>
                        <tr style="background: #f1f1f1;">
                            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Métrica</th>
                            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Valor Médio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Tempo de carregamento total</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.pageLoad}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Primeira pintura</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.firstPaint}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Primeira pintura com conteúdo</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.firstContentfulPaint}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Tempo de carregamento do DOM</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.domComplete}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Tempo de carregamento de recursos</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.resourcesLoad}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Tempo de inicialização dos carrosséis</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.carouselInit}ms</td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">Tempo total gasto em scripts</td>
                            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold;">${avgMetrics.totalScriptTime}ms</td>
                        </tr>
                    </tbody>
                </table>
                
                <h2 style="font-size: 18px; margin: 20px 0 15px 0;">Recomendações</h2>
                <ul style="padding-left: 20px; line-height: 1.6;">
                    <li><strong>Continue monitorando:</strong> Visite as páginas restantes para coletar mais dados de performance.</li>
                    <li><strong>Tempo razoável:</strong> Mantenha o tempo de carregamento total abaixo de 3000ms para uma boa experiência.</li>
                    <li><strong>Compare resultados:</strong> Use a aba "Comparação" para analisar a performance antes e depois da migração.</li>
                </ul>
            `;
            
            tabContents.appendChild(summaryPanel);
        }
        
        // Aba de Histórico
        function showHistoryTab(perfData) {
            // Ordenar por timestamp (mais recente primeiro)
            const sortedData = [...perfData].sort((a, b) => new Date(b.timestamp) - new Date(a.timestamp));
            
            // Criar tabela de histórico
            const historyTable = document.createElement('table');
            historyTable.style.width = '100%';
            historyTable.style.borderCollapse = 'collapse';
            historyTable.style.fontSize = '14px';
            
            // Cabeçalho
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr style="background: #f1f1f1;">
                    <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Data/Hora</th>
                    <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Página</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Carga Total</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">1ª Pintura</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">DOM</th>
                    <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Scripts</th>
                    <th style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Migrado</th>
                </tr>
            `;
            
            // Corpo da tabela
            const tbody = document.createElement('tbody');
            
            sortedData.forEach(entry => {
                const row = document.createElement('tr');
                
                // Formatação de data
                const date = new Date(entry.timestamp);
                const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;
                
                // Caminho da página simplificado
                const shortPath = entry.url === '/' ? 'Home' : entry.url.split('/').pop() || entry.url;
                
                row.innerHTML = `
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">${formattedDate}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #eee;">${shortPath}</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.pageLoad}ms</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.firstPaint}ms</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.domComplete}ms</td>
                    <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.totalScriptTime}ms</td>
                    <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                        ${entry.hasMigratedElements ? 
                          '<span style="color: green; font-weight: bold;">✓</span>' : 
                          '<span style="color: #888;">-</span>'}
                    </td>
                `;
                
                // Destacar linhas com elementos migrados
                if (entry.hasMigratedElements) {
                    row.style.background = '#f9f9f9';
                }
                
                tbody.appendChild(row);
            });
            
            historyTable.appendChild(thead);
            historyTable.appendChild(tbody);
            
            // Adicionar controles
            const controls = document.createElement('div');
            controls.style.marginBottom = '20px';
            controls.style.display = 'flex';
            controls.style.justifyContent = 'space-between';
            controls.style.alignItems = 'center';
            
            const totalRecords = document.createElement('div');
            totalRecords.textContent = `Total de ${sortedData.length} registros`;
            totalRecords.style.color = '#666';
            
            const clearBtn = document.createElement('button');
            clearBtn.textContent = 'Limpar Histórico';
            clearBtn.style.padding = '8px 16px';
            clearBtn.style.background = '#dc3545';
            clearBtn.style.color = 'white';
            clearBtn.style.border = 'none';
            clearBtn.style.borderRadius = '4px';
            clearBtn.style.cursor = 'pointer';
            clearBtn.onclick = () => {
                if (confirm('Tem certeza que deseja limpar todo o histórico de performance?')) {
                    localStorage.removeItem('hb-performance-history');
                    alert('Histórico limpo com sucesso!');
                    window.location.reload();
                }
            };
            
            controls.appendChild(totalRecords);
            controls.appendChild(clearBtn);
            
            tabContents.appendChild(controls);
            tabContents.appendChild(historyTable);
        }
        
        // Aba de Comparação
        function showComparisonTab(perfData) {
            // Agrupar dados por URL
            const dataByUrl = {};
            
            perfData.forEach(entry => {
                if (!dataByUrl[entry.url]) {
                    dataByUrl[entry.url] = [];
                }
                dataByUrl[entry.url].push(entry);
            });
            
            // Criar análise de comparação
            const comparisonContent = document.createElement('div');
            
            // Para cada URL, comparar antes e depois da migração
            Object.keys(dataByUrl).forEach(url => {
                const entries = dataByUrl[url];
                
                // Separar entradas com e sem migração
                const nonMigratedEntries = entries.filter(e => !e.hasMigratedElements);
                const migratedEntries = entries.filter(e => e.hasMigratedElements);
                
                // Pular URLs sem dados suficientes para comparação
                if (nonMigratedEntries.length === 0 || migratedEntries.length === 0) {
                    return;
                }
                
                // Calcular médias para cada grupo
                const avgNonMigrated = calculateAverageMetrics(nonMigratedEntries);
                const avgMigrated = calculateAverageMetrics(migratedEntries);
                
                // Calcular diferenças percentuais
                const differences = {};
                Object.keys(avgMigrated).forEach(metric => {
                    if (avgNonMigrated[metric] > 0) {
                        const diff = avgMigrated[metric] - avgNonMigrated[metric];
                        const percentDiff = Math.round((diff / avgNonMigrated[metric]) * 100);
                        
                        differences[metric] = {
                            absolute: diff,
                            percent: percentDiff
                        };
                    }
                });
                
                // Criar painel de comparação para esta URL
                const urlPanel = document.createElement('div');
                urlPanel.style.marginBottom = '30px';
                urlPanel.style.padding = '20px';
                urlPanel.style.border = '1px solid #eee';
                urlPanel.style.borderRadius = '8px';
                urlPanel.style.boxShadow = '0 1px 3px rgba(0,0,0,0.05)';
                
                // Caminho simplificado
                const shortPath = url === '/' ? 'Home' : url.split('/').pop() || url;
                
                urlPanel.innerHTML = `
                    <h3 style="margin: 0 0 15px 0; color: #333; font-size: 18px;">
                        Página: ${shortPath}
                        <span style="float: right; font-size: 12px; color: #666; font-weight: normal;">
                            ${nonMigratedEntries.length} medições antes | ${migratedEntries.length} medições depois
                        </span>
                    </h3>
                    
                    <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                        <thead>
                            <tr style="background: #f5f5f5;">
                                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Métrica</th>
                                <th style="padding: 8px; text-align: right; border-bottom: 1px solid #ddd;">Antes</th>
                                <th style="padding: 8px; text-align: right; border-bottom: 1px solid #ddd;">Depois</th>
                                <th style="padding: 8px; text-align: right; border-bottom: 1px solid #ddd;">Diferença</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${Object.keys(differences).map(metric => {
                                const diff = differences[metric];
                                const isImproved = diff.percent < 0;
                                const isSame = diff.percent === 0;
                                const diffColor = isImproved ? 'green' : (isSame ? '#666' : '#dc3545');
                                
                                // Formatar nome da métrica
                                let metricName = metric;
                                if (metric === 'pageLoad') metricName = 'Tempo de carregamento total';
                                if (metric === 'firstPaint') metricName = 'Primeira pintura';
                                if (metric === 'firstContentfulPaint') metricName = 'Primeira pintura com conteúdo';
                                if (metric === 'domComplete') metricName = 'Tempo de carregamento do DOM';
                                if (metric === 'resourcesLoad') metricName = 'Tempo de carregamento de recursos';
                                if (metric === 'carouselInit') metricName = 'Inicialização dos carrosséis';
                                if (metric === 'totalScriptTime') metricName = 'Tempo total de scripts';
                                
                                return `
                                    <tr>
                                        <td style="padding: 8px; border-bottom: 1px solid #eee;">${metricName}</td>
                                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">${avgNonMigrated[metric]}ms</td>
                                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee;">${avgMigrated[metric]}ms</td>
                                        <td style="padding: 8px; text-align: right; border-bottom: 1px solid #eee; font-weight: bold; color: ${diffColor};">
                                            ${diff.percent > 0 ? '+' : ''}${diff.percent}% (${diff.absolute > 0 ? '+' : ''}${diff.absolute}ms)
                                        </td>
                                    </tr>
                                `;
                            }).join('')}
                        </tbody>
                    </table>
                    
                    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px solid #eee; font-size: 13px; color: #666;">
                        ${getPerformanceVerdict(differences)}
                    </div>
                `;
                
                comparisonContent.appendChild(urlPanel);
            });
            
            // Se não houver comparações disponíveis
            if (comparisonContent.children.length === 0) {
                comparisonContent.innerHTML = `
                    <div style="text-align: center; padding: 40px 20px; color: #666;">
                        <div style="font-size: 32px; margin-bottom: 10px;">📊</div>
                        <h3 style="margin: 0 0 10px 0;">Dados insuficientes para comparação</h3>
                        <p>Para comparar a performance antes e depois da migração, você precisa ter medições de pelo menos uma página em ambos os estados.</p>
                        <p>Navegue pelo site com e sem classes migradas para coletar dados comparativos.</p>
                    </div>
                `;
            }
            
            tabContents.appendChild(comparisonContent);
        }
        
        // Aba por página
        function showByPageTab(perfData) {
            // Agrupar dados por URL
            const urlsSet = new Set();
            perfData.forEach(entry => urlsSet.add(entry.url));
            
            const urls = Array.from(urlsSet);
            
            // Criar seletor de página
            const pageSelector = document.createElement('div');
            pageSelector.style.marginBottom = '20px';
            
            const selectLabel = document.createElement('label');
            selectLabel.textContent = 'Selecione uma página: ';
            selectLabel.style.marginRight = '10px';
            
            const select = document.createElement('select');
            select.style.padding = '8px 12px';
            select.style.borderRadius = '4px';
            select.style.border = '1px solid #ddd';
            
            urls.forEach(url => {
                const option = document.createElement('option');
                option.value = url;
                // Formatar nome da página
                option.textContent = url === '/' ? 'Home' : url.split('/').pop() || url;
                select.appendChild(option);
            });
            
            // Conteúdo da página selecionada
            const pageContent = document.createElement('div');
            
            // Função para mostrar dados da página selecionada
            function showPageData(url) {
                // Filtrar dados da página
                const pageData = perfData.filter(entry => entry.url === url);
                
                pageContent.innerHTML = '';
                
                if (pageData.length === 0) {
                    pageContent.innerHTML = '<div style="text-align: center; padding: 20px; color: #666;">Nenhum dado disponível para esta página</div>';
                    return;
                }
                
                // Ordenar por timestamp
                pageData.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                
                // Criar gráfico de tendência
                const chartContainer = document.createElement('div');
                chartContainer.style.marginBottom = '30px';
                chartContainer.style.padding = '20px';
                chartContainer.style.background = '#f8f9fa';
                chartContainer.style.borderRadius = '8px';
                
                // Simplificar timestamps para exibição
                const timestamps = pageData.map((_, index) => `#${index + 1}`);
                
                // Preparar dados para os gráficos
                const pageLoadData = pageData.map(entry => entry.metrics.pageLoad);
                const firstPaintData = pageData.map(entry => entry.metrics.firstPaint);
                const fcpData = pageData.map(entry => entry.metrics.firstContentfulPaint);
                
                // Criar gráfico de barras simples
                chartContainer.innerHTML = `
                    <h3 style="margin: 0 0 15px 0; font-size: 16px;">Tendência de Performance</h3>
                    <div style="display: flex; flex-direction: column; height: 200px; position: relative;">
                        <div style="position: absolute; left: 0; top: 0; bottom: 0; display: flex; flex-direction: column; justify-content: space-between; padding-right: 10px;">
                            <span style="font-size: 12px; color: #999;">Max</span>
                            <span style="font-size: 12px; color: #999;">0ms</span>
                        </div>
                        <div style="margin-left: 40px; display: flex; height: 100%; align-items: flex-end;">
                            ${createBarChart(pageLoadData, timestamps, '#FF3333')}
                        </div>
                        <div style="margin-top: 10px; margin-left: 40px; display: flex; justify-content: space-between;">
                            ${timestamps.map(ts => `<div style="font-size: 11px; color: #666;">${ts}</div>`).join('')}
                        </div>
                    </div>
                    <div style="margin-top: 10px; display: flex; justify-content: center; font-size: 12px; color: #666;">
                        <div style="display: flex; align-items: center; margin-right: 20px;">
                            <span style="display: inline-block; width: 12px; height: 12px; background: #FF3333; margin-right: 5px;"></span>
                            Tempo de carregamento
                        </div>
                    </div>
                `;
                
                // Tabela detalhada
                const detailsTable = document.createElement('table');
                detailsTable.style.width = '100%';
                detailsTable.style.borderCollapse = 'collapse';
                detailsTable.style.fontSize = '14px';
                
                // Cabeçalho
                const thead = document.createElement('thead');
                thead.innerHTML = `
                    <tr style="background: #f1f1f1;">
                        <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">#</th>
                        <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Data/Hora</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Carga Total</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">1ª Pintura</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">DOM</th>
                        <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Scripts</th>
                        <th style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Migrado</th>
                    </tr>
                `;
                
                // Corpo da tabela
                const tbody = document.createElement('tbody');
                
                pageData.forEach((entry, index) => {
                    const row = document.createElement('tr');
                    
                    // Formatação de data
                    const date = new Date(entry.timestamp);
                    const formattedDate = `${date.toLocaleDateString()} ${date.toLocaleTimeString()}`;
                    
                    row.innerHTML = `
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">${index + 1}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #eee;">${formattedDate}</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.pageLoad}ms</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.firstPaint}ms</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.domComplete}ms</td>
                        <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">${entry.metrics.totalScriptTime}ms</td>
                        <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;">
                            ${entry.hasMigratedElements ? 
                              '<span style="color: green; font-weight: bold;">✓</span>' : 
                              '<span style="color: #888;">-</span>'}
                        </td>
                    `;
                    
                    // Destacar linhas com elementos migrados
                    if (entry.hasMigratedElements) {
                        row.style.background = '#f9f9f9';
                    }
                    
                    tbody.appendChild(row);
                });
                
                detailsTable.appendChild(thead);
                detailsTable.appendChild(tbody);
                
                pageContent.appendChild(chartContainer);
                pageContent.appendChild(detailsTable);
            }
            
            // Evento de alteração do select
            select.addEventListener('change', function() {
                showPageData(this.value);
            });
            
            pageSelector.appendChild(selectLabel);
            pageSelector.appendChild(select);
            
            tabContents.appendChild(pageSelector);
            tabContents.appendChild(pageContent);
            
            // Mostrar a primeira página por padrão
            if (urls.length > 0) {
                showPageData(urls[0]);
            }
        }
        
        // Função para calcular médias de métricas de um conjunto de dados
        function calculateAverageMetrics(entries) {
            if (entries.length === 0) return {};
            
            const avg = {};
            
            // Pegar primeira entrada para saber quais métricas existem
            const metrics = Object.keys(entries[0].metrics);
            
            metrics.forEach(metric => {
                const sum = entries.reduce((total, entry) => total + (entry.metrics[metric] || 0), 0);
                avg[metric] = Math.round(sum / entries.length);
            });
            
            return avg;
        }
        
        // Função para criar um gráfico de barras simples em HTML/CSS
        function createBarChart(data, labels, color) {
            // Encontrar o valor máximo para escala
            const max = Math.max(...data);
            
            // Criar barras
            return data.map((value, index) => {
                // Calcular altura relativa (%)
                const height = max > 0 ? Math.max(5, (value / max) * 100) : 5;
                
                return `
                    <div style="flex: 1; display: flex; flex-direction: column; align-items: center; height: 100%;">
                        <div style="width: 70%; background: ${color}; height: ${height}%; position: relative;">
                            <span style="position: absolute; top: -20px; font-size: 11px; color: #666; left: 50%; transform: translateX(-50%);">${value}ms</span>
                        </div>
                    </div>
                `;
            }).join('');
        }
        
        // Função para gerar um veredicto com base nas diferenças de performance
        function getPerformanceVerdict(differences) {
            // Contar melhorias e regressões
            let improvements = 0;
            let regressions = 0;
            let significantRegressions = 0;
            
            Object.values(differences).forEach(diff => {
                if (diff.percent < 0) improvements++;
                if (diff.percent > 0) regressions++;
                if (diff.percent > 20) significantRegressions++;
            });
            
            // Gerar veredicto
            if (significantRegressions > 0) {
                return `<strong style="color: #dc3545;">⚠️ Alerta:</strong> Detectada regressão significativa de performance após a migração. Recomenda-se investigar, especialmente ${Object.keys(differences).filter(k => differences[k].percent > 20).join(', ')}.`;
            } else if (regressions > improvements) {
                return `<strong style="color: #fd7e14;">⚠️ Atenção:</strong> A migração causou pequenas regressões de performance. Pode ser necessário otimizar alguns componentes.`;
            } else if (improvements > regressions) {
                return `<strong style="color: green;">✓ Positivo:</strong> A migração resultou em melhoria geral de performance. Continue monitorando à medida que mais elementos são migrados.`;
            } else {
                return `<strong style="color: #0d6efd;">ℹ️ Neutro:</strong> Não houve mudanças significativas de performance após a migração.`;
            }
        }
    }
});
