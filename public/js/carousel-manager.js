/**
 * Gerenciador de Carrosséis - HotBoys
 * Sistema unificado de inicialização e gerenciamento de carrosséis
 * 
 * @version 1.0.1
 * @date 2023-07-1    const creatorCarousels = document.querySelectorAll('.hb-trending-creators');
 */

// Armazenar todas as instâncias de carrossel para gerenciamento global
const carouselInstances = {
    hero: null,
    content: [],
    actors: [],
    creators: []
};

/**
 * Inicializa todos os carrosséis quando o DOM estiver pronto
 */
document.addEventListener('DOMContentLoaded', () => {
    console.log('Inicializando gerenciador de carrosséis...');
    
    // Inicializar carrosséis com IDs únicos (novos componentes)
    initializeUniqueCarousels();
    
    // Inicializar carrosséis tradicionais (legados)
    initializeTraditionalCarousels();
    
    // Verificar se há conflitos de inicialização
    checkForConflicts();
});

/**
 * Inicializa os carrosséis com IDs únicos (novos componentes)
 */
function initializeUniqueCarousels() {
    // Buscar todos os carrosséis com IDs únicos
    const uniqueCarousels = document.querySelectorAll('.continue-watching[id^="carousel-"]');
    console.log(`Encontrados ${uniqueCarousels.length} carrosséis com IDs únicos`);
      uniqueCarousels.forEach(carousel => {
        const carouselId = carousel.id;
        console.log(`Inicializando carrossel único: ${carouselId}`);
        
        const contentGrid = carousel.querySelector('.hb-content-grid');
        const prevBtn = carousel.querySelector('.nav-btn.prev');
        const nextBtn = carousel.querySelector('.nav-btn.next');
        
        if (!contentGrid || !prevBtn || !nextBtn) {
            console.warn(`Carrossel ${carouselId} não tem todos os elementos necessários`);
            return;
        }
        
        // Configurar navegação
        setupNavigation(contentGrid, prevBtn, nextBtn);
        
        // Armazenar instância para referência
        carouselInstances.content.push({
            id: carouselId,
            element: carousel,
            track: contentGrid
        });
    });
}

/**
 * Inicializa carrosséis tradicionais (sem IDs únicos)
 */
function initializeTraditionalCarousels() {
    // Inicializar carrosséis de conteúdo tradicionais
    initializeContentCarousels();
    
    // Inicializar carrosséis de atores
    initializeActorCarousels();
    
    // Inicializar carrosséis de criadores
    initializeCreatorCarousels();
    
    // Inicializar hero carrossel
    initializeHeroCarousel();
}

/**
 * Inicializa carrosséis de conteúdo tradicionais
 */
function initializeContentCarousels() {
    // Seletor que exclui os carrosséis com IDs únicos
    const contentCarousels = document.querySelectorAll('.continue-watching:not([id^="carousel-"]), .featured-content');
    console.log(`Encontrados ${contentCarousels.length} carrosséis de conteúdo tradicionais`);
      contentCarousels.forEach((carousel, index) => {
        // Criar um ID simulado para facilitar tracking
        const carouselId = `traditional-content-${index}`;
        console.log(`Inicializando carrossel de conteúdo tradicional: ${carouselId}`);
        
        const contentGrid = carousel.querySelector('.hb-content-grid');
        const prevBtn = carousel.querySelector('.nav-btn.prev');
        const nextBtn = carousel.querySelector('.nav-btn.next');
        
        if (!contentGrid || !prevBtn || !nextBtn) {
            console.warn(`Carrossel ${carouselId} não tem todos os elementos necessários`);
            return;
        }
        
        // Marcar como inicializado para evitar duplicação
        contentGrid.setAttribute('data-initialized', 'true');
        
        // Configurar navegação
        setupNavigation(contentGrid, prevBtn, nextBtn);
        
        // Armazenar instância para referência
        carouselInstances.content.push({
            id: carouselId,
            element: carousel,
            track: contentGrid
        });
    });
}

/**
 * Inicializa carrosséis de atores
 */
