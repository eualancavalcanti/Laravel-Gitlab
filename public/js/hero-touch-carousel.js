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
            slideSelector: '.content-grid, .actors-carousel', // Seletor dos slides
            navPrevSelector: '.prev',                         // Botão anterior
            navNextSelector: '.next',                         // Botão próximo
            itemSelector: '.content-card, .actor-card',       // Itens dentro do slide
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
            value: this.velocityX * 100,
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
        
        // Reduz a inércia gradualmente (simulando atrito)
        this.momentum.value *= 0.95;
        
        // Continua animando enquanto tiver movimento significativo
        if (Math.abs(this.momentum.value) > 0.5) {
            this.rafId = requestAnimationFrame(this.animateMomentum.bind(this));
        } else {
            // Quando estiver quase parando, snap para o item mais próximo
            this.cancelMomentum();
            
            if (this.options.snapToItem) {
                this.snapToNearestItem(this.momentum.value < 0);
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
     * Snap para o item mais próximo
     */
    snapToNearestItem(isMovingForward = true) {
        // Encontra todos os pontos de snap (início de cada item)
        const items = Array.from(this.items);
        const trackRect = this.track.getBoundingClientRect();
        const currentScrollLeft = this.track.scrollLeft;
        
        // Calcula o ponto de snap para cada item
        const snapPoints = items.map(item => {
            const itemRect = item.getBoundingClientRect();
            const itemLeft = itemRect.left - trackRect.left + currentScrollLeft;
            return itemLeft;
        });
        
        // Adiciona o fim do carrossel como último ponto de snap
        snapPoints.push(this.track.scrollWidth - this.track.clientWidth);
        
        // Encontra o ponto de snap mais próximo
        let targetScrollLeft;
        
        if (isMovingForward) {
            // Encontra o próximo ponto à direita
            targetScrollLeft = snapPoints.find(point => point > currentScrollLeft + 10) || snapPoints[snapPoints.length - 1];
        } else {
            // Encontra o próximo ponto à esquerda
            targetScrollLeft = [...snapPoints].reverse().find(point => point < currentScrollLeft - 10) || snapPoints[0];
        }
        
        // Adiciona uma transição suave para o ponto de snap
        this.track.style.scrollBehavior = 'smooth';
        this.track.scrollLeft = targetScrollLeft;
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
    // Seleciona todos os contêineres de carrossel
    const carouselContainers = document.querySelectorAll('.section-container');
    
    // Cria um objeto TouchCarousel para cada contêiner
    const carousels = Array.from(carouselContainers).map(container => {
        return new TouchCarousel(container);
    });
    
    // Recalcula os tamanhos em redimensionamento de janela
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            carousels.forEach(carousel => {
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