/**
 * Script específico para corrigir o carrossel de hero
 */
document.addEventListener('DOMContentLoaded', function() {
    // Elementos do carrossel
    const heroSection = document.querySelector('.hero');
    const slides = document.querySelectorAll('.hb-hero-slide');
    
    // Se não encontrar elementos ou houver apenas um slide, não fazer nada
    if (!heroSection || slides.length <= 1) return;
    
    console.log('Hero carrossel inicializado com', slides.length, 'slides');
    
    // Estado do carrossel
    let currentIndex = 0;
    let autoplayInterval;
    let isTransitioning = false;
    
    // Criar indicadores se não existirem
    let indicators = heroSection.querySelectorAll('.hero-indicator');
    if (indicators.length === 0) {
        // Criar container de indicadores
        const indicatorsContainer = document.createElement('div');
        indicatorsContainer.className = 'hero-indicators';
        
        // Adicionar um indicador para cada slide
        for (let i = 0; i < slides.length; i++) {
            const indicator = document.createElement('div');
            indicator.className = 'hero-indicator' + (i === 0 ? ' active' : '');
            indicator.dataset.index = i;
            indicatorsContainer.appendChild(indicator);
        }
        
        // Adicionar indicadores ao hero
        heroSection.appendChild(indicatorsContainer);
        
        // Atualizar referência aos indicadores
        indicators = heroSection.querySelectorAll('.hero-indicator');
    }
    
    // Função para trocar slides
    function goToSlide(index) {
        if (isTransitioning || index === currentIndex) return;
        isTransitioning = true;
        
        console.log('Trocando para slide', index);
        
        // Remover classe active do slide atual
        slides[currentIndex].classList.remove('active');
        indicators[currentIndex].classList.remove('active');
        
        // Adicionar classe active ao novo slide
        slides[index].classList.add('active');
        indicators[index].classList.add('active');
        
        // Atualizar textos do hero
        updateHeroContent(slides[index]);
        
        // Atualizar índice atual
        currentIndex = index;
        
        // Desbloquear transição após animação
        setTimeout(() => {
            isTransitioning = false;
        }, 1000); // mesmo tempo da transição CSS
    }
    
    // Função para atualizar conteúdo do hero
    function updateHeroContent(slide) {
        // Obter dados do slide
        const title = slide.getAttribute('data-title');
        const description = slide.getAttribute('data-description');
        const date = slide.getAttribute('data-date');
        
        // Atualizar elementos
        const titleElement = heroSection.querySelector('h1');
        const descriptionElement = heroSection.querySelector('.hero-description');
        const dateElement = heroSection.querySelector('.date');
        
        if (titleElement) titleElement.textContent = title;
        if (descriptionElement) descriptionElement.textContent = description;
        if (dateElement) dateElement.textContent = date;
    }
    
    // Função para ir para o próximo slide
    function nextSlide() {
        goToSlide((currentIndex + 1) % slides.length);
    }
    
    // Função para ir para o slide anterior
    function prevSlide() {
        goToSlide((currentIndex - 1 + slides.length) % slides.length);
    }
    
    // Iniciar autoplay
    function startAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
        }
        autoplayInterval = setInterval(nextSlide, 5000); // trocar a cada 5 segundos
    }
    
    // Parar autoplay
    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
            autoplayInterval = null;
        }
    }
    
    // Adicionar eventos aos indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', function() {
            goToSlide(index);
            stopAutoplay();
            startAutoplay(); // reiniciar o autoplay após navegação manual
        });
    });
    
    // Adicionar suporte para toque
    let touchStartX = 0;
    let touchEndX = 0;
    
    heroSection.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
    }, { passive: true });
    
    heroSection.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].clientX;
        handleSwipe();
    }, { passive: true });
    
    function handleSwipe() {
        const threshold = 50; // distância mínima para considerar como swipe
        
        if (touchStartX - touchEndX > threshold) {
            // Swipe para esquerda
            nextSlide();
        } else if (touchEndX - touchStartX > threshold) {
            // Swipe para direita
            prevSlide();
        }
        
        // Reiniciar autoplay após interação
        stopAutoplay();
        startAutoplay();
    }
    
    // Parar autoplay quando a página não estiver visível
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoplay();
        } else {
            startAutoplay();
        }
    });
    
    // Iniciar autoplay
    startAutoplay();
    
    // Expor funções para debug no console
    window.heroCarousel = {
        next: nextSlide,
        prev: prevSlide,
        goTo: goToSlide
    };
});