function initializeActorCarousels() {
    const actorCarousels = document.querySelectorAll('.featured-actors');
    console.log(`Encontrados ${actorCarousels.length} carrosséis de atores`);
    
    actorCarousels.forEach((carousel, index) => {
        const carouselId = `traditional-actor-${index}`;
        console.log(`Inicializando carrossel de atores: ${carouselId}`);
        
        const actorsGrid = carousel.querySelector('.hb-actors-carousel');
        const prevBtn = carousel.querySelector('.nav-btn.prev');
        const nextBtn = carousel.querySelector('.nav-btn.next');
        
        if (!actorsGrid || !prevBtn || !nextBtn) {
            console.warn(`Carrossel de atores ${carouselId} não tem todos os elementos necessários`);
            return;
        }
        
        // Marcar como inicializado para evitar duplicação
        actorsGrid.setAttribute('data-initialized', 'true');
        
        // Configurar navegação
        setupNavigation(actorsGrid, prevBtn, nextBtn);
        
        // Armazenar instância para referência
        carouselInstances.actors.push({
            id: carouselId,
            element: carousel,
            track: actorsGrid
        });
    });
}

/**
 * Inicializa carrosséis de criadores
 */
function initializeCreatorCarousels() {
    const creatorCarousels = document.querySelectorAll('.hb-trending-creators');
    console.log(`Encontrados ${creatorCarousels.length} carrosséis de criadores`);
    
    creatorCarousels.forEach((carousel, index) => {
        const carouselId = `traditional-creator-${index}`;
        console.log(`Inicializando carrossel de criadores: ${carouselId}`);
        
        const creatorGrid = carousel.querySelector('.hb-creators-carousel');
        const prevBtn = carousel.querySelector('.nav-btn.prev');
        const nextBtn = carousel.querySelector('.nav-btn.next');
        
        if (!creatorGrid || !prevBtn || !nextBtn) {
            console.warn(`Carrossel de criadores ${carouselId} não tem todos os elementos necessários`);
            return;
        }
        
        // Marcar como inicializado para evitar duplicação
        creatorGrid.setAttribute('data-initialized', 'true');
        
        // Configurar navegação
        setupNavigation(creatorGrid, prevBtn, nextBtn);
        
        // Armazenar instância para referência
        carouselInstances.creators.push({
            id: carouselId,
            element: carousel,
            track: creatorGrid
        });
    });
}

/**
 * Inicializa o carrossel principal (hero)
 */
function initializeHeroCarousel() {
    const heroSection = document.querySelector('.hero');
    if (!heroSection) {
        console.log('Hero carrossel não encontrado');
        return;
    }
    
    console.log('Inicializando hero carrossel');
    
    const slides = heroSection.querySelectorAll('.hb-hero-slide');
    const indicators = heroSection.querySelectorAll('.indicator');
    
    if (!slides.length) {
        console.warn('Hero carrossel não tem slides');
        return;
    }
    
    // Implementação básica de carrossel para o hero
    let currentIndex = 0;
    let autoplayInterval;
    
    function goToSlide(index) {
        // Remover classes ativas
        slides[currentIndex].classList.remove('active');
        indicators[currentIndex]?.classList.remove('active');
        
        // Adicionar classes ativas
        slides[index].classList.add('active');
        indicators[index]?.classList.add('active');
        
        // Atualizar conteúdo
        updateHeroContent(slides[index]);
        
        // Salvar índice atual
        currentIndex = index;
    }
    
    function updateHeroContent(slide) {
        const title = slide.getAttribute('data-title');
        const description = slide.getAttribute('data-description');
        const date = slide.getAttribute('data-date');
        
        const titleEl = heroSection.querySelector('.hero-content h1');
        const descEl = heroSection.querySelector('.hero-content .hero-description');
        const dateEl = heroSection.querySelector('.hero-content .date');
        
        if (titleEl && title) titleEl.textContent = title;
        if (descEl && description) descEl.textContent = description;
        if (dateEl && date) dateEl.textContent = date;
    }
    
    // Configurar indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            clearInterval(autoplayInterval);
            goToSlide(index);
            startAutoplay();
        });
    });
    
    // Iniciar autoplay
    function startAutoplay() {
        autoplayInterval = setInterval(() => {
            goToSlide((currentIndex + 1) % slides.length);
        }, 6000);
    }
    
    // Iniciar carrossel
    startAutoplay();
    
    // Armazenar instância para referência
    carouselInstances.hero = {
        element: heroSection,
        slides,
        indicators,
        currentIndex,
        goToSlide,
        startAutoplay
    };
}

/**
 * Configura a navegação de um carrossel
 */
