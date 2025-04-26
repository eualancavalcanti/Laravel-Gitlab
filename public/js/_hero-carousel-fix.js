document.addEventListener('DOMContentLoaded', function() {
    // Elementos do carrossel
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.hero-indicators .indicator');
    
    if (slides.length <= 1) return; // Se houver apenas um slide, não precisa fazer nada
    
    let currentIndex = 0;
    let interval;
    
    // Função para trocar para um slide específico
    function goToSlide(index) {
        // Remover classes ativas do slide atual
        slides[currentIndex].classList.remove('active');
        if (indicators.length > 0) {
            indicators[currentIndex].classList.remove('active');
        }
        
        // Adicionar classes ativas ao novo slide
        slides[index].classList.add('active');
        if (indicators.length > 0) {
            indicators[index].classList.add('active');
        }
        
        // Atualizar textos
        const title = slides[index].getAttribute('data-title');
        const description = slides[index].getAttribute('data-description');
        const date = slides[index].getAttribute('data-date');
        
        const titleEl = document.querySelector('.hero-content h1');
        const descEl = document.querySelector('.hero-content .hero-description');
        const dateEl = document.querySelector('.hero-content .date');
        
        if (titleEl) titleEl.textContent = title;
        if (descEl) descEl.textContent = description;
        if (dateEl) dateEl.textContent = date;
        
        // Atualizar índice atual
        currentIndex = index;
    }
    
    // Função para ir para o próximo slide
    function nextSlide() {
        const newIndex = (currentIndex + 1) % slides.length;
        goToSlide(newIndex);
    }
    
    // Adicionar eventos aos indicadores
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
            // Reiniciar o temporizador
            clearInterval(interval);
            startAutoplay();
        });
    });
    
    // Iniciar autoplay
    function startAutoplay() {
        interval = setInterval(nextSlide, 5000); // Mudar slide a cada 5 segundos
    }
    
    // Iniciar
    startAutoplay();
});