/**
 * Enhanced Touch Carousel para HotBoys
 * Um carrossel otimizado para dispositivos mobile com suporte a gestos de arrastar
 * e transições suaves com inércia e física realista.
 */

class TouchCarousel {
    constructor(container, options = {}) {
        // Elemento principal do carrossel
        this.container = typeof container === 'string' ? document.querySelector(container) : container;
        if (!this.container) return;
        
        // Configurações padrão
        this.options = Object.assign({
            slideSelector: '.content-grid, .actors-carousel, .creators-carousel', // Seletor dos slides
            navPrevSelector: '.prev',                         // Botão anterior
            navNextSelector: '.next',                         // Botão próximo
            itemSelector: '.content-card, .actor-card, .creator-card-premium',       // Itens dentro do slide
            threshold: 100,                                   // Limite de pixels para considerar como swipe
            transitionSpeed: 300,                             // Velocidade de transição em ms
            momentum: true,                                   // Habilitar momentum/inércia
            snapToItem: true,                                 // Snap para o item mais próximo
            dragResistance: 0.7,                              // Resistência ao arrastar (0-1)
            autoWidth: true                                   // Largura automática dos itens
        }, options);
        
        // Elementos do carrossel
        this.track = this.container.querySelector(this.options.slideSelector);
        this.items = this.track ? this.track.querySelectorAll(this.options.itemSelector) : [];
        this.prevBtn = this.container.querySelector(this.options.navPrevSelector);
        this.nextBtn = this.container.querySelector(this.options.navNextSelector);
        
        if (!this.track || this.items.length === 0) return;
        
        // Estado
        this.isDragging = false;
        this.startPosition = 0;
        this.startScrollLeft = 0;
        this.lastPosition = 0;
        this.velocityX = 0;
        this.timestamp = 0;
        this.momentum = { value: 0, active: false };
        this.rafId = null;
        this.scrollTimeout = null;
        
        // Calcular largura do item se autoWidth estiver ativado
        if (this.options.autoWidth) {
            this.calculateItemWidth();
            window.addEventListener('resize', this.calculateItemWidth.bind(this));
        }
        
        // Inicializar
        this.bindEvents();
        this.updateButtonVisibility();
    }
    
    /**
     * Calcula a largura adequada para os itens do carrossel
     */
    calculateItemWidth() {
        if (!this.track || this.items.length === 0) return;
        
        // Ajusta a largura dos itens com base no tamanho da tela
        const isMobile = window.innerWidth < 768;
        const containerWidth = this.container.clientWidth;
        
        // Para mobile: 80% da largura do container; para desktop: 300px ou tamanho que caiba 3-4 itens
        let itemWidth;
        if (isMobile) {
            itemWidth = containerWidth * 0.8 + 'px';
        } else {
            // Calcula para mostrar 3-4 itens com gap de 1.5rem
            const gap = 24; // 1.5rem = 24px aproximadamente
            const itemsToShow = containerWidth >= 1200 ? 4 : containerWidth >= 992 ? 3.5 : 3;
            itemWidth = Math.min(300, (containerWidth - (gap * (itemsToShow - 1))) / itemsToShow) + 'px';
        }
        
        // Aplica largura aos itens
        this.items.forEach(item => {
            item.style.minWidth = itemWidth;
        });
    }
    
