document.addEventListener('DOMContentLoaded', () => {
    // Hero carousel data - Substituídos com URLs mais confiáveis
   // Initialize hero carousel
function initHeroCarousel() {
    const slidesContainer = document.querySelector('.hero-slides');
    if (!slidesContainer) return; // Prevenção de erro se o elemento não existir
    
    // Não criar slides novamente - usar os que já existem do backend
    const slides = slidesContainer.querySelectorAll('.hero-slide');
    if (slides.length === 0) return; // Se não houver slides, sair
    
    const indicatorsContainer = document.createElement('div');
    indicatorsContainer.className = 'hero-indicators';

    // Criar apenas indicadores para os slides existentes
    slides.forEach((slide, index) => {
        // Criar indicator
        const indicator = document.createElement('div');
        indicator.className = `indicator ${index === 0 ? 'active' : ''}`;
        indicator.addEventListener('click', () => {
            if (!isTransitioning && currentSlideIndex !== index) {
                changeSlide(index);
            }
        });
        indicatorsContainer.appendChild(indicator);
    });

    document.querySelector('.hero').appendChild(indicatorsContainer);
    
    // Adicionar eventos de touch para suporte mobile
    slidesContainer.addEventListener('touchstart', handleTouchStart, false);
    slidesContainer.addEventListener('touchmove', handleTouchMove, false);
    slidesContainer.addEventListener('touchend', handleTouchEnd, false);
}

    // Initialize hero carousel
    function initHeroCarousel() {
        const slidesContainer = document.querySelector('.hero-slides');
        if (!slidesContainer) return; // Prevenção de erro se o elemento não existir
        
        const indicatorsContainer = document.createElement('div');
        indicatorsContainer.className = 'hero-indicators';

        // Create slides and indicators
        heroSlides.forEach((slide, index) => {
            // Create slide
            const slideElement = document.createElement('div');
            slideElement.className = `hero-slide ${index === 0 ? 'active' : ''}`;
            
            // Precarregamento de imagem para evitar problemas de carregamento
            const img = new Image();
            img.src = slide.image;
            img.onload = () => {
                slideElement.style.backgroundImage = `url(${slide.image})`;
            };
            img.onerror = () => {
                // Fallback para imagem padrão em caso de erro
                slideElement.style.backgroundImage = 'url(https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=1920&h=1080&fit=crop)';
            };
            
            slidesContainer.appendChild(slideElement);

            // Create indicator
            const indicator = document.createElement('div');
            indicator.className = `indicator ${index === 0 ? 'active' : ''}`;
            indicator.addEventListener('click', () => {
                if (!isTransitioning && currentSlideIndex !== index) {
                    changeSlide(index);
                }
            });
            indicatorsContainer.appendChild(indicator);
        });

        document.querySelector('.hero').appendChild(indicatorsContainer);
        updateHeroContent(heroSlides[0]);
        
        // Adicionar eventos de touch para suporte mobile
        slidesContainer.addEventListener('touchstart', handleTouchStart, false);
        slidesContainer.addEventListener('touchmove', handleTouchMove, false);
        slidesContainer.addEventListener('touchend', handleTouchEnd, false);
    }
    
    // Funções de toque para o carrossel Hero
    function handleTouchStart(e) {
        touchStartX = e.touches[0].clientX;
    }
    
    function handleTouchMove(e) {
        touchEndX = e.touches[0].clientX;
    }
    
    function handleTouchEnd() {
        const threshold = 100; // Distância mínima para considerar como swipe
        const touchDiff = touchStartX - touchEndX;
        
        if (Math.abs(touchDiff) > threshold) {
            if (touchDiff > 0) {
                // Swipe para esquerda - próximo slide
                const nextIndex = (currentSlideIndex + 1) % heroSlides.length;
                changeSlide(nextIndex);
            } else {
                // Swipe para direita - slide anterior
                const prevIndex = (currentSlideIndex - 1 + heroSlides.length) % heroSlides.length;
                changeSlide(prevIndex);
            }
        }
    }

    function updateHeroContent(slideData) {
        const content = document.querySelector('.hero-content');
        if (!content) return; // Prevenção de erro
        
        content.classList.add('transitioning');

        setTimeout(() => {
            const dateElement = content.querySelector('.date');
            const titleElement = content.querySelector('h1');
            const descriptionElement = content.querySelector('.hero-description');
            
            if (dateElement) dateElement.textContent = slideData.date;
            if (titleElement) titleElement.textContent = slideData.title;
            if (descriptionElement) descriptionElement.textContent = slideData.description;

            content.classList.remove('transitioning');
        }, 500);
    }

    function changeSlide(newIndex) {
        if (isTransitioning) return;
        isTransitioning = true;
    
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.indicator');
        
        if (slides.length === 0 || indicators.length === 0) {
            isTransitioning = false;
            return;
        }
    
        // Update slides
        slides[currentSlideIndex].classList.remove('active');
        slides[newIndex].classList.add('active');
    
        // Update indicators
        indicators[currentSlideIndex].classList.remove('active');
        indicators[newIndex].classList.add('active');
    
        // Get slide data from data attributes
        const slideData = {
            title: slides[newIndex].getAttribute('data-title'),
            description: slides[newIndex].getAttribute('data-description'),
            date: slides[newIndex].getAttribute('data-date')
        };
    
        // Update content
        updateHeroContent(slideData);
    
        currentSlideIndex = newIndex;
    
        // Reset transition lock after animation completes
        setTimeout(() => {
            isTransitioning = false;
        }, 1000);
    }

    function startAutoplay() {
        stopAutoplay();
        autoplayInterval = setInterval(() => {
            const nextIndex = (currentSlideIndex + 1) % heroSlides.length;
            changeSlide(nextIndex);
        }, 5000);
    }

    function stopAutoplay() {
        if (autoplayInterval) {
            clearInterval(autoplayInterval);
        }
    }

    // Dados dos conteúdos sendo assistidos - URLs atualizadas
    const watchingContent = [
        {
            title: "Desafio do Sofá - GG, Jottaeme e Cauãzinho",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250313235544_H0TB0Y5_78642_vitrine-desktop.jpg",
            progress: 45,
            viewers: 1234,
            duration: "1:45:30",
            remainingTime: "58:15"
        },
        {
            title: "Encontro Casual",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250411021737_H0TB0Y5_35565_vitrine-desktop.jpg",
            progress: 30,
            viewers: 856,
            duration: "1:28:45",
            remainingTime: "1:00:07"
        },
        {
            title: "Paixão Proibida",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250406171234_H0TB0Y5_98205_vitrine-desktop.jpg",
            progress: 75,
            viewers: 2341,
            duration: "2:15:00",
            remainingTime: "33:45"
        },
        {
            title: "Desejo Ardente",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250327235300_H0TB0Y5_31394_vitrine-desktop%20(2).jpg",
            progress: 15,
            viewers: 1567,
            duration: "1:55:20",
            remainingTime: "1:38:02"
        },
        {
            title: "Noite Perfeita",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250320221236_H0TB0Y5_16536_vitrine-desktop.jpg",
            progress: 60,
            viewers: 987,
            duration: "1:35:15",
            remainingTime: "38:06"
        },
        {
            title: "Encontro Secreto",
            thumbnail: "https://images.unsplash.com/photo-1463453091185-61582044d556?w=800&h=450&fit=crop",
            progress: 25,
            viewers: 1432,
            duration: "1:40:00",
            remainingTime: "1:15:00"
        },
        {
            title: "Momento Especial",
            thumbnail: "https://server2.hotboys.com.br/arquivos/20250406171234_H0TB0Y5_98205_vitrine-desktop.jpg",
            progress: 90,
            viewers: 2156,
            duration: "2:00:00",
            remainingTime: "12:00"
        },
        {
            title: "Tarde de Prazer",
            thumbnail: "https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=800&h=450&fit=crop",
            progress: 40,
            viewers: 1789,
            duration: "1:50:00",
            remainingTime: "1:10:00"
        },
        {
            title: "Conexão Intensa",
            thumbnail: "https://images.unsplash.com/photo-1488161628813-04466f872be2?w=800&h=450&fit=crop",
            progress: 55,
            viewers: 1923,
            duration: "1:45:00",
            remainingTime: "47:15"
        },
        {
            title: "Sedução Total",
            thumbnail: "https://images.unsplash.com/photo-1517070208541-6ddc4d3efbcb?w=800&h=450&fit=crop",
            progress: 70,
            viewers: 2567,
            duration: "2:10:00",
            remainingTime: "39:00"
        }
    ];

    // Dados dos atores - URLs atualizadas
    const actors = [
        {
            name: "Diego Martins",
            videos: 45,
            followers: "150K",
            rating: 4.5,
            tags: ["Exclusivo", "Top 10"],
            image: "https://server2.hotboys.com.br/arquivos/20210728172810_H0TB0Y5_96228_junior_rodrigues.jpg"
        },
        {
            name: "Bruno Costa",
            videos: 38,
            followers: "158K",
            rating: 4.8,
            tags: ["Tendência", "VIP"],
            image: "https://server2.hotboys.com.br/arquivos/1731464110_2266754.jpeg"
        },
        {
            name: "Thiago Santos",
            videos: 52,
            followers: "220K",
            rating: 4.9,
            tags: ["Premium", "Mais Visto"],
            image: "https://server2.hotboys.com.br/arquivos/1723620443_4313043.jpeg"
        },
        {
            name: "Leonardo Silva",
            videos: 29,
            followers: "130K",
            rating: 4.7,
            tags: ["Novidade", "VIP"],
            image: "https://server2.hotboys.com.br/arquivos/1725870430_3455245.jfif"
        },
        {
            name: "Ricardo Alves",
            videos: 41,
            followers: "165K",
            rating: 4.6,
            tags: ["Exclusivo"],
            image: "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=300&h=400&fit=crop"
        }
    ];

    // Dados dos criadores do momento - URLs atualizadas
    const trendingCreators = [
        {
            name: "Lucas Silva",
            role: "Ator Principal",
            followers: "280K",
            likes: "1.2M",
            image: "https://server2.hotboys.com.br/arquivos/1731464110_2266754.jpeg",
            verified: true
        },
        {
            name: "Rafael Santos",
            role: "Diretor",
            followers: "195K",
            likes: "890K",
            image: "https://server2.hotboys.com.br/arquivos/1719699379_1916089.jpeg",
            verified: true
        },
        {
            name: "Gabriel Costa",
            role: "Ator",
            followers: "150K",
            likes: "750K",
            image: "https://server2.hotboys.com.br/arquivos/1725889610_3425212.jpeg",
            verified: false
        },
        {
            name: "Matheus Oliveira",
            role: "Produtor",
            followers: "220K",
            likes: "950K",
            image: "https://server2.hotboys.com.br/arquivos/1730746445_7356977.jpeg",
            verified: true
        },
        {
            name: "Matheus Oliveira",
            role: "Produtor",
            followers: "220K",
            likes: "950K",
            image: "https://server2.hotboys.com.br/arquivos/20210728172810_H0TB0Y5_96228_junior_rodrigues.jpg",
            verified: false
        },
        {
            name: "Matheus Oliveira",
            role: "Produtor",
            followers: "220K",
            likes: "950K",
            image: "https://server2.hotboys.com.br/arquivos/1722551797_1327349.jpeg",
            verified: true
        }
        
    ];

    // Função para formatar números - Melhorada para suportar até milhões
    function formatNumber(num) {
        if (num >= 1000000) {
            return (num/1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num/1000).toFixed(1) + 'K';
        }
        return num.toString();
    }

   // Função auxiliar para lidar com imagens quebradas
function handleImageError(img, fallbackUrl) {
    img.onerror = null; // Evitar loop infinito
    
    // Verifica se a imagem está dentro de um card exclusivo
    if (img.closest('#exclusive .content-card')) {
        // Para conteúdo exclusivo, apenas esconde a imagem para manter o fundo preto
        img.style.display = 'none';
    } else {
        // Para outros conteúdos, usa fallback ou imagem genérica
        img.src = fallbackUrl || '/images/placeholder.jpg';
    }
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
        
        // Configura o evento onerror para substituir a imagem quando ocorrer erro
        img.onerror = function() {
            // Remove o evento onerror para evitar loops infinitos
            this.onerror = null;
            
            // Para conteúdo exclusivo, pode ter tratamento especial
            if (isExclusive || this.closest('#exclusive .content-card')) {
                // Apenas esconde a imagem mantendo o fundo escuro para conteúdo exclusivo
                this.style.display = 'none';
                console.log('Erro ao carregar imagem exclusiva - mantendo fundo escuro');
            } else {
                // Substitui a imagem pela padrão
                this.src = fallbackUrl || defaultFallback;
                console.log('Imagem substituída por padrão:', this.alt || 'sem alt');
            }
            
            // Adiciona classe para estilização específica de fallback
            this.classList.add('fallback-image');
        };
        
        // Se a imagem já estiver com erro (src inválido), aciona o fallback imediatamente
        if (img.complete && (img.naturalWidth === 0 || img.naturalHeight === 0)) {
            img.onerror();
        }
    }

    // Aplicar tratamento de imagens quebradas nos carrosséis existentes
    function applyBrokenImageHandling() {
        // Seleciona todas as imagens em carrosséis
        const carouselImages = document.querySelectorAll('.content-grid img, .actors-carousel img, .creators-grid img');
        
        // Aplica tratamento para cada imagem
        carouselImages.forEach(img => {
            handleBrokenCarouselImages(img);
        });
        
        console.log('Tratamento de imagens quebradas aplicado a', carouselImages.length, 'imagens');
    }

    // Função para renderizar conteúdos sendo assistidos - Otimizada
    function renderWatchingContent() {
        const grid = document.querySelector('.content-grid');
        if (!grid) return;
        
        grid.innerHTML = '';

        watchingContent.forEach(content => {
            const card = document.createElement('div');
            card.className = 'content-card';
            
            // Criar elementos individualmente para melhor performance e gestão de erros
            const img = document.createElement('img');
            img.src = content.thumbnail;
            img.alt = content.title;
            // Usar a nova função auxiliar para tratamento de imagens quebradas
            handleBrokenCarouselImages(img);
            
            const overlay = document.createElement('div');
            overlay.className = 'content-overlay';
            
            const title = document.createElement('h3');
            title.textContent = content.title;
            
            const duration = document.createElement('span');
            duration.className = 'duration';
            duration.textContent = content.remainingTime + ' restantes';
            
            overlay.appendChild(title);
            overlay.appendChild(duration);
            
            const info = document.createElement('div');
            info.className = 'watching-info';
            
            const icon = document.createElement('i');
            icon.className = 'lucide-users';
            
            info.appendChild(icon);
            info.appendChild(document.createTextNode(' ' + formatNumber(content.viewers)));
            
            const progress = document.createElement('div');
            progress.className = 'content-progress';
            
            const progressBar = document.createElement('div');
            progressBar.className = 'progress-bar';
            progressBar.style.setProperty('--progress', content.progress + '%');
            
            progress.appendChild(progressBar);
            
            card.appendChild(img);
            card.appendChild(overlay);
            card.appendChild(info);
            card.appendChild(progress);
            
            grid.appendChild(card);
        });
    }

    // Em public/js/main.js, no método renderActors()
function renderActors() {
    const carousel = document.querySelector('.actors-carousel');
    if (!carousel) return;

    carousel.innerHTML = '';

    actors.forEach(actor => {
        const card = document.createElement('div');
        card.className = 'actor-card';
        
        // Criar o elemento de imagem diretamente em vez de usar background-image
        const imageWrapper = document.createElement('div');
        imageWrapper.className = 'actor-image';
        
        // Verificar se a imagem existe antes de atribuir
        const img = document.createElement('img');
        img.src = actor.image;
        img.alt = actor.name;
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        
        // Usar a função padronizada para tratamento de imagens quebradas
        handleBrokenCarouselImages(img);
        
        imageWrapper.appendChild(img);
        
        // Resto do código para adicionar tags e outros elementos...
        const tagsDiv = document.createElement('div');
        tagsDiv.className = 'actor-tags';
        
        actor.tags.forEach(tag => {
            const span = document.createElement('span');
            span.className = 'tag';
            span.textContent = tag;
            tagsDiv.appendChild(span);
        });
        
        imageWrapper.appendChild(tagsDiv);
        
        // Criar o nome do ator
        const name = document.createElement('h3');
        name.textContent = actor.name;
        
        // Adicionar estatísticas
        const stats = document.createElement('div');
        stats.className = 'actor-stats';
        
        const videosSpan = document.createElement('span');
        videosSpan.textContent = `${actor.videos} Vídeos`;
        
        const followersSpan = document.createElement('span');
        followersSpan.textContent = `${actor.followers} Seguidores`;
        
        const ratingSpan = document.createElement('span');
        ratingSpan.textContent = `${actor.rating} ⭐`;
        
        stats.appendChild(videosSpan);
        stats.appendChild(followersSpan);
        stats.appendChild(ratingSpan);
        
        // Adicionar botão
        const button = document.createElement('button');
        button.className = 'btn-primary';
        button.textContent = 'Ver Conteúdo';
        
        // Adicionar todos os elementos ao card
        card.appendChild(imageWrapper);
        card.appendChild(name);
        card.appendChild(stats);
        card.appendChild(button);
        
        // Adicionar o card ao carousel
        carousel.appendChild(card);
    });
}

    // Função para renderizar criadores do momento - Com tratamento de erro
    function renderTrendingCreators() {
        const grid = document.querySelector('.creators-grid');
        if (!grid) return;

        grid.innerHTML = '';

        trendingCreators.forEach(creator => {
            const card = document.createElement('div');
            card.className = 'creator-card';
            
            const header = document.createElement('div');
            header.className = 'creator-header';
            
            const imageDiv = document.createElement('div');
            imageDiv.className = 'creator-image';
            
            // Criar elemento de imagem real em vez de usar background-image
            // para poder aproveitar o tratamento padronizado de imagens quebradas
            const img = document.createElement('img');
            img.src = creator.image;
            img.alt = creator.name;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.borderRadius = 'inherit';
            
            // Usar a função padronizada para tratamento de imagens quebradas
            handleBrokenCarouselImages(img, '/images/creator-placeholder.jpg');
            
            // Adicionar a imagem ao container
            imageDiv.appendChild(img);
            
            if (creator.verified) {
                const badge = document.createElement('span');
                badge.className = 'verified-badge';
                
                const badgeIcon = document.createElement('i');
                badgeIcon.className = 'lucide-badge-check';
                
                badge.appendChild(badgeIcon);
                imageDiv.appendChild(badge);
            }
            
            const info = document.createElement('div');
            info.className = 'creator-info';
            
            const name = document.createElement('h3');
            name.textContent = creator.name;
            
            const role = document.createElement('span');
            role.className = 'creator-role';
            role.textContent = creator.role;
            
            info.appendChild(name);
            info.appendChild(role);
            
            header.appendChild(imageDiv);
            header.appendChild(info);
            
            const stats = document.createElement('div');
            stats.className = 'creator-stats';
            
            // Followers stat
            const followersStat = document.createElement('div');
            followersStat.className = 'stat';
            
            const followersIcon = document.createElement('i');
            followersIcon.className = 'lucide-users';
            
            const followersInfo = document.createElement('div');
            followersInfo.className = 'stat-info';
            
            const followersValue = document.createElement('span');
            followersValue.className = 'stat-value';
            followersValue.textContent = creator.followers;
            
            const followersLabel = document.createElement('span');
            followersLabel.className = 'stat-label';
            followersLabel.textContent = 'Seguidores';
            
            followersInfo.appendChild(followersValue);
            followersInfo.appendChild(followersLabel);
            
            followersStat.appendChild(followersIcon);
            followersStat.appendChild(followersInfo);
            
            // Likes stat
            const likesStat = document.createElement('div');
            likesStat.className = 'stat';
            
            const likesIcon = document.createElement('i');
            likesIcon.className = 'lucide-heart';
            
            const likesInfo = document.createElement('div');
            likesInfo.className = 'stat-info';
            
            const likesValue = document.createElement('span');
            likesValue.className = 'stat-value';
            likesValue.textContent = creator.likes;
            
            const likesLabel = document.createElement('span');
            likesLabel.className = 'stat-label';
            likesLabel.textContent = 'Likes';
            
            likesInfo.appendChild(likesValue);
            likesInfo.appendChild(likesLabel);
            
            likesStat.appendChild(likesIcon);
            likesStat.appendChild(likesInfo);
            
            stats.appendChild(followersStat);
            stats.appendChild(likesStat);
            
            const button = document.createElement('button');
            button.className = 'btn-primary';
            
            const buttonIcon = document.createElement('i');
            buttonIcon.className = 'lucide-plus';
            
            button.appendChild(buttonIcon);
            button.appendChild(document.createTextNode(' Seguir'));
            
            card.appendChild(header);
            card.appendChild(stats);
            card.appendChild(button);
            
            grid.appendChild(card);
        });
    }
    
    // Verificação da existência de todos os elementos necessários
    function checkElementsExist() {
        const requiredElements = [
            '.hero',
            '.hero-slides',
            '.hero-content',
            '.content-grid',
            '.actors-carousel',
            '.creators-grid'
        ];
        
        const missingElements = [];
        
        requiredElements.forEach(selector => {
            if (!document.querySelector(selector)) {
                missingElements.push(selector);
            }
        });
        
        if (missingElements.length > 0) {
            console.warn('Elementos necessários não encontrados:', missingElements.join(', '));
            return false;
        }
        
        return true;
    }

    // Função para controlar o carrossel - Com melhorias para prevenção de erros
    function setupCarousel(container, scrollAmount = 300) {
        if (!container) return;
        
        const content = container.querySelector('.content-grid, .actors-carousel');
        const prevBtn = container.querySelector('.prev');
        const nextBtn = container.querySelector('.next');

        if (!content || !prevBtn || !nextBtn) return;

        function updateButtonVisibility() {
            const scrollWidth = content.scrollWidth;
            const clientWidth = content.clientWidth;

            // Desabilitar botão "anterior" se estiver no início
            if (content.scrollLeft <= 10) {
                prevBtn.style.opacity = '0.5';
                prevBtn.setAttribute('disabled', 'disabled');
            } else {
                prevBtn.style.opacity = '1';
                prevBtn.removeAttribute('disabled');
            }
            
            // Desabilitar botão "próximo" se estiver no final
            if (content.scrollLeft >= scrollWidth - clientWidth - 10) {
                nextBtn.style.opacity = '0.5';
                nextBtn.setAttribute('disabled', 'disabled');
            } else {
                nextBtn.style.opacity = '1';
                nextBtn.removeAttribute('disabled');
            }
        }

        prevBtn.addEventListener('click', () => {
            content.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
            setTimeout(updateButtonVisibility, 300);
        });

        nextBtn.addEventListener('click', () => {
            content.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
            setTimeout(updateButtonVisibility, 300);
        });

        content.addEventListener('scroll', updateButtonVisibility);
        
        // Inicializar estado dos botões
        updateButtonVisibility();

        // Adicionar suporte para touch - Melhorado
        let touchStart = 0;
        let touchX = 0;
        let isDragging = false;
        let startTime = 0;
        let lastPosition = 0;

        content.addEventListener('touchstart', (e) => {
            touchStart = e.touches[0].clientX;
            touchX = content.scrollLeft;
            isDragging = true;
            startTime = Date.now();
            lastPosition = touchStart;
            
            // Parar animação em andamento
            content.style.scrollBehavior = 'auto';
        });

        content.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            
            const x = e.touches[0].clientX;
            const walk = (touchStart - x);
            content.scrollLeft = touchX + walk;
            lastPosition = x;
            
            // Prevenir rolagem da página quando estiver movendo o carrossel
            e.preventDefault();
        });

        content.addEventListener('touchend', () => {
            if (!isDragging) return;
            
            isDragging = false;
            content.style.scrollBehavior = 'smooth';
            
            // Calcular velocidade do gesto para implementar inércia
            const endTime = Date.now();
            const time = endTime - startTime;
            
            if (time < 300) { // Gesto rápido
                const velocity = (touchStart - lastPosition) / time;
                const momentum = velocity * 500; // Multiplicador para ajustar a força da inércia
                
                content.scrollBy({
                    left: momentum,
                    behavior: 'smooth'
                });
            }
            
            updateButtonVisibility();
        });
    }

    // Verificar se todos os elementos necessários existem antes de inicializar
    if (checkElementsExist()) {
        // Initialize all sections
        initHeroCarousel();
        startAutoplay();
        renderWatchingContent();
        renderActors();
        renderTrendingCreators();
        
        // Aplicar tratamento de imagens quebradas para as imagens já existentes no DOM
        applyBrokenImageHandling();
    
        // Configurar carrosséis com detecção de dimensão do dispositivo
        const carousels = document.querySelectorAll('.section-container');
        const isMobile = window.innerWidth < 768;
        const scrollAmountDefault = isMobile ? window.innerWidth * 0.8 : 300;
        
        carousels.forEach(carousel => {
            setupCarousel(carousel, scrollAmountDefault);
        });
    
        // Atualizar viewers periodicamente com menos frequência para diminuir carga no browser
        setInterval(() => {
            watchingContent.forEach(content => {
                // Pequenas variações para dar mais realismo
                content.viewers += Math.floor(Math.random() * 11) - 5;
                if (content.viewers < 0) content.viewers = 0;
            });
            renderWatchingContent();
        }, 8000); // Menos frequente para melhorar performance
    
        // Redefinir carrosséis ao redimensionar a janela - Otimizado com debounce
        let resizeTimeout;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(() => {
                const newIsMobile = window.innerWidth < 768;
                const newScrollAmount = newIsMobile ? window.innerWidth * 0.8 : 300;
                
                carousels.forEach(carousel => {
                    setupCarousel(carousel, newScrollAmount);
                });
                
                // Verificar novamente as imagens após o redimensionamento
                applyBrokenImageHandling();
            }, 300);
        });
        
        // Pause autoplay ao sair da página para economizar recursos
        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopAutoplay();
            } else {
                startAutoplay();
            }
        });
        
        // Também verificar as imagens quando o DOM for modificado
        // usando MutationObserver para detectar novas imagens adicionadas
        const observer = new MutationObserver(mutations => {
            mutations.forEach(mutation => {
                if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                    // Verificar se foram adicionadas novas imagens
                    const hasNewImages = Array.from(mutation.addedNodes).some(node => 
                        node.nodeName === 'IMG' || 
                        (node.nodeType === 1 && node.querySelector('img'))
                    );
                    
                    if (hasNewImages) {
                        // Aplicar tratamento nas novas imagens
                        applyBrokenImageHandling();
                    }
                }
            });
        });
        
        // Observar mudanças no DOM para os contêineres de carrossel
        const carouselContainers = document.querySelectorAll('.content-grid, .actors-carousel, .creators-grid');
        carouselContainers.forEach(container => {
            observer.observe(container, { childList: true, subtree: true });
        });
    }
});

