/**
 * SOLUÇÃO ULTRA-HARDCORE para corrigir links nos cards do HotBoys
 * Versão que garante que cada link navegue para o destino correto
 */
(function() {
    console.log('🛠️ Iniciando correção ULTRA-HARDCORE de links...');
    
    // Função para extrair e limpar o nome do criador
    function extrairNomeCreator(card) {
        // Tentar extrair o nome do criador/ator no card
        const nomeElement = card.querySelector('h2, h3, h4, .name, [class*="name"], [class*="title"]');
        if (nomeElement) {
            return nomeElement.textContent.trim();
        }
        
        // Tentar extrair de outras fontes - tags de imagem, alt text, etc.
        const imgs = card.querySelectorAll('img[alt]');
        for (let img of imgs) {
            if (img.alt && img.alt.trim()) {
                return img.alt.trim();
            }
        }
        
        return '';
    }
    
    // Função para criar uma URL slug a partir de um nome
    function criarSlug(nome) {
        return nome.toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')  // Remove acentos
            .replace(/[^\w\s-]/g, '')  // Remove caracteres especiais
            .trim().replace(/\s+/g, '-');  // espaços por hífens
    }
    
    // Método para garantir URL única para cada criador
    function gerarUrlUnica(card, index) {
        // Extrair nome
        const nome = extrairNomeCreator(card);
        
        // Se não conseguir extrair nome, usar índice único
        if (!nome) {
            return `/creator/creator-${index}`;
        }
        
        // Criar slug a partir do nome
        const slug = criarSlug(nome);
        return `/creator/${slug}`;
    }
    
    // Método principal de correção
    function corrigirTodosOsLinks() {
        // Corrigir botões "Ver Conteúdo Premium"
        const botoes = Array.from(document.querySelectorAll('a, button, div[class*="btn"], div[class*="button"]'))
            .filter(el => el.textContent.trim().includes('Ver Conteúdo Premium') && !el.hasAttribute('data-ultra-fixed'));
        
        console.log(`Processando ${botoes.length} botões "Ver Conteúdo Premium"`);
        
        botoes.forEach((botao, index) => {
            // Encontrar o card pai
            const card = botao.closest('[class*="card"]');
            if (!card) return;
            
            // Gerar URL única para este criador
            const urlDestino = gerarUrlUnica(card, index);
            
            // Criar um elemento <a> completamente novo
            const novoLink = document.createElement('a');
            novoLink.textContent = botao.textContent.trim();
            novoLink.href = urlDestino;
            novoLink.setAttribute('data-ultra-fixed', 'true');
            novoLink.setAttribute('data-creator-name', extrairNomeCreator(card));
            
            // Copiar classes e estilos
            if (botao.className) novoLink.className = botao.className;
            Array.from(botao.attributes).forEach(attr => {
                if (!['href', 'onclick', 'data-ultra-fixed'].includes(attr.name)) {
                    novoLink.setAttribute(attr.name, attr.value);
                }
            });
            
            // Aplicar estilos para garantir visibilidade
            novoLink.style.display = 'inline-block';
            novoLink.style.position = 'relative';
            novoLink.style.zIndex = '99999';
            
            // Adicionar evento de clique direto
            novoLink.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Debug - mostrar URL que será navegada
                console.log(`🔗 NAVEGANDO PARA: ${urlDestino}`);
                
                // Opção 1: Navigation API
                if (window.navigation && window.navigation.navigate) {
                    window.navigation.navigate(urlDestino);
                } 
                // Opção 2: window.location direta
                else {
                    window.location.href = urlDestino;
                }
                
                return false;
            };
            
            // Substituir o botão original
            if (botao.parentNode) {
                botao.parentNode.replaceChild(novoLink, botao);
                console.log(`✅ Botão corrigido: ${extrairNomeCreator(card)} → ${urlDestino}`);
            }
        });
        
        // Corrigir cards completos
        const cards = Array.from(document.querySelectorAll('[class*="card"]'))
            .filter(card => !card.hasAttribute('data-ultra-fixed') && 
                    (card.classList.contains('creator-card') || 
                     card.classList.contains('actor-card') || 
                     card.classList.toString().includes('creator') || 
                     card.classList.toString().includes('card')));
        
        console.log(`Processando ${cards.length} cards de criadores`);
        
        cards.forEach((card, index) => {
            // Marcar como processado
            card.setAttribute('data-ultra-fixed', 'true');
            
            // Gerar URL única para este card
            const urlDestino = gerarUrlUnica(card, index);
            card.setAttribute('data-target-url', urlDestino);
            
            // Encontrar todos os elementos clicáveis para não interferir
            const clicaveis = card.querySelectorAll('a, button, [class*="btn"], [role="button"]');
            
            // Armazenar referências para evitar interferência
            card._clicaveis = Array.from(clicaveis);
            
            // Adicionar handler de clique que verifica o alvo
            card.addEventListener('click', function(e) {
                // Verificar se o clique foi em algum elemento clicável
                let target = e.target;
                let isClicavel = false;
                
                while (target && target !== this) {
                    if (card._clicaveis.includes(target)) {
                        isClicavel = true;
                        break;
                    }
                    target = target.parentElement;
                }
                
                // Se não for em elemento clicável, navegar para a URL do criador
                if (!isClicavel) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log(`🎯 Clique no card: ${extrairNomeCreator(this)} → ${urlDestino}`);
                    window.location.href = urlDestino;
                    
                    return false;
                }
            });
        });
        
        console.log(`🎉 Correção aplicada a ${botoes.length} botões e ${cards.length} cards.`);
    }
    
    // Executar a correção inicial
    corrigirTodosOsLinks();
    
    // Executar novamente após carregamento completo
    window.addEventListener('load', corrigirTodosOsLinks);
    
    // MutationObserver para executar novamente quando novos elementos forem adicionados
    let pendingUpdate = false;
    
    const observer = new MutationObserver(function() {
        if (!pendingUpdate) {
            pendingUpdate = true;
            setTimeout(() => {
                corrigirTodosOsLinks();
                pendingUpdate = false;
            }, 1000);
        }
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Adicionar botão de diagnóstico
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        const btn = document.createElement('button');
        btn.textContent = '🔄';
        btn.title = 'Reforçar correção de links';
        btn.style.position = 'fixed';
        btn.style.top = '10px';
        btn.style.right = '10px';
        btn.style.zIndex = '999999';
        btn.style.background = '#FF3333';
        btn.style.color = 'white';
        btn.style.border = 'none';
        btn.style.width = '30px';
        btn.style.height = '30px';
        btn.style.borderRadius = '50%';
        btn.style.cursor = 'pointer';
        btn.style.fontSize = '16px';
        btn.style.display = 'flex';
        btn.style.alignItems = 'center';
        btn.style.justifyContent = 'center';
        btn.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
        
        btn.onclick = function() {
            // Remover marcação para reprocessar tudo
            document.querySelectorAll('[data-ultra-fixed]').forEach(el => {
                el.removeAttribute('data-ultra-fixed');
            });
            
            // Executar correção
            corrigirTodosOsLinks();
            
            this.textContent = '✓';
            setTimeout(() => {
                this.textContent = '🔄';
            }, 1000);
        };
        
        document.body.appendChild(btn);
    }
    
    // Alternativa extrema para garantir que links funcionem
    document.addEventListener('click', function(e) {
        if (e.target.tagName === 'A' || e.target.closest('a')) {
            const link = e.target.tagName === 'A' ? e.target : e.target.closest('a');
            const href = link.getAttribute('href');
            
            // Se tiver URL e for URL de criador, garantir navegação
            if (href && href.startsWith('/creator/')) {
                console.log(`🔗 Garantindo navegação para: ${href}`);
                window.location.href = href;
            }
        }
    }, true);  // Capture phase para pegar antes de qualquer stopPropagation
})();