    /**
     * Vincula eventos de interação ao carrossel
     */
    bindEvents() {
        // Eventos de toque
        this.track.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: false });
        this.track.addEventListener('touchmove', this.handleTouchMove.bind(this), { passive: false });
        this.track.addEventListener('touchend', this.handleTouchEnd.bind(this));
        
        // Eventos de mouse
        this.track.addEventListener('mousedown', this.handleMouseDown.bind(this));
        document.addEventListener('mousemove', this.handleMouseMove.bind(this));
        document.addEventListener('mouseup', this.handleMouseUp.bind(this));
        
        // Evento de scroll para atualizar estado dos botões
        this.track.addEventListener('scroll', this.handleScroll.bind(this));
        
        // Eventos de botões de navegação
        if (this.prevBtn) {
            this.prevBtn.addEventListener('click', this.handlePrevClick.bind(this));
        }
        
        if (this.nextBtn) {
            this.nextBtn.addEventListener('click', this.handleNextClick.bind(this));
        }
        
        // Eventos de saída/entrada da janela
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.cancelMomentum();
            }
        });
    }
    
    /**
     * Eventos de início de toque
     */
    handleTouchStart(e) {
        this.startDrag(e.touches[0].clientX);
        e.preventDefault(); // Previne scroll da página
    }
    
    /**
     * Eventos de movimento durante o toque
     */
    handleTouchMove(e) {
        if (!this.isDragging) return;
        
        const currentPosition = e.touches[0].clientX;
        this.drag(currentPosition);
        e.preventDefault(); // Previne scroll da página
    }
    
    /**
     * Eventos de fim de toque
     */
    handleTouchEnd(e) {
        this.endDrag();
    }
    
    /**
     * Eventos de início de clique do mouse
     */
    handleMouseDown(e) {
        e.preventDefault();
        this.startDrag(e.clientX);
    }
    
    /**
     * Eventos de movimento durante clique do mouse
     */
    handleMouseMove(e) {
        if (!this.isDragging) return;
        
        e.preventDefault();
        this.drag(e.clientX);
    }
    
    /**
     * Eventos de fim de clique do mouse
     */
    handleMouseUp(e) {
        this.endDrag();
    }
    
    /**
     * Evento de scroll para atualizar visibilidade dos botões
     */
    handleScroll() {
        clearTimeout(this.scrollTimeout);
        
        // Debounce para não chamar muitas vezes durante o scroll
        this.scrollTimeout = setTimeout(() => {
            this.updateButtonVisibility();
        }, 100);
    }
    
    /**
     * Iniciar o arrastar
     */
    startDrag(position) {
        this.cancelMomentum();
        
        this.isDragging = true;
        this.startPosition = position;
        this.lastPosition = position;
        this.startScrollLeft = this.track.scrollLeft;
        this.timestamp = Date.now();
        
        // Remover transição suave durante o arrasto
        this.track.style.scrollBehavior = 'auto';
        
        // Adicionar classe de arrasto
        this.track.classList.add('dragging');
        
        // Remover transitions para melhor performance
        this.items.forEach(item => {
            item.style.transition = 'none';
        });
    }
    
    /**
     * Continuação do arrastar
     */
    drag(position) {
        if (!this.isDragging) return;
        
        // Calcula distância percorrida
        const delta = this.startPosition - position;
        const dragAmount = delta * this.options.dragResistance;
        
        // Move os slides
        this.track.scrollLeft = this.startScrollLeft + dragAmount;
        
        // Rastreamento de velocidade para efeito de inércia
        const now = Date.now();
        const elapsed = now - this.timestamp;
        
        if (elapsed > 0) {
            this.velocityX = (position - this.lastPosition) / elapsed;
            this.timestamp = now;
            this.lastPosition = position;
        }
    }
    
    /**
     * Finalizar o arrastar
     */
    endDrag() {
        if (!this.isDragging) return;
        
        this.isDragging = false;
        
        // Restaurar transições
        this.track.style.scrollBehavior = 'smooth';
        this.track.classList.remove('dragging');
        
        this.items.forEach(item => {
            item.style.transition = '';
        });
        
        // Calcular se foi um swipe
        const delta = this.startPosition - this.lastPosition;
        
        // Aplicar inércia ou snap para o item mais próximo
        if (this.options.momentum && Math.abs(this.velocityX) > 0.1) {
            this.applyMomentum();
        } else if (this.options.snapToItem && Math.abs(delta) > this.options.threshold) {
            this.snapToNearestItem(delta > 0);
        }
        
        this.updateButtonVisibility();
    }
    
    /**
     * Aplicar efeito de inércia/momentum para um deslize mais natural
     */
    applyMomentum() {
        this.cancelMomentum(); // Cancela qualquer momentum anterior
        
        // Valor de inércia inicial baseado na velocidade
        this.momentum = {
            value: this.velocityX * 120, // Aumentado para uma sensação mais fluida
            active: true
        };
        
        // Inicia animação de inércia
        this.animateMomentum();
    }
    
    /**
     * Anima o efeito de inércia para desaceleração natural
     */
    animateMomentum() {
        if (!this.momentum.active) return;
        
        // Atualiza a posição do scroll com base na inércia
        this.track.scrollLeft -= this.momentum.value;
        
        // Reduz a inércia gradualmente (desaceleração mais suave)
        this.momentum.value *= 0.96; // Desaceleração mais suave
        
        // Continua animando enquanto tiver movimento significativo
        if (Math.abs(this.momentum.value) > 0.5) {
            this.rafId = requestAnimationFrame(this.animateMomentum.bind(this));
        } else {
            // Quando estiver quase parando, snap para o item mais próximo com um pequeno atraso
            this.cancelMomentum();
            
            if (this.options.snapToItem) {
                // Pequeno atraso antes de fazer o snap para evitar saltos bruscos
                setTimeout(() => {
                    this.snapToNearestItem(this.momentum.value < 0);
                }, 50);
            }
        }
    }
    
    /**
     * Cancela qualquer animação de inércia em andamento
     */
    cancelMomentum() {
        if (this.rafId) {
            cancelAnimationFrame(this.rafId);
            this.rafId = null;
        }
        
        this.momentum.active = false;
    }
    
    /**
     * Snap para o item mais próximo - versão melhorada
     */
    snapToNearestItem(isMovingForward = true) {
        // Encontra todos os pontos de snap (início de cada item)
        const items = Array.from(this.items);
        const trackRect = this.track.getBoundingClientRect();
        const currentScrollLeft = this.track.scrollLeft;
        
        // Calcula o centro da visualização
        const viewportCenter = trackRect.width / 2;
        
        // Calcula o ponto de snap para cada item (centralizado)
        const snapPoints = items.map(item => {
            const itemRect = item.getBoundingClientRect();
            const itemCenter = itemRect.left - trackRect.left + (itemRect.width / 2) + currentScrollLeft;
            const distance = Math.abs(itemCenter - viewportCenter - currentScrollLeft);
            return { position: itemCenter - viewportCenter, distance };
        });
        
        // Adiciona o fim do carrossel como último ponto de snap
        const endPoint = { 
            position: this.track.scrollWidth - this.track.clientWidth, 
            distance: Math.abs((this.track.scrollWidth - this.track.clientWidth) - currentScrollLeft) 
        };
        snapPoints.push(endPoint);
        
        // Adiciona o início do carrossel como primeiro ponto de snap
        const startPoint = { position: 0, distance: currentScrollLeft };
        snapPoints.unshift(startPoint);
        
        // Encontra o ponto de snap mais próximo com base na direção
        let targetScrollLeft;
        
        if (isMovingForward) {
            // Filtra apenas os pontos à frente da posição atual
            const forwardPoints = snapPoints.filter(point => point.position > currentScrollLeft + 5);
            
            if (forwardPoints.length > 0) {
                // Ordena por distância e pega o mais próximo
                targetScrollLeft = forwardPoints.sort((a, b) => a.distance - b.distance)[0].position;
            } else {
                // Se não houver pontos à frente, vai para o último
                targetScrollLeft = endPoint.position;
            }
        } else {
            // Filtra apenas os pontos atrás da posição atual
            const backwardPoints = snapPoints.filter(point => point.position < currentScrollLeft - 5);
            
            if (backwardPoints.length > 0) {
                // Ordena por distância e pega o mais próximo
                targetScrollLeft = backwardPoints.sort((a, b) => a.distance - b.distance)[0].position;
            } else {
                // Se não houver pontos atrás, vai para o primeiro
                targetScrollLeft = startPoint.position;
            }
        }
        
        // Aplica uma curva de animação mais suave
        this.track.style.scrollBehavior = 'smooth';
        
        // Em iOS, a scrollBehavior pode não funcionar tão bem, então implementamos uma animação alternativa
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        
        if (isIOS) {
            // Animação personalizada para iOS
            const startPosition = this.track.scrollLeft;
            const distance = targetScrollLeft - startPosition;
            const duration = 500; // ms
            const startTime = Date.now();
            
            // Função de animação personalizada com curva de easing
            const animateScroll = () => {
                const elapsed = Date.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                
                // Função de easing (ease-out-cubic)
                const easeOutCubic = progress => 1 - Math.pow(1 - progress, 3);
                const easedProgress = easeOutCubic(progress);
                
                this.track.scrollLeft = startPosition + (distance * easedProgress);
                
                if (progress < 1) {
                    requestAnimationFrame(animateScroll);
                }
            };
            
            // Inicia a animação personalizada
            requestAnimationFrame(animateScroll);
        } else {
            // Para outros navegadores, usa scroll-behavior nativo
            this.track.scrollLeft = targetScrollLeft;
        }
    }
    
    /**
     * Manipulador de clique no botão anterior
     */
    handlePrevClick() {
        this.cancelMomentum();
        
        const itemWidth = this.items[0] ? this.items[0].offsetWidth : 300;
        const scrollAmount = Math.min(this.track.clientWidth, itemWidth + 24); // 24px para o gap
        
        this.track.style.scrollBehavior = 'smooth';
        this.track.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });
        
        setTimeout(() => {
            this.updateButtonVisibility();
        }, this.options.transitionSpeed + 50);
    }
    
    /**
     * Manipulador de clique no botão próximo
     */
    handleNextClick() {
        this.cancelMomentum();
        
        const itemWidth = this.items[0] ? this.items[0].offsetWidth : 300;
        const scrollAmount = Math.min(this.track.clientWidth, itemWidth + 24); // 24px para o gap
        
        this.track.style.scrollBehavior = 'smooth';
        this.track.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
        
        setTimeout(() => {
            this.updateButtonVisibility();
        }, this.options.transitionSpeed + 50);
    }
    
    /**
     * Atualiza a visibilidade dos botões de navegação
     */
    updateButtonVisibility() {
        if (!this.track || !this.prevBtn || !this.nextBtn) return;
        
        const scrollWidth = this.track.scrollWidth;
        const clientWidth = this.track.clientWidth;
        const scrollLeft = this.track.scrollLeft;
        
        // Atualiza os botões prev/next
        if (scrollLeft <= 5) {
            this.prevBtn.classList.add('disabled');
            this.prevBtn.setAttribute('disabled', 'disabled');
        } else {
            this.prevBtn.classList.remove('disabled');
            this.prevBtn.removeAttribute('disabled');
        }
        
        if (scrollLeft >= scrollWidth - clientWidth - 5) {
            this.nextBtn.classList.add('disabled');
            this.nextBtn.setAttribute('disabled', 'disabled');
        } else {
            this.nextBtn.classList.remove('disabled');
            this.nextBtn.removeAttribute('disabled');
        }
    }
}

