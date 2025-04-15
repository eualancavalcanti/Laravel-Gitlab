/**
 * Script complementar para melhorar a experiência do usuário
 * 
 * Este script adiciona funcionalidades como:
 * - Animações ao scrollar
 * - Comportamento responsivo do header
 * - Lazyloading de imagens
 * - Prevenção de CLS (Cumulative Layout Shift)
 */

document.addEventListener('DOMContentLoaded', () => {
    // Referência para o navbar
    const navbar = document.querySelector('.navbar');
    
    // Animação de elementos ao scrollar
    const fadeElements = document.querySelectorAll('.feature-card, .price-card, .creator-card, .actor-card');
    
    // Gerenciamento de precarregamento de imagens
    const imagesToPreload = document.querySelectorAll('.content-card img, .actor-image');
    
    // Detectar scroll para mudar navbar
    window.addEventListener('scroll', () => {
        // Adiciona classe ao navbar quando scroll > 50px
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
        
        // Animação de fade-in para elementos conforme scrollar
        fadeElements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;
            
            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('fade-in-up');
            }
        });
    });
    
    // Inicializa a verificação inicial
    setTimeout(() => {
        window.dispatchEvent(new Event('scroll'));
    }, 300);
    
    // Implementa lazyloading para imagens
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                const src = img.getAttribute('data-src');
                
                if (src) {
                    // Se for uma imagem direta
                    if (img.tagName === 'IMG') {
                        img.src = src;
                        img.classList.add('loaded');
                    } 
                    // Se for um background-image
                    else {
                        img.style.backgroundImage = `url(${src})`;
                        img.classList.add('loaded');
                    }
                    
                    observer.unobserve(img);
                }
            }
        });
    }, observerOptions);
    
    imagesToPreload.forEach(img => {
        img.classList.add('lazy-load');
        imageObserver.observe(img);
    });
    
    // Adicionar animações a outros elementos
    const animateWithDelay = () => {
        const heroContent = document.querySelector('.hero-content');
        if (heroContent) {
            const elements = heroContent.children;
            Array.from(elements).forEach((el, index) => {
                el.classList.add('fade-in-up', `delay-${index + 1}`);
            });
        }
    };
    
    // Iniciar animações após um breve delay para garantir que o DOM está preparado
    setTimeout(animateWithDelay, 500);
    
    // Detectar problemas de carregamento de imagens e aplicar fallbacks
    document.querySelectorAll('img').forEach(img => {
        img.addEventListener('error', () => {
            console.warn(`Falha ao carregar imagem: ${img.src}`);
            img.src = 'https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=800&h=450&fit=crop';
            img.setAttribute('alt', 'Imagem indisponível');
        });
    });
    
    // Verificar suporte a backdrop-filter para browsers mais antigos
    if (!CSS.supports('backdrop-filter', 'blur(10px)')) {
        document.querySelectorAll('.hero-indicators, .navbar, .watching-info, .date').forEach(el => {
            el.style.background = 'rgba(0, 0, 0, 0.8)';
        });
    }
    
    // Adicionar eventos "hover" em dispositivos de toque para melhorar experiência
    if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
        const touchCards = document.querySelectorAll('.content-card, .actor-card, .creator-card');
        
        touchCards.forEach(card => {
            card.addEventListener('touchstart', function() {
                // Remove classe de hover de todos os outros cards
                touchCards.forEach(c => {
                    if (c !== card) c.classList.remove('touch-hover');
                });
                
                // Toggle classe no card atual
                this.classList.toggle('touch-hover');
            });
        });
        
        // Adiciona regra CSS para simular hover em toque
        const style = document.createElement('style');
        style.textContent = `
            .touch-hover {
                transform: translateY(-5px) scale(1.02) !important;
                box-shadow: 0 8px 25px rgba(255, 51, 51, 0.2) !important;
            }
            
            .content-card.touch-hover img {
                transform: scale(1.05) !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Melhorar contraste e acessibilidade
    const checkContrast = () => {
        const textElements = document.querySelectorAll('.text-secondary, .card-bg, .content-overlay');
        textElements.forEach(el => {
            // Aumenta levemente o contraste dos textos secundários
            el.style.color = 'rgba(255, 255, 255, 0.75)';
        });
    };
    
    // Executar verificação de contraste
    checkContrast();
    
    // Detectar problemas potenciais de navegação
    const links = document.querySelectorAll('a');
    links.forEach(link => {
        if (!link.hasAttribute('href') || link.getAttribute('href') === '#') {
            link.setAttribute('role', 'button');
            link.setAttribute('tabindex', '0');
            link.setAttribute('aria-label', link.textContent.trim() || 'Botão de navegação');
        }
    });
});

// Adiciona evento para detectar quando todo o conteúdo (incluindo imagens) foi carregado
window.addEventListener('load', () => {
    // Remove classes de esqueleto após carregamento completo
    document.querySelectorAll('.skeleton').forEach(el => {
        el.classList.remove('skeleton');
    });
    
    // Esconde animações de carregamento
    document.querySelectorAll('.loading-spinner').forEach(el => {
        el.style.display = 'none';
    });
    
    // Medidas para melhorar a performance
    setTimeout(() => {
        const nonVisibleImages = Array.from(document.querySelectorAll('img'))
            .filter(img => {
                const rect = img.getBoundingClientRect();
                return !(rect.top <= window.innerHeight && rect.bottom >= 0);
            });
            
        // Carrega imagens não visíveis com menor prioridade
        nonVisibleImages.forEach(img => {
            img.loading = 'lazy';
        });
    }, 1000);
});