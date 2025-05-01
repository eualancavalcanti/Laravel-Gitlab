/**
 * Unified Carousel para HotBoys
 * Combina as funcionalidades do hero carousel e dos carrosséis de conteúdo
 * Otimizado para performance e experiência de usuário em desktop e mobile
 * 
 * @version 1.0.1
 * @date 2025-05-01
 */

document.addEventListener('DOMContentLoaded', () => {
    // Variáveis globais para o hero carousel
    let currentSlideIndex = 0;
    let isTransitioning = false;
    let autoplayInterval = null;
    let touchStartX = 0;
    let touchEndX = 0;

    // Função auxiliar para formatar números
    function formatNumber(num) {
        if (num >= 1000000) {
            return (num/1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num/1000).toFixed(1) + 'K';
        }
        return num.toString();
    }
    
    /**
     * Verifica se URL é válido
     * @param {string} url - URL para verificar
     * @return {boolean}
     */
    function isValidUrl(url) {
        if (!url) return false;
        return (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('/'));
    }

    /**
     * Função auxiliar para tratar imagens quebradas nos carrosséis
     * @param {HTMLImageElement} img - Elemento de imagem a ser verificado
     * @param {string} fallbackUrl - URL da imagem padrão (opcional)
     * @param {boolean} isExclusive - Se a imagem faz parte de conteúdo exclusivo (opcional)
     * @return {void}
     */
    function handleBrokenCarouselImages(img, fallbackUrl = null, isExclusive = false) {
        // Define a imagem padrão caso não seja fornecida
        const defaultFallback = '/images/placeholder-content.jpg';
        
        // Verifica se o src é válido
        if (img.src && !isValidUrl(img.src)) {
            if (isExclusive || img.closest('#exclusive .content-card')) {
                img.style.display = 'none';
                console.log('URL inválido em imagem exclusiva - mantendo fundo escuro');
            } else {
                img.src = fallbackUrl || defaultFallback;
                console.log('URL inválido substituído por fallback');
            }
            img.classList.add('fallback-image');
            return;
        }
        
        // Se a imagem já estiver com erro (src inválido), aplica fallback imediatamente
        if (img.complete && (img.naturalWidth === 0 || img.naturalHeight === 0)) {
            applyFallback(img);
            return;
        }
        
        // Configura o evento onerror para substituir a imagem quando ocorrer erro
        img.onerror = function() {
            applyFallback(this);
        };
        
        // Função interna para aplicar o fallback
        function applyFallback(imgElement) {
            // Remove o evento onerror para evitar loops infinitos
            imgElement.onerror = null;
            
            // Para conteúdo exclusivo, pode ter tratamento especial
            if (isExclusive || imgElement.closest('#exclusive .content-card')) {
                // Apenas esconde a imagem mantendo o fundo escuro para conteúdo exclusivo
                imgElement.style.display = 'none';
                console.log('Erro ao carregar imagem exclusiva - mantendo fundo escuro');
            } else {
                // Substitui a imagem pela padrão
                imgElement.src = fallbackUrl || defaultFallback;
                console.log('Imagem substituída por padrão:', imgElement.alt || 'sem alt');
            }
            
            // Adiciona classe para estilização específica de fallback
            imgElement.classList.add('fallback-image');
        }
    }

    // Aplicar tratamento de imagens quebradas nos carrosséis existentes
    function applyBrokenImageHandling() {
        // Seleciona todas as imagens em carrosséis
        const carouselImages = document.querySelectorAll('.content-grid img, .actors-carousel img, .creators-carousel img, .trending-creators img, .featured-content img');
        
        // Aplica tratamento para cada imagem
        carouselImages.forEach(img => {
            // Verifica se a imagem está em um card exclusivo
            const isExclusive = img.closest('#exclusive .content-card') !== null;
            handleBrokenCarouselImages(img, '/images/placeholder-content.jpg', isExclusive);
        });
        
        console.log('Tratamento de imagens quebradas aplicado a', carouselImages.length, 'imagens');
    }

    // Verificação da existência de todos os elementos necessários
    function checkElementsExist() {
        const requiredElements = [
            '.hero',
            '.content-grid',
            '.actors-carousel',
            '.creators-carousel'
        ];
        
        const missingElements = [];
        
        requiredElements.forEach(selector => {
            if (!document.querySelector(selector)) {
                missingElements.push(selector);
            }
        });
        
        if (missingElements.length > 0) {
            console.warn('Elementos não encontrados:', missingElements.join(', '));
            return false;
        }
        
        return true;
    }

    /**
     * Classe principal do carrossel com suporte a touch
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
                autoWidth: true,                                  // Largura automática dos itens
                handleBrokenImages: true                          // Tratamento de imagens quebradas
            }, options);
            
            // Elementos do carrossel
            this.track = this.container.querySelector(this.options.slideSelector);
            this.items = this.track ? Array.from(this.track.querySelectorAll(this.options.itemSelector)) : [];
            this.prevBtn = this.container.querySelector(this.options.navPrevSelector);
            this.nextBtn = this.container.querySelector(this.options.navNextSelector);
            
            if (!this.track || this.items.length === 0) {
                console.warn('Carrossel sem trilha ou itens:', this.container);
                return;
            }
            
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
            }
            
            // Tratamento de imagens quebradas
            if (this.options.handleBrokenImages) {
                this.handleBrokenImages();
            }
            
            // Inicializar
            this.bindEvents();
            this.updateButtonVisibility();
            
            // Debug
            console.log(`Carrossel inicializado: ${this.items.length} itens`, this.container);
        }
        
        /**
         * Calcular largura adequada para os itens do carrossel
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
         * Trata imagens quebradas dentro do carrossel
         */
        handleBrokenImages() {
            const images = this.track.querySelectorAll('img');
            images.forEach(img => {
                const isExclusive = img.closest('#exclusive .content-card') !== null;
                handleBrokenCarouselImages(img, '/images/placeholder-content.jpg', isExclusive);
            });
        }
        
        /**
         * Vincula eventos ao carrossel
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
            
            // Evento de scroll
            this.track.addEventListener('scroll', this.handleScroll.bind(this));
            
            // Eventos de botões de navegação
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', this.handlePrevClick.bind(this));
            }
            
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', this.handleNextClick.bind(this));
            }
        }
        
        /**
         * Eventos de início de toque
         */
        handleTouchStart(e) {
            this.startDrag(e.touches[0].clientX);
            e.preventDefault();
        }
        
        /**
         * Eventos de movimento durante o toque
         */
        handleTouchMove(e) {
            if (!this.isDragging) return;
            
            const currentPosition = e.touches[0].clientX;
            this.drag(currentPosition);
            e.preventDefault();
        }
        
        /**
         * Eventos de fim de toque
         */
        handleTouchEnd() {
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
        handleMouseUp() {
            this.endDrag();
        }
        
        /**
         * Evento de scroll
         */
        handleScroll() {
            clearTimeout(this.scrollTimeout);
            
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
            
            this.track.style.scrollBehavior = 'auto';
            this.track.classList.add('dragging');
            
            this.items.forEach(item => {
                item.style.transition = 'none';
            });
        }
        
        /**
         * Continuação do arrastar
         */
        drag(position) {
            if (!this.isDragging) return;
            
            const delta = this.startPosition - position;
            const dragAmount = delta * this.options.dragResistance;
            
            this.track.scrollLeft = this.startScrollLeft + dragAmount;
            
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
            
            this.track.style.scrollBehavior = 'smooth';
            this.track.classList.remove('dragging');
            
            this.items.forEach(item => {
                item.style.transition = '';
            });
            
            const delta = this.startPosition - this.lastPosition;
            
            if (this.options.momentum && Math.abs(this.velocityX) > 0.1) {
                this.applyMomentum();
            } else if (this.options.snapToItem && Math.abs(delta) > this.options.threshold) {
                this.snapToNearestItem(delta > 0);
            }
            
            this.updateButtonVisibility();
        }
        
        /**
         * Aplicar efeito de inércia/momentum
         */
        applyMomentum() {
            this.cancelMomentum();
            
            this.momentum = {
                value: this.velocityX * 120,
                active: true
            };
            
            this.animateMomentum();
        }
        
        /**
         * Anima o efeito de inércia
         */
        animateMomentum() {
            if (!this.momentum.active) return;
            
            this.track.scrollLeft -= this.momentum.value;
            this.momentum.value *= 0.96;
            
            if (Math.abs(this.momentum.value) > 0.5) {
                this.rafId = requestAnimationFrame(this.animateMomentum.bind(this));
            } else {
                this.cancelMomentum();
                
                if (this.options.snapToItem) {
                    setTimeout(() => {
                        this.snapToNearestItem(this.momentum.value < 0);
                    }, 50);
                }
            }
        }
        
        /**
         * Cancela qualquer animação de inércia
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
            if (!this.track || !this.items || this.items.length === 0) return;
            
            const trackRect = this.track.getBoundingClientRect();
            const currentScrollLeft = this.track.scrollLeft;
            
            const viewportCenter = trackRect.width / 2;
            
            try {
                const snapPoints = this.items.map(item => {
                    const itemRect = item.getBoundingClientRect();
                    const itemCenter = itemRect.left - trackRect.left + (itemRect.width / 2) + currentScrollLeft;
                    const distance = Math.abs(itemCenter - viewportCenter - currentScrollLeft);
                    return { position: itemCenter - viewportCenter, distance };
                });
                
                const endPoint = { 
                    position: this.track.scrollWidth - this.track.clientWidth, 
                    distance: Math.abs((this.track.scrollWidth - this.track.clientWidth) - currentScrollLeft) 
                };
                snapPoints.push(endPoint);
                
                const startPoint = { position: 0, distance: currentScrollLeft };
                snapPoints.unshift(startPoint);
                
                let targetScrollLeft;
                
                if (isMovingForward) {
                    const forwardPoints = snapPoints.filter(point => point.position > currentScrollLeft + 5);
                    
                    if (forwardPoints.length > 0) {
                        targetScrollLeft = forwardPoints.sort((a, b) => a.distance - b.distance)[0].position;
                    } else {
                        targetScrollLeft = endPoint.position;
                    }
                } else {
                    const backwardPoints = snapPoints.filter(point => point.position < currentScrollLeft - 5);
                    
                    if (backwardPoints.length > 0) {
                        targetScrollLeft = backwardPoints.sort((a, b) => a.distance - b.distance)[0].position;
                    } else {
                        targetScrollLeft = startPoint.position;
                    }
                }
                
                this.track.style.scrollBehavior = 'smooth';
                
                const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
                
                if (isIOS) {
                    const startPosition = this.track.scrollLeft;
                    const distance = targetScrollLeft - startPosition;
                    const duration = 500;
                    const startTime = Date.now();
                    
                    const animateScroll = () => {
                        const elapsed = Date.now() - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        
                        const easeOutCubic = progress => 1 - Math.pow(1 - progress, 3);
                        const easedProgress = easeOutCubic(progress);
                        
                        this.track.scrollLeft = startPosition + (distance * easedProgress);
                        
                        if (progress < 1) {
                            requestAnimationFrame(animateScroll);
                        }
                    };
                    
                    requestAnimationFrame(animateScroll);
                } else {
                    this.track.scrollLeft = targetScrollLeft;
                }
            } catch (error) {
                console.error("Erro ao calcular snap:", error);
            }
        }
        
        /**
         * Manipulador de clique no botão anterior
         */
        handlePrevClick() {
            this.cancelMomentum();
            
            // Se não houver itens, não faz nada
            if (!this.items || this.items.length === 0) return;
            
            const itemWidth = this.items[0] ? this.items[0].offsetWidth : 300;
            const scrollAmount = Math.min(this.track.clientWidth, itemWidth + 24);
            
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
            
            // Se não houver itens, não faz nada
            if (!this.items || this.items.length === 0) return;
            
            const itemWidth = this.items[0] ? this.items[0].offsetWidth : 300;
            const scrollAmount = Math.min(this.track.clientWidth, itemWidth + 24);
            
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

    /**
     * Classe específica para o Hero Carousel
     * Estende a funcionalidade básica do TouchCarousel
     */
    class HeroCarousel {
        constructor() {
            this.container = document.querySelector('.hero');
            this.slidesContainer = document.querySelector('.hero-slides');
            this.slides = this.slidesContainer ? this.slidesContainer.querySelectorAll('.hero-slide') : [];
            this.content = document.querySelector('.hero-content');
            
            if (!this.container || !this.slidesContainer || this.slides.length === 0) {
                console.warn('Elementos necessários para o Hero Carousel não encontrados');
                return;
            }
            
            // Estado
            this.currentSlideIndex = 0;
            this.isTransitioning = false;
            this.autoplayInterval = null;
            this.touchStartX = 0;
            this.touchEndX = 0;
            
            // Inicialização
            this.initialize();
        }
        
        /**
         * Inicializa o carrossel Hero
         */
        initialize() {
            // Verificar se os indicadores já existem
            let indicatorsContainer = this.container.querySelector('.hero-indicators');
            
            // Criar indicadores se não existirem
            if (!indicatorsContainer) {
                this.createIndicators();
            } else {
                // Se existirem, garantir que tenham os handlers corretos
                const indicators = indicatorsContainer.querySelectorAll('.indicator');
                indicators.forEach((indicator, index) => {
                    indicator.addEventListener('click', () => {
                        if (!this.isTransitioning && this.currentSlideIndex !== index) {
                            this.changeSlide(index);
                        }
                    });
                });
            }
            
            // Adicionar eventos de toque
            this.slidesContainer.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: false });
            this.slidesContainer.addEventListener('touchmove', this.handleTouchMove.bind(this), { passive: false });
            this.slidesContainer.addEventListener('touchend', this.handleTouchEnd.bind(this));
            
            // Iniciar autoplay
            this.startAutoplay();
            
            // Pausar autoplay quando a página não estiver visível
            document.addEventListener('visibilitychange', () => {
                if (document.hidden) {
                    this.stopAutoplay();
                } else {
                    this.startAutoplay();
                }
            });
        }
        
        /**
         * Cria os indicadores do carrossel
         */
        createIndicators() {
            if (this.slides.length <= 1) return; // Não criar indicadores se houver apenas um slide
            
            const indicatorsContainer = document.createElement('div');
            indicatorsContainer.className = 'hero-indicators';
            
            this.slides.forEach((slide, index) => {
                const indicator = document.createElement('div');
                indicator.className = `indicator ${index === 0 ? 'active' : ''}`;
                indicator.addEventListener('click', () => {
                    if (!this.isTransitioning && this.currentSlideIndex !== index) {
                        this.changeSlide(index);
                    }
                });
                indicatorsContainer.appendChild(indicator);
            });
            
            this.container.appendChild(indicatorsContainer);
        }
        
        /**
         * Manipulador de início de toque
         */
        handleTouchStart(e) {
            this.touchStartX = e.touches[0].clientX;
            e.preventDefault();
        }
        
        /**
         * Manipulador de movimento de toque
         */
        handleTouchMove(e) {
            this.touchEndX = e.touches[0].clientX;
            e.preventDefault();
        }
        
        /**
         * Manipulador de fim de toque
         */
        handleTouchEnd() {
            const threshold = 100;
            const touchDiff = this.touchStartX - this.touchEndX;
            
            if (Math.abs(touchDiff) > threshold) {
                if (touchDiff > 0) {
                    // Swipe para esquerda - próximo slide
                    const nextIndex = (this.currentSlideIndex + 1) % this.slides.length;
                    this.changeSlide(nextIndex);
                } else {
                    // Swipe para direita - slide anterior
                    const prevIndex = (this.currentSlideIndex - 1 + this.slides.length) % this.slides.length;
                    this.changeSlide(prevIndex);
                }
            }
        }
        
        /**
         * Atualiza o conteúdo do carrossel
         */
        updateHeroContent(slide) {
            if (!this.content) return;
            
            this.content.classList.add('transitioning');
            
            setTimeout(() => {
                const dateElement = this.content.querySelector('.date');
                const titleElement = this.content.querySelector('h1');
                const descriptionElement = this.content.querySelector('.hero-description');
                const ctaButton = this.content.querySelector('.btn-primary');
                
                // Obter dados do slide
                const title = slide.getAttribute('data-title');
                const description = slide.getAttribute('data-description');
                const date = slide.getAttribute('data-date');
                const ctaText = slide.getAttribute('data-cta-text');
                const ctaLink = slide.getAttribute('data-cta-link');
                
                if (dateElement && date) dateElement.textContent = date;
                if (titleElement && title) titleElement.textContent = title;
                if (descriptionElement && description) descriptionElement.textContent = description;
                
                if (ctaButton && ctaText) {
                    // Atualizar texto do botão mantendo o ícone
                    const icon = ctaButton.querySelector('i');
                    if (icon) {
                        ctaButton.innerHTML = '';
                        ctaButton.appendChild(icon);
                        ctaButton.appendChild(document.createTextNode(' ' + ctaText));
                    } else {
                        ctaButton.textContent = ctaText;
                    }
                    
                    // Atualizar data attributes para o modal
                    ctaButton.setAttribute('data-video-id', slide.getAttribute('data-video-id') || '');
                    ctaButton.setAttribute('data-title', title || '');
                    ctaButton.setAttribute('data-thumbnail', slide.getAttribute('data-thumbnail') || '');
                }
                
                this.content.classList.remove('transitioning');
            }, 500);
        }
        
        /**
         * Altera o slide ativo
         */
        changeSlide(newIndex) {
            if (this.isTransitioning) return;
            this.isTransitioning = true;
            
            const slides = this.slides;
            const indicators = document.querySelectorAll('.indicator');
            
            if (slides.length === 0 || indicators.length === 0) {
                this.isTransitioning = false;
                return;
            }
            
            // Atualizar slides
            slides[this.currentSlideIndex].classList.remove('active');
            slides[newIndex].classList.add('active');
            
            // Atualizar indicadores
            indicators[this.currentSlideIndex].classList.remove('active');
            indicators[newIndex].classList.add('active');
            
            // Atualizar conteúdo
            this.updateHeroContent(slides[newIndex]);
            
            this.currentSlideIndex = newIndex;
            
            // Restaurar transição após animação completa
            setTimeout(() => {
                this.isTransitioning = false;
            }, 1000);
        }
        
        /**
         * Inicia autoplay
         */
        startAutoplay() {
            if (this.slides.length <= 1) return; // Não iniciar autoplay com apenas um slide
            
            this.stopAutoplay();
            this.autoplayInterval = setInterval(() => {
                const nextIndex = (this.currentSlideIndex + 1) % this.slides.length;
                this.changeSlide(nextIndex);
            }, 5000);
        }
        
        /**
         * Para autoplay
         */
        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
        }
    }

    // Inicialização após carregamento do DOM
    function initCarousels() {
        console.log("Inicializando carrosséis unificados...");
        
        // Verificar elementos necessários
        if (!checkElementsExist()) {
            console.warn("Elementos necessários não foram encontrados, verificando parcialmente...");
        }
        
        // Inicializar Hero Carousel se existir
        if (document.querySelector('.hero')) {
            console.log("Inicializando Hero Carousel");
            const heroCarousel = new HeroCarousel();
        }
        
        // Inicializar carrosséis de conteúdo
        const contentContainers = document.querySelectorAll('.continue-watching .section-container, .featured-content .section-container');
        if (contentContainers.length > 0) {
            console.log(`Inicializando ${contentContainers.length} carrosséis de conteúdo`);
            const contentCarousels = Array.from(contentContainers).map(container => {
                return new TouchCarousel(container);
            });
        }
        
        // Inicializar carrosséis de atores
        const actorContainers = document.querySelectorAll('.featured-actors .section-container');
        if (actorContainers.length > 0) {
            console.log(`Inicializando ${actorContainers.length} carrosséis de atores`);
            const actorCarousels = Array.from(actorContainers).map(container => {
                return new TouchCarousel(container);
            });
        }
        
        // Inicializar carrosséis de criadores
        const creatorContainers = document.querySelectorAll('.trending-creators .section-container');
        if (creatorContainers.length > 0) {
            console.log(`Inicializando ${creatorContainers.length} carrosséis de criadores`);
            const creatorCarousels = Array.from(creatorContainers).map(container => {
                return new TouchCarousel(container, {
                    slideSelector: '.creators-carousel',
                    itemSelector: '.creator-card-premium'
                });
            });
        }
        
        // Aplicar tratamento de imagens quebradas
        applyBrokenImageHandling();
        
        // Adicionar observer para tratar imagens adicionadas dinamicamente
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    const hasNewImages = Array.from(mutation.addedNodes).some(node => 
                        node.nodeName === 'IMG' || 
                        (node.nodeType === 1 && node.querySelector('img'))
                    );
                    
                    if (hasNewImages) {
                        applyBrokenImageHandling();
                    }
                }
            });
        });
        
        // Observar mudanças no DOM
        const carouselContainers = document.querySelectorAll('.content-grid, .actors-carousel, .creators-carousel, .creators-grid');
        carouselContainers.forEach(container => {
            if (container) {
                observer.observe(container, { childList: true, subtree: true });
            }
        });
        
        // Força recarregamento de imagens que podem estar com erro
        document.querySelectorAll('img[src^="https://server2.hotboys.com.br/arquivos/"]').forEach(img => {
            // Aplicar tratamento de fallback imediatamente
            const isExclusive = img.closest('#exclusive .content-card') !== null;
            handleBrokenCarouselImages(img, '/images/placeholder-content.jpg', isExclusive);
        });
        
        // Recalcular em redimensionamento
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                // Recalcular todas as instâncias de TouchCarousel 
                document.querySelectorAll('.section-container').forEach(container => {
                    const trackSelector = '.content-grid, .actors-carousel, .creators-carousel';
                    const track = container.querySelector(trackSelector);
                    
                    if (track) {
                        // Criar uma nova instância para recalcular
                        new TouchCarousel(container);
                    }
                });
                
                // Verificar novamente as imagens
                applyBrokenImageHandling();
            }, 300);
        });
    }

    // Iniciar todos os carrosséis
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initCarousels, 1);
    } else {
        initCarousels(); // O DOMContentLoaded já foi disparado antes deste ponto
    }
});