// Inicializar todos os carrosséis quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', () => {
    // Inicializa o carrossel principal de hero
    const heroContainers = document.querySelectorAll('.hero-section .section-container');
    const heroCarousels = Array.from(heroContainers).map(container => {
        return new TouchCarousel(container);
    });
    
    // Inicializa carrosséis de conteúdo
    const contentContainers = document.querySelectorAll('.continue-watching .section-container, .featured-content .section-container');
    const contentCarousels = Array.from(contentContainers).map(container => {
        return new TouchCarousel(container);
    });
    
    // Inicializa carrosséis de atores
    const actorContainers = document.querySelectorAll('.featured-actors .section-container');
    const actorCarousels = Array.from(actorContainers).map(container => {
        return new TouchCarousel(container);
    });
    
    // Inicializa explicitamente o carrossel de criadores do momento
    const creatorContainers = document.querySelectorAll('.trending-creators .section-container');
    const creatorCarousels = Array.from(creatorContainers).map(container => {
        return new TouchCarousel(container, {
            slideSelector: '.creators-carousel',
            itemSelector: '.creator-card-premium'
        });
    });
    
    // Combina todos os carrosséis em um único array para facilitar o gerenciamento
    const allCarousels = [
        ...heroCarousels,
        ...contentCarousels,
        ...actorCarousels,
        ...creatorCarousels
    ].filter(carousel => carousel); // Filtra valores nulos
    
    // Recalcula os tamanhos em redimensionamento de janela
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            allCarousels.forEach(carousel => {
                if (carousel.calculateItemWidth) {
                    carousel.calculateItemWidth();
                }
                if (carousel.updateButtonVisibility) {
                    carousel.updateButtonVisibility();
                }
            });
        }, 250);
    });
});