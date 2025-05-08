/**
 * Gerenciador de Carrosséis - HotBoys
 * Sistema unificado de inicialização e gerenciamento de carrosséis
 * 
 * @version 1.0.1
 * @date 2023-07-15
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
        
        const contentGrid = carousel.querySelector('.content-grid');
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
        
        const contentGrid = carousel.querySelector('.content-grid');
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
        
        const actorsGrid = carousel.querySelector('.actors-carousel');
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
    const creatorCarousels = document.querySelectorAll('.trending-creators');
    console.log(`Encontrados ${creatorCarousels.length} carrosséis de criadores`);
    
    creatorCarousels.forEach((carousel, index) => {
        const carouselId = `traditional-creator-${index}`;
        console.log(`Inicializando carrossel de criadores: ${carouselId}`);
        
        const creatorGrid = carousel.querySelector('.creators-carousel');
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
    
    const slides = heroSection.querySelectorAll('.hero-slide');
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
    // Configurar botões de navegação
    prevBtn.addEventListener('click', () => {
        track.scrollBy({
            left: -track.offsetWidth * 0.8,
            behavior: 'smooth'
        });
    });
    
    nextBtn.addEventListener('click', () => {
        track.scrollBy({
            left: track.offsetWidth * 0.8,
            behavior: 'smooth'
        });
    });
    
    // Atualizar visibilidade dos botões
    function updateButtonVisibility() {
        const isAtStart = track.scrollLeft < 10;
        const isAtEnd = track.scrollLeft >= track.scrollWidth - track.offsetWidth - 10;
        
        prevBtn.classList.toggle('disabled', isAtStart);
        nextBtn.classList.toggle('disabled', isAtEnd);
    }
    
    // Inicializar estado dos botões
    updateButtonVisibility();
    
    // Atualizar estado dos botões durante o scroll
    track.addEventListener('scroll', updateButtonVisibility);
    
    // Verificar também ao redimensionar a janela
    window.addEventListener('resize', updateButtonVisibility);
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