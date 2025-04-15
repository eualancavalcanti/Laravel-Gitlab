<!-- resources/views/pages/novidades.blade.php -->
@extends('layouts.page')

@section('title', 'Novidades - HotBoys')

@section('page-title', 'Novidades')

@section('page-content')
    <div class="news-container">
        <div class="news-header">
            <div class="news-search">
                <input type="text" id="news-search-input" placeholder="Buscar novidades...">
                <button class="search-btn"><i class="lucide-search"></i></button>
            </div>
            
            <div class="news-filters">
                <div class="filter-categories">
                    <button class="filter-btn active" data-filter="all">Todas</button>
                    <button class="filter-btn" data-filter="updates">Atualizações</button>
                    <button class="filter-btn" data-filter="releases">Novos Lançamentos</button>
                    <button class="filter-btn" data-filter="events">Eventos</button>
                    <button class="filter-btn" data-filter="promotions">Promoções</button>
                </div>
                
                <div class="filter-sort">
                    <select id="sort-select">
                        <option value="newest">Mais recentes</option>
                        <option value="oldest">Mais antigos</option>
                        <option value="popular">Mais populares</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="featured-news">
            <div class="featured-news-content">
                <span class="news-tag">Destaque</span>
                <h2>Lançamento da Nova Atualização da Plataforma HotBoys 2.0</h2>
                <p class="news-date">15 de Abril, 2025</p>
                <p class="news-excerpt">Experimente uma nova forma de navegar pelo nosso conteúdo com a interface totalmente renovada, sistema de recomendações personalizado e muito mais!</p>
                <a href="#" class="btn-primary">Ler mais</a>
            </div>
            <div class="featured-news-image" style="background-image: url('{{ asset('images/news/platform-update.jpg') }}')">
                <div class="image-overlay"></div>
            </div>
        </div>
        
        <div class="news-grid">
            <!-- Item de Novidade - Lançamento -->
            <div class="news-item" data-category="releases">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/new-release-1.jpg') }}')">
                    <span class="news-tag">Lançamento</span>
                </div>
                <div class="news-item-content">
                    <h3>Nova série exclusiva "Encontros Ardentes" já disponível</h3>
                    <p class="news-date">12 de Abril, 2025</p>
                    <p class="news-excerpt">Nossa nova série produzida com exclusividade para o HotBoys traz 5 episódios de puro prazer e intensidade.</p>
                    <a href="#" class="read-more">Ler mais <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Item de Novidade - Promoção -->
            <div class="news-item" data-category="promotions">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/promo-spring.jpg') }}')">
                    <span class="news-tag">Promoção</span>
                </div>
                <div class="news-item-content">
                    <h3>Promoção de Outono: 50% de desconto para novos assinantes</h3>
                    <p class="news-date">10 de Abril, 2025</p>
                    <p class="news-excerpt">Aproveite nossa promoção sazonal e ganhe 50% de desconto nos primeiros 3 meses de assinatura VIP.</p>
                    <a href="#" class="read-more">Ver detalhes <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Item de Novidade - Atualização -->
            <div class="news-item" data-category="updates">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/app-update.jpg') }}')">
                    <span class="news-tag">Atualização</span>
                </div>
                <div class="news-item-content">
                    <h3>Aplicativo mobile atualizado com novas funcionalidades</h3>
                    <p class="news-date">8 de Abril, 2025</p>
                    <p class="news-excerpt">Nossa atualização mais recente traz suporte para download de conteúdo em 4K, modo picture-in-picture e muito mais.</p>
                    <a href="#" class="read-more">Saiba mais <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Item de Novidade - Evento -->
            <div class="news-item" data-category="events">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/live-event.jpg') }}')">
                    <span class="news-tag">Evento</span>
                </div>
                <div class="news-item-content">
                    <h3>Live especial com os atores mais populares da plataforma</h3>
                    <p class="news-date">5 de Abril, 2025</p>
                    <p class="news-excerpt">Não perca nossa transmissão ao vivo exclusiva para assinantes VIP. Interaja com seus atores favoritos!</p>
                    <a href="#" class="read-more">Ler mais <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Item de Novidade - Lançamento -->
            <div class="news-item" data-category="releases">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/new-release-2.jpg') }}')">
                    <span class="news-tag">Lançamento</span>
                </div>
                <div class="news-item-content">
                    <h3>Novo conteúdo 4K com Diego Martins e Bruno Costa</h3>
                    <p class="news-date">2 de Abril, 2025</p>
                    <p class="news-excerpt">Um dos pares mais requisitados da plataforma finalmente juntos em uma produção de altíssima qualidade.</p>
                    <a href="#" class="read-more">Assistir agora <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
            
            <!-- Item de Novidade - Atualização -->
            <div class="news-item" data-category="updates">
                <div class="news-item-image" style="background-image: url('{{ asset('images/news/payment-update.jpg') }}')">
                    <span class="news-tag">Atualização</span>
                </div>
                <div class="news-item-content">
                    <h3>Novos métodos de pagamento adicionados</h3>
                    <p class="news-date">28 de Março, 2025</p>
                    <p class="news-excerpt">Agora você pode usar PIX e criptomoedas para pagar sua assinatura ou comprar conteúdo individual com total discrição.</p>
                    <a href="#" class="read-more">Ver detalhes <i class="lucide-arrow-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="pagination">
            <button class="pagination-btn prev" disabled><i class="lucide-chevron-left"></i></button>
            <div class="pagination-numbers">
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <span class="pagination-dots">...</span>
                <a href="#">8</a>
            </div>
            <button class="pagination-btn next"><i class="lucide-chevron-right"></i></button>
        </div>
        
        <div class="newsletter-signup">
            <div class="newsletter-content">
                <h2>Fique por dentro das novidades</h2>
                <p>Receba notificações sobre lançamentos, promoções exclusivas e atualizações importantes diretamente no seu e-mail.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Seu melhor e-mail" required>
                    <button type="submit" class="btn-primary">Inscrever-se</button>
                </form>
                <p class="privacy-note">Respeitamos sua privacidade. Você pode cancelar a inscrição a qualquer momento.</p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .news-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    .news-header {
        margin-bottom: 2rem;
    }
    
    .news-search {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .news-search input {
        width: 100%;
        padding: 1rem 3rem 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .news-search input:focus {
        outline: none;
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.3);
        border-color: var(--hot-red);
        background: rgba(255, 255, 255, 0.15);
    }
    
    .search-btn {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--hot-red);
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .news-filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .filter-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .filter-btn:hover {
        background: rgba(255, 51, 51, 0.2);
        color: white;
    }
    
    .filter-btn.active {
        background: var(--hot-red);
        color: white;
    }
    
    .filter-sort select {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: var(--text-secondary);
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23FF3333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 1em;
        padding-right: 2.5rem;
    }
    
    .filter-sort select:focus {
        outline: none;
        border-color: var(--hot-red);
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.2);
    }
    
    /* Featured News */
    .featured-news {
        position: relative;
        display: grid;
        grid-template-columns: 1fr 1fr;
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 3rem;
        background: rgba(0, 0, 0, 0.3);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        min-height: 400px;
    }
    
    .featured-news-content {
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 2;
    }
    
    .featured-news-content h2 {
        margin-top: 0.5rem;
        margin-bottom: 1rem;
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        background: var(--gradient-hot);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 2px 10px rgba(255, 51, 51, 0.3);
    }
    
    .featured-news-image {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        width: 55%;
        background-size: cover;
        background-position: center;
        z-index: 1;
    }
    
    .image-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to right, var(--darker-bg) 0%, rgba(10, 10, 10, 0.7) 50%, rgba(10, 10, 10, 0.4) 100%);
    }
    
    .news-tag {
        display: inline-block;
        padding: 0.4rem 1rem;
        background: var(--hot-red);
        color: white;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .news-date {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .news-excerpt {
        margin-bottom: 1.5rem;
        line-height: 1.6;
        color: var(--text-secondary);
    }
    
    /* News Grid */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }
    
    .news-item {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .news-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255, 51, 51, 0.2);
        border-color: rgba(255, 51, 51, 0.3);
    }
    
    .news-item-image {
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
        overflow: hidden;
    }
    
    .news-item-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.7));
    }
    
    .news-item-image .news-tag {
        position: absolute;
        top: 1rem;
        left: 1rem;
        z-index: 1;
    }
    
    .news-item-content {
        padding: 1.5rem;
    }
    
    .news-item-content h3 {
        margin-top: 0;
        margin-bottom: 0.5rem;
        font-size: 1.2rem;
        line-height: 1.4;
    }
    
    .news-item-content .news-date {
        margin-bottom: 0.75rem;
    }
    
    .news-item-content .news-excerpt {
        font-size: 0.95rem;
    }
    
    .read-more {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--hot-red);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }
    
    .read-more:hover {
        gap: 0.75rem;
        text-decoration: underline;
    }
    
    /* Paginação */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 3rem;
    }
    
    .pagination-numbers {
        display: flex;
        gap: 0.5rem;
    }
    
    .pagination-numbers a, .pagination-dots {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-secondary);
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .pagination-numbers a:hover {
        background: rgba(255, 51, 51, 0.2);
        color: white;
    }
    
    .pagination-numbers a.active {
        background: var(--hot-red);
        color: white;
    }
    
    .pagination-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
    }
    
    .pagination-btn:hover:not(:disabled) {
        background: var(--hot-red);
    }
    
    .pagination-btn:disabled {
        cursor: not-allowed;
        opacity: 0.5;
    }
    
    /* Newsletter */
    .newsletter-signup {
        background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.1));
        border-radius: 15px;
        padding: 3rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(255, 51, 51, 0.2);
        text-align: center;
    }
    
    .newsletter-content {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .newsletter-content h2 {
        margin-top: 0;
        margin-bottom: 1rem;
    }
    
    .newsletter-content p {
        margin-bottom: 1.5rem;
        color: var(--text-secondary);
    }
    
    .newsletter-form {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    
    .newsletter-form input {
        flex: 1;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: 1rem;
    }
    
    .newsletter-form input:focus {
        outline: none;
        border-color: var(--hot-red);
        box-shadow: 0 0 15px rgba(255, 51, 51, 0.3);
    }
    
    .privacy-note {
        font-size: 0.8rem;
        opacity: 0.7;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .featured-news {
            grid-template-columns: 1fr;
        }
        
        .featured-news-image {
            position: relative;
            width: 100%;
            height: 300px;
        }
        
        .image-overlay {
            background: linear-gradient(to bottom, rgba(10, 10, 10, 0.4), rgba(10, 10, 10, 0.8));
        }
    }
    
    @media (max-width: 768px) {
        .news-grid {
            grid-template-columns: 1fr;
        }
        
        .news-filters {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .filter-categories {
            width: 100%;
            overflow-x: auto;
            padding-bottom: 0.5rem;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        
        .filter-btn {
            white-space: nowrap;
        }
        
        .newsletter-form {
            flex-direction: column;
        }
        
        .newsletter-signup {
            padding: 2rem 1.5rem;
        }
    }
    
    @media (max-width: 480px) {
        .pagination-numbers {
            gap: 0.25rem;
        }
        
        .pagination-numbers a, .pagination-dots, .pagination-btn {
            width: 35px;
            height: 35px;
            font-size: 0.9rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filtro por categoria
        const filterButtons = document.querySelectorAll('.filter-btn');
        const newsItems = document.querySelectorAll('.news-item');
        
        filterButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Atualizar botão ativo
                filterButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const filter = button.dataset.filter;
                
                // Filtrar itens
                newsItems.forEach(item => {
                    if (filter === 'all' || item.dataset.category === filter) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Ordenação
        const sortSelect = document.getElementById('sort-select');
        const newsGrid = document.querySelector('.news-grid');
        
        sortSelect.addEventListener('change', () => {
            const value = sortSelect.value;
            const items = Array.from(newsItems);
            
            // Ordenação simulada (em produção, isso seria feito com dados reais)
            switch (value) {
                case 'newest':
                    // Já está ordenado do mais recente para o mais antigo no HTML
                    break;
                case 'oldest':
                    // Inverter a ordem
                    items.reverse();
                    break;
                case 'popular':
                    // Ordenação aleatória apenas para simulação
                    items.sort(() => Math.random() - 0.5);
                    break;
            }
            
            // Reordenar elementos no DOM
            items.forEach(item => newsGrid.appendChild(item));
        });
        
        // Busca
        const searchInput = document.getElementById('news-search-input');
        
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            
            if (searchTerm.length < 2) {
                newsItems.forEach(item => {
                    item.style.display = 'block';
                });
                
                // Reset dos filtros
                filterButtons.forEach(btn => btn.classList.remove('active'));
                document.querySelector('[data-filter="all"]').classList.add('active');
                return;
            }
            
            newsItems.forEach(item => {
                const title = item.querySelector('h3').textContent.toLowerCase();
                const excerpt = item.querySelector('.news-excerpt').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || excerpt.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
        
        // Simular navegação na paginação
        const paginationLinks = document.querySelectorAll('.pagination-numbers a');
        const prevBtn = document.querySelector('.pagination-btn.prev');
        const nextBtn = document.querySelector('.pagination-btn.next');
        
        paginationLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Atualizar link ativo
                paginationLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
                
                // Simular carregamento (em produção, isso carregaria conteúdo via AJAX)
                scrollTo({
                    top: document.querySelector('.news-container').offsetTop - 100,
                    behavior: 'smooth'
                });
                
                // Atualizar estado dos botões prev/next
                updatePaginationButtons();
            });
        });
        
        prevBtn.addEventListener('click', () => {
            const activeLink = document.querySelector('.pagination-numbers a.active');
            const prevLink = activeLink.previousElementSibling;
            
            if (prevLink && prevLink.tagName === 'A') {
                prevLink.click();
            }
        });
        
        nextBtn.addEventListener('click', () => {
            const activeLink = document.querySelector('.pagination-numbers a.active');
            const nextLink = activeLink.nextElementSibling;
            
            if (nextLink && nextLink.tagName === 'A') {
                nextLink.click();
            }
        });
        
        function updatePaginationButtons() {
            const activeLink = document.querySelector('.pagination-numbers a.active');
            
            // Disable/enable prev button
            if (!activeLink.previousElementSibling || activeLink.previousElementSibling.tagName !== 'A') {
                prevBtn.disabled = true;
            } else {
                prevBtn.disabled = false;
            }
            
            // Disable/enable next button
            if (!activeLink.nextElementSibling || activeLink.nextElementSibling.tagName !== 'A') {
                nextBtn.disabled = true;
            } else {
                nextBtn.disabled = false;
            }
        }
        
        // Inicializar estado dos botões
        updatePaginationButtons();
        
        // Formulário da newsletter
        const newsletterForm = document.querySelector('.newsletter-form');
        
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Simular envio (em produção, isso enviaria via AJAX)
            const emailInput = newsletterForm.querySelector('input[type="email"]');
            const email = emailInput.value;
            
            if (email) {
                // Exibir mensagem de sucesso (simplificada para o exemplo)
                newsletterForm.innerHTML = '<p class="success-message"><i class="lucide-check-circle"></i> Obrigado! Você foi inscrito com sucesso.</p>';
            }
        });
    });
</script>
@endpush