function setupNavigation(track, prevBtn, nextBtn) {
    // Configuração de velocidade e comportamento do scroll
    const scrollConfig = {
        behavior: 'smooth',
        easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
    };
    
    // Variáveis para controle de deslizamento
    let isScrolling = false;
    let scrollTimeout;
    let itemWidth = 0;
    let visibleItems = 0;
    
    // Calcular quantos itens são visíveis e o tamanho do scroll
    function calculateScrollMetrics() {
        const trackWidth = track.offsetWidth;
        const items = track.querySelectorAll('.hb-content-card, .hb-actor-card, .creator-card-premium');
        
        if (items.length === 0) return;
        
        // Calcular largura média dos itens
        itemWidth = items[0].offsetWidth + parseInt(getComputedStyle(items[0]).marginRight || 0);
        
        // Calcular quantos itens cabem na viewport
        visibleItems = Math.floor(trackWidth / itemWidth);
        
        // Garantir pelo menos 1 item
        visibleItems = Math.max(1, visibleItems);
    }
    
    // Calcular métricas iniciais
    calculateScrollMetrics();
    
    // Recalcular quando a janela for redimensionada
    window.addEventListener('resize', calculateScrollMetrics);
    
    // Configurar botões de navegação com animação suave
    prevBtn.addEventListener('click', () => {
        if (isScrolling) return;
        isScrolling = true;
        
        // Calcular a quantidade de scroll baseada na viewport
        const scrollDistance = Math.max(itemWidth * Math.floor(visibleItems * 0.8), itemWidth);
        
        // Aplicar scroll com animação
        smoothScrollBy(track, -scrollDistance);
        
        // Atualizar botões após a transição
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            updateButtonVisibility();
            isScrolling = false;
        }, 500);
    });
    
    nextBtn.addEventListener('click', () => {
        if (isScrolling) return;
        isScrolling = true;
        
        // Calcular a quantidade de scroll baseada na viewport
        const scrollDistance = Math.max(itemWidth * Math.floor(visibleItems * 0.8), itemWidth);
        
        // Aplicar scroll com animação
        smoothScrollBy(track, scrollDistance);
        
        // Atualizar botões após a transição
        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(() => {
            updateButtonVisibility();
            isScrolling = false;
        }, 500);
    });
    
    // Função para rolagem suave com inércia
    function smoothScrollBy(element, distance) {
        const startPosition = element.scrollLeft;
        const startTime = performance.now();
        const duration = 500;
        
        // Função de animação para scroll com efeito de inércia
        function scrollAnimation(currentTime) {
            const elapsedTime = currentTime - startTime;
            
            if (elapsedTime < duration) {
                // Calcular nova posição com easing
                const easingFactor = easeOutQuart(elapsedTime / duration);
                element.scrollLeft = startPosition + (distance * easingFactor);
                requestAnimationFrame(scrollAnimation);
            } else {
                // Finalizar no destino exato
                element.scrollLeft = startPosition + distance;
                isScrolling = false;
                updateButtonVisibility();
            }
        }
        
        // Iniciar animação
        requestAnimationFrame(scrollAnimation);
    }
    
    // Função de easing para animação suave
    function easeOutQuart(t) {
        return 1 - Math.pow(1 - t, 4);
    }
    
    // Implementar scroll por arrastar (drag to scroll)
    let isDragging = false;
    let startX, startScrollLeft;
    
    // Eventos de toque
    track.addEventListener('touchstart', handleDragStart, { passive: true });
    track.addEventListener('touchmove', handleDragMove, { passive: false });
    track.addEventListener('touchend', handleDragEnd);
    
    // Eventos de mouse
    track.addEventListener('mousedown', handleDragStart);
    track.addEventListener('mousemove', handleDragMove);
    track.addEventListener('mouseup', handleDragEnd);
    track.addEventListener('mouseleave', handleDragEnd);
    
    function handleDragStart(e) {
        isDragging = true;
        track.classList.add('dragging');
        startX = e.pageX || e.touches[0].pageX;
        startScrollLeft = track.scrollLeft;
        
        // Parar momentum scroll em andamento
        cancelAnimationFrame(track.scrollRAF);
    }
    
    function handleDragMove(e) {
        if (!isDragging) return;
        
        e.preventDefault();
        const x = e.pageX || e.touches[0].pageX;
        const dragDistance = x - startX;
        
        // Aplicar movimento com um pouco de resistência para sensação tátil
        track.scrollLeft = startScrollLeft - dragDistance;
        
        // Atualizar estado dos botões durante o arrasto
        updateButtonVisibility();
    }
    
    function handleDragEnd() {
        if (!isDragging) return;
        
        isDragging = false;
        track.classList.remove('dragging');
        
        // Implementar efeito de inércia após soltar
        const endTime = performance.now();
        const endScrollLeft = track.scrollLeft;
        
        // Calcular velocidade e aplicar momentum
        const velocity = (endScrollLeft - startScrollLeft) * 0.5;
        
        if (Math.abs(velocity) > 10) {
            applyMomentum(track, velocity);
        }
    }
    
    // Aplicar inércia (momentum) após arrastamento
    function applyMomentum(element, velocity) {
        let currentVelocity = velocity;
        const friction = 0.92; // Ajuste para mais ou menos inércia
        
        function momentumStep() {
            if (Math.abs(currentVelocity) > 0.5) {
                element.scrollLeft += currentVelocity;
                currentVelocity *= friction;
                element.scrollRAF = requestAnimationFrame(momentumStep);
            } else {
                // Verificar se precisamos snap para um item
                snapToNearestItem();
                updateButtonVisibility();
            }
        }
        
        cancelAnimationFrame(element.scrollRAF);
        element.scrollRAF = requestAnimationFrame(momentumStep);
    }
    
    // Função para snap para o item mais próximo
    function snapToNearestItem() {
        // Evitar snap automático em dispositivos móveis
        if (window.innerWidth < 768) return;
        
        const itemWidth = track.querySelector('.hb-content-card, .hb-actor-card, .creator-card-premium')?.offsetWidth || 0;
        if (!itemWidth) return;
        
        const currentPosition = track.scrollLeft;
        const nearestItemIndex = Math.round(currentPosition / itemWidth);
        const targetPosition = nearestItemIndex * itemWidth;
        
        // Só fazer snap se a diferença for significativa
        if (Math.abs(currentPosition - targetPosition) > itemWidth * 0.2) {
            smoothScrollBy(track, targetPosition - currentPosition);
        }
    }
    
    // Atualizar visibilidade dos botões
    function updateButtonVisibility() {
        const isAtStart = track.scrollLeft < 10;
        const isAtEnd = track.scrollLeft >= track.scrollWidth - track.offsetWidth - 10;
        
        prevBtn.classList.toggle('disabled', isAtStart);
        nextBtn.classList.toggle('disabled', isAtEnd);
        
        // Aplica classes de transição para fade in/out suave
        if (isAtStart) {
            prevBtn.classList.add('btn-fade-out');
        } else {
            prevBtn.classList.remove('btn-fade-out');
        }
        
        if (isAtEnd) {
            nextBtn.classList.add('btn-fade-out');
        } else {
            nextBtn.classList.remove('btn-fade-out');
        }
    }
    
    // Inicializar estado dos botões
    updateButtonVisibility();
    
    // Atualizar estado dos botões durante o scroll
    track.addEventListener('scroll', () => {
        // Usar debounce para melhorar performance
        clearTimeout(track.scrollTimeout);
        track.scrollTimeout = setTimeout(updateButtonVisibility, 100);
    });
}

