document.addEventListener('DOMContentLoaded', () => {
    // Hero carousel data - Substituídos com URLs mais confiáveis
    const heroSlides = [
        {
            image: 'https://images.unsplash.com/photo-1566753323558-f4e0952af115?w=1920&h=1080&fit=crop',
            title: 'Hot Hot Hot',
            description: 'Uma história envolvente de paixão e mistério em uma noite quente de verão.',
            date: '22 Mar 2024'
        },
        {
            image: 'https://images.unsplash.com/photo-1503443207922-dff7d543fd0e?w=1920&h=1080&fit=crop',
            title: 'Encontro Casual',
            description: 'Quando o destino conspira para unir dois corações solitários.',
            date: '23 Mar 2024'
        },
        {
            image: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1920&h=1080&fit=crop',
            title: 'Paixão Proibida',
            description: 'Um romance intenso que desafia todas as convenções.',
            date: '24 Mar 2024'
        },
        {
            image: 'https://images.unsplash.com/photo-1492288991661-058aa541ff43?w=1920&h=1080&fit=crop',
            title: 'Desejo Ardente',
            description: 'Uma aventura sensual que vai despertar seus sentidos.',
            date: '25 Mar 2024'
        }
    ];

    let currentSlideIndex = 0;
    let isTransitioning = false;
    let autoplayInterval;
    let touchStartX = 0;
    let touchEndX = 0;

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

        // Update content
        updateHeroContent(heroSlides[newIndex]);

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
            title: "Noite de Verão",
            thumbnail: "https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=800&h=450&fit=crop",
            progress: 45,
            viewers: 1234,
            duration: "1:45:30",
            remainingTime: "58:15"
        },
        {
            title: "Encontro Casual",
            thumbnail: "https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=800&h=450&fit=crop",
            progress: 30,
            viewers: 856,
            duration: "1:28:45",
            remainingTime: "1:00:07"
        },
        {
            title: "Paixão Proibida",
            thumbnail: "https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=800&h=450&fit=crop",
            progress: 75,
            viewers: 2341,
            duration: "2:15:00",
            remainingTime: "33:45"
        },
        {
            title: "Desejo Ardente",
            thumbnail: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=800&h=450&fit=crop",
            progress: 15,
            viewers: 1567,
            duration: "1:55:20",
            remainingTime: "1:38:02"
        },
        {
            title: "Noite Perfeita",
            thumbnail: "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=800&h=450&fit=crop",
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
            thumbnail: "https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=800&h=450&fit=crop",
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
            image: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=400&fit=crop"
        },
        {
            name: "Bruno Costa",
            videos: 38,
            followers: "158K",
            rating: 4.8,
            tags: ["Tendência", "VIP"],
            image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=400&fit=crop"
        },
        {
            name: "Thiago Santos",
            videos: 52,
            followers: "220K",
            rating: 4.9,
            tags: ["Premium", "Mais Visto"],
            image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=400&fit=crop"
        },
        {
            name: "Leonardo Silva",
            videos: 29,
            followers: "130K",
            rating: 4.7,
            tags: ["Novidade", "VIP"],
            image: "https://images.unsplash.com/photo-1504257432389-52343af06ae3?w=300&h=400&fit=crop"
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
            image: "https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300&h=300&fit=crop",
            verified: true
        },
        {
            name: "Rafael Santos",
            role: "Diretor",
            followers: "195K",
            likes: "890K",
            image: "https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=300&fit=crop",
            verified: true
        },
        {
            name: "Gabriel Costa",
            role: "Ator",
            followers: "150K",
            likes: "750K",
            image: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=300&fit=crop",
            verified: false
        },
        {
            name: "Matheus Oliveira",
            role: "Produtor",
            followers: "220K",
            likes: "950K",
            image: "https://images.unsplash.com/photo-1492288991661-058aa541ff43?w=300&h=300&fit=crop",
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
        img.src = fallbackUrl || 'https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=800&h=450&fit=crop';
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
            img.onerror = () => handleImageError(img);
            
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

    // Função para renderizar atores - Com tratamento de erro
    function renderActors() {
        const carousel = document.querySelector('.actors-carousel');
        if (!carousel) return;

        carousel.innerHTML = '';

        actors.forEach(actor => {
            const card = document.createElement('div');
            card.className = 'actor-card';
            
            const imageWrapper = document.createElement('div');
            imageWrapper.className = 'actor-image';
            
            // Precarregamento de imagem para verificar disponibilidade
            const preloadImg = new Image();
            preloadImg.src = actor.image;
            preloadImg.onload = () => {
                imageWrapper.style.backgroundImage = `url(${actor.image})`;
            };
            preloadImg.onerror = () => {
                // Fallback para imagem padrão em caso de erro
                imageWrapper.style.backgroundImage = 'url(https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=300&h=400&fit=crop)';
            };
            
            const tagsDiv = document.createElement('div');
            tagsDiv.className = 'actor-tags';
            
            actor.tags.forEach(tag => {
                const span = document.createElement('span');
                span.className = 'tag';
                span.textContent = tag;
                tagsDiv.appendChild(span);
            });
            
            imageWrapper.appendChild(tagsDiv);
            
            const name = document.createElement('h3');
            name.textContent = actor.name;
            
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
            
            const button = document.createElement('button');
            button.className = 'btn-primary';
            button.textContent = 'Ver Conteúdo';
            
            card.appendChild(imageWrapper);
            card.appendChild(name);
            card.appendChild(stats);
            card.appendChild(button);
            
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
            
            // Precarregamento de imagem
            const preloadImg = new Image();
            preloadImg.src = creator.image;
            preloadImg.onload = () => {
                imageDiv.style.backgroundImage = `url(${creator.image})`;
            };
            preloadImg.onerror = () => {
                imageDiv.style.backgroundImage = 'url(https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=300&h=300&fit=crop)';
            };
            
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
    }
});

// Adicione este código ao seu arquivo main.js ou crie um novo arquivo modal.js
document.addEventListener('DOMContentLoaded', function() {
    // Referências dos elementos
    const contentCards = document.querySelectorAll('.content-card');
    const contentModal = document.getElementById('contentModal');
    const modalClose = document.querySelector('.modal-close');
    const modalTitle = document.getElementById('modalTitle');
    const modalThumbnail = document.getElementById('modalThumbnail');
    const modalDuration = document.getElementById('modalDuration');
    const viewersCount = document.getElementById('viewersCount');
    const btnWatch = document.querySelector('.btn-watch');
    const btnAdd = document.querySelector('.btn-add');
    
    // Evento de clique nos cards de conteúdo
    contentCards.forEach(card => {
        card.addEventListener('click', function() {
            // Obter dados do card
            const contentId = this.dataset.contentId;
            const title = this.dataset.title;
            const thumbnail = this.dataset.thumbnail;
            const duration = this.dataset.duration;
            const viewers = this.dataset.viewers;
            
            // Preencher dados na modal
            modalTitle.textContent = title;
            modalThumbnail.src = thumbnail;
            modalDuration.textContent = duration;
            viewersCount.textContent = viewers;
            
            // Exibir a modal
            contentModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Impedir rolagem da página
        });
    });
    
    // Fechar a modal
    modalClose.addEventListener('click', function() {
        contentModal.classList.remove('active');
        document.body.style.overflow = ''; // Restaurar rolagem da página
    });
    
    // Fechar a modal clicando fora do conteúdo
    contentModal.addEventListener('click', function(e) {
        if (e.target === contentModal) {
            contentModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Botão de assistir
    btnWatch.addEventListener('click', function() {
        alert('Funcionalidade disponível apenas para usuários cadastrados. Faça login ou assine um plano para continuar.');
    });
    
    // Botão de adicionar à lista
    btnAdd.addEventListener('click', function() {
        alert('Funcionalidade disponível apenas para usuários cadastrados. Faça login ou assine um plano para continuar.');
    });
    
    // Fechar modal com a tecla ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && contentModal.classList.contains('active')) {
            contentModal.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});