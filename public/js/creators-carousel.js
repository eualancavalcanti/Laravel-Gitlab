/**
 * Carrossel de Criadores - HotBoys
 * Script leve e dedicado para garantir o funcionamento correto do carrossel na seção de Criadores do Momento
 */

document.addEventListener('DOMContentLoaded', () => {
    // Inicialização específica para o carrossel de criadores
    initCreatorsCarousel();
});

/**
 * Inicializa o carrossel de criadores com configurações específicas
 */
function initCreatorsCarousel() {
    const creatorsSection = document.querySelector('.trending-creators');
    if (!creatorsSection) return;

    const carouselTrack = creatorsSection.querySelector('.creators-carousel');
    const prevBtn = creatorsSection.querySelector('.prev');
    const nextBtn = creatorsSection.querySelector('.next');
    const cards = creatorsSection.querySelectorAll('.creator-card-premium');

    if (!carouselTrack || cards.length === 0) return;

    // Otimiza a largura dos cards para o espaço disponível
    adjustCardWidths();

    // Configura os botões de navegação
    if (prevBtn) {
        prevBtn.addEventListener('click', () => navigateCarousel('prev'));
        // Desabilita o botão prev inicialmente (estamos no início)
        prevBtn.disabled = true;
        prevBtn.classList.add('disabled');
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', () => navigateCarousel('next'));
        // Apenas habilita o botão next se houver cards suficientes
        updateButtonStates();
    }

    // Adiciona eventos de arrastar para controle touch/mouse
    setupDragToScroll();

    // Configura atualização de botões ao rolar
    carouselTrack.addEventListener('scroll', function() {
        updateButtonStates();
    });

    // Recalcula em redimensionamento
    window.addEventListener('resize', function() {
        adjustCardWidths();
        updateButtonStates();
    });

    /**
     * Ajusta as larguras dos cards para otimizar a exibição
     */
    function adjustCardWidths() {
        const containerWidth = creatorsSection.querySelector('.section-container').clientWidth;
        const isMobile = window.innerWidth < 768;
        
        // Calcula a largura com base no número de cards a exibir
        let cardWidth;
        
        if (isMobile) {
            // Em dispositivos móveis, exibe 1.2 cards
            cardWidth = Math.floor(containerWidth * 0.75);
        } else if (window.innerWidth < 1200) {
            // Em tablets/notebooks, exibe 2.5 cards
            const gap = 24; // 1.5rem em pixels
            cardWidth = Math.floor((containerWidth - (gap * 2)) / 2.5);
        } else {
            // Em desktops grandes, exibe 3.5 cards
            const gap = 24; // 1.5rem em pixels
            cardWidth = Math.floor((containerWidth - (gap * 3)) / 3.5);
        }
        
        // Limita a largura máxima para cards não ficarem muito largos
        cardWidth = Math.min(cardWidth, 320);
        
        // Aplica a largura a todos os cards
        cards.forEach(card => {
            card.style.minWidth = `${cardWidth}px`;
            card.style.maxWidth = `${cardWidth}px`;
        });
    }

    /**
     * Navega o carrossel para uma direção específica
     */
    function navigateCarousel(direction) {
        // A largura de um card incluindo margem
        const cardWidth = cards[0].offsetWidth + 24; // 24px para o gap (1.5rem)
        
        // Quantidade a rolar baseada na direção
        const scrollAmount = direction === 'next' ? cardWidth : -cardWidth;
        
        // Comportamento suave para rolagem 
        carouselTrack.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });
    }

    /**
     * Atualiza o estado dos botões de navegação
     */
    function updateButtonStates() {
        if (!prevBtn || !nextBtn) return;

        const scrollPosition = carouselTrack.scrollLeft;
        const maxScroll = carouselTrack.scrollWidth - carouselTrack.clientWidth;

        // Atualiza o botão anterior
        if (scrollPosition <= 5) {
            prevBtn.disabled = true;
            prevBtn.classList.add('disabled');
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove('disabled');
        }

        // Atualiza o botão próximo
        if (scrollPosition >= maxScroll - 5) {
            nextBtn.disabled = true;
            nextBtn.classList.add('disabled');
        } else {
            nextBtn.disabled = false;
            nextBtn.classList.remove('disabled');
        }
    }

    /**
     * Configura funcionalidade de arrastar para rolar
     */
    function setupDragToScroll() {
        let isDown = false;
        let startX;
        let startScrollLeft;

        carouselTrack.addEventListener('mousedown', (e) => {
            isDown = true;
            carouselTrack.style.cursor = 'grabbing';
            startX = e.pageX - carouselTrack.offsetLeft;
            startScrollLeft = carouselTrack.scrollLeft;
            
            // Evita problemas com animações CSS durante o arrasto
            carouselTrack.style.scrollBehavior = 'auto';
        });

        carouselTrack.addEventListener('mouseleave', () => {
            isDown = false;
            carouselTrack.style.cursor = 'grab';
            carouselTrack.style.scrollBehavior = 'smooth';
        });

        carouselTrack.addEventListener('mouseup', () => {
            isDown = false;
            carouselTrack.style.cursor = 'grab';
            carouselTrack.style.scrollBehavior = 'smooth';
            
            // Snapeia para o card mais próximo
            snapToNearestCard();
        });

        carouselTrack.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - carouselTrack.offsetLeft;
            const walk = (x - startX) * 1.5; // Multiplicador para sensibilidade do arrasto
            carouselTrack.scrollLeft = startScrollLeft - walk;
            updateButtonStates();
        });

        // Suporte para dispositivos de toque
        carouselTrack.addEventListener('touchstart', (e) => {
            isDown = true;
            startX = e.touches[0].pageX - carouselTrack.offsetLeft;
            startScrollLeft = carouselTrack.scrollLeft;
            carouselTrack.style.scrollBehavior = 'auto';
        }, { passive: true });

        carouselTrack.addEventListener('touchend', () => {
            isDown = false;
            carouselTrack.style.scrollBehavior = 'smooth';
            snapToNearestCard();
        });

        carouselTrack.addEventListener('touchmove', (e) => {
            if (!isDown) return;
            const x = e.touches[0].pageX - carouselTrack.offsetLeft;
            const walk = (x - startX) * 1.5;
            carouselTrack.scrollLeft = startScrollLeft - walk;
            updateButtonStates();
        }, { passive: true });
    }

    /**
     * Snapeia para o card mais próximo após arrastar
     */
    function snapToNearestCard() {
        const cardWidth = cards[0].offsetWidth + 24; // Card + gap
        const scrollPosition = carouselTrack.scrollLeft;
        
        // Calcula o próximo ponto de snap
        const cardIndex = Math.round(scrollPosition / cardWidth);
        const snapPosition = cardIndex * cardWidth;
        
        // Rola para o card mais próximo
        carouselTrack.scrollTo({
            left: snapPosition,
            behavior: 'smooth'
        });
    }
}