/**
 * Verifica se há conflitos de inicialização com outros scripts
 */
function checkForConflicts() {
    // Verificar se window.carouselInitialized já existe (definido por outros scripts)
    if (window.carouselInitialized) {
        console.warn('CONFLITO: Outros scripts já inicializaram carrosséis nesta página.');
        return;
    }
    
    // Marcar como inicializado
    window.carouselInitialized = true;
}

/**
 * Recalcula todos os carrosséis quando a janela é redimensionada
 */
window.addEventListener('resize', () => {
    // Debounce para evitar múltiplas chamadas
    clearTimeout(window.carouselResizeTimer);
    window.carouselResizeTimer = setTimeout(() => {
        console.log('Recalculando carrosséis após redimensionamento');
        
        // Recalcular cada instância
        const allTrackInstances = [
            ...carouselInstances.content,
            ...carouselInstances.actors,
            ...carouselInstances.creators
        ];
        
        allTrackInstances.forEach(instance => {
            const track = instance.track;
            const prevBtn = instance.element.querySelector('.nav-btn.prev');
            const nextBtn = instance.element.querySelector('.nav-btn.next');
            
            if (track && prevBtn && nextBtn) {
                // Atualizar visibilidade dos botões
                const isAtStart = track.scrollLeft < 10;
                const isAtEnd = track.scrollLeft >= track.scrollWidth - track.offsetWidth - 10;
                
                prevBtn.classList.toggle('disabled', isAtStart);
                nextBtn.classList.toggle('disabled', isAtEnd);
            }
        });
    }, 300);
}); 