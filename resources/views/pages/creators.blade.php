<!-- resources/views/pages/creators.blade.php -->
@extends('layouts.page')

@section('title', 'Criadores - HotBoys')

@section('page-title', 'Criadores em Destaque')

@section('page-content')
    <div class="creators-container">
        <!-- Seção introdutória -->
        <div class="creators-intro">
            <h2>Os melhores criadores de conteúdo adulto do Brasil</h2>
            <p>A HotBoys reúne os criadores mais desejados e talentosos, oferecendo conteúdos exclusivos que você não encontrará em nenhum outro lugar. Conheça nossos destaques e tenha acesso ilimitado assinando nosso plano VIP.</p>
        </div>
        
        <!-- Criadores Fixos em Destaque -->
        <div class="featured-creators">
            <!-- Criadores gerados manualmente, sem depender de dados dinâmicos -->
            @php
            // Array com dados fictícios dos criadores
            $mockCreators = [
                [
                    'name' => 'Diego Martins',
                    'role' => 'Ator Principal',
                    'image' => 'images/creators/creator1.jpg', // Ajuste o caminho conforme necessário
                    'videos' => 52,
                    'followers' => '220K',
                    'rating' => 4.9,
                    'tags' => ['Premium', 'Exclusivo', 'Top 10'],
                    'verified' => true,
                    'exclusive' => true,
                    'trending' => false,
                    'new' => false
                ],
                [
                    'name' => 'Bruno Costa',
                    'role' => 'Ator e Produtor',
                    'image' => 'images/creators/creator2.jpg',
                    'videos' => 48,
                    'followers' => '185K',
                    'rating' => 4.8,
                    'tags' => ['VIP', 'Tendência', 'Público Favorito'],
                    'verified' => true,
                    'exclusive' => false,
                    'trending' => true,
                    'new' => false
                ],
                [
                    'name' => 'Leonardo Silva',
                    'role' => 'Novo Talento',
                    'image' => 'images/creators/creator3.jpg',
                    'videos' => 15,
                    'followers' => '95K',
                    'rating' => 4.7,
                    'tags' => ['Novidade', 'Em Alta', 'Revelação'],
                    'verified' => true,
                    'exclusive' => false,
                    'trending' => false,
                    'new' => true
                ],
                [
                    'name' => 'Rafael Oliveira',
                    'role' => 'Produtor Exclusivo',
                    'image' => 'images/creators/creator4.jpg',
                    'videos' => 37,
                    'followers' => '175K',
                    'rating' => 4.8,
                    'tags' => ['Exclusivo', 'Premium', 'Sensual'],
                    'verified' => true,
                    'exclusive' => true,
                    'trending' => true,
                    'new' => false
                ],
                [
                    'name' => 'Matheus Alves',
                    'role' => 'Ator Revelação',
                    'image' => 'images/creators/creator5.jpg',
                    'videos' => 23,
                    'followers' => '120K',
                    'rating' => 4.6,
                    'tags' => ['Revelação', 'Sensual', 'Fetiche'],
                    'verified' => false,
                    'exclusive' => false,
                    'trending' => true,
                    'new' => true
                ],
                [
                    'name' => 'Lucas Mendes',
                    'role' => 'Ator Principal',
                    'image' => 'images/creators/creator6.jpg',
                    'videos' => 42,
                    'followers' => '210K',
                    'rating' => 4.9,
                    'tags' => ['Premium', 'Top 5', 'Exclusivo'],
                    'verified' => true,
                    'exclusive' => true,
                    'trending' => false,
                    'new' => false
                ]
            ];
            @endphp

            @foreach($mockCreators as $creator)
                <div class="creator-card">
                    <div class="creator-image" style="background-image: url('{{ asset($creator['image']) }}')">
                        <div class="creator-badges">
                            @if($creator['verified'])
                                <span class="badge verified">
                                    <i class="lucide-badge-check"></i>
                                </span>
                            @endif
                            
                            @if($creator['exclusive'])
                                <span class="badge exclusive">
                                    <i class="lucide-crown"></i>
                                </span>
                            @endif
                            
                            @if($creator['trending'])
                                <span class="badge trending">
                                    <i class="lucide-trending-up"></i>
                                </span>
                            @endif
                            
                            @if($creator['new'])
                                <span class="badge new">
                                    <i class="lucide-sparkles"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                    <h3>{{ $creator['name'] }}</h3>
                    <p class="creator-role">{{ $creator['role'] }}</p>
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="lucide-video"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator['videos'] }}</span>
                                <span class="stat-label">Vídeos</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-users"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator['followers'] }}</span>
                                <span class="stat-label">Seguidores</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-star"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $creator['rating'] }}</span>
                                <span class="stat-label">Avaliação</span>
                            </div>
                        </div>
                    </div>
                    <div class="creator-tags">
                        @foreach($creator['tags'] as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="creator-preview">
                        <button class="btn-locked">
                            <i class="lucide-lock"></i> Conteúdo Exclusivo para Assinantes
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Destaques e números -->
        <div class="creators-stats-section">
            <div class="stats-container">
                <div class="creator-stat-card">
                    <div class="stat-number">100+</div>
                    <div class="stat-label">Criadores exclusivos</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">5.000+</div>
                    <div class="stat-label">Vídeos disponíveis</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">20+</div>
                    <div class="stat-label">Novos vídeos por semana</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">4.8</div>
                    <div class="stat-label">Avaliação média</div>
                </div>
            </div>
        </div>
        
        <!-- Seção de incentivo -->
        <div class="creators-cta">
            <h2>Tenha acesso a todos os criadores e seus conteúdos</h2>
            <p>Assine agora o HotBoys VIP e desfrute de acesso ilimitado a todos os vídeos e criadores exclusivos da plataforma. Novos conteúdos são adicionados diariamente!</p>
            
            <div class="pricing-cards">
                <div class="pricing-card">
                    <div class="pricing-name">Mensal</div>
                    <div class="pricing-price">R$ 49,90<span>/mês</span></div>
                    <ul class="pricing-features">
                        <li><i class="lucide-check"></i> Acesso a todos os criadores</li>
                        <li><i class="lucide-check"></i> Conteúdo em 4K Ultra HD</li>
                        <li><i class="lucide-check"></i> Sem anúncios</li>
                        <li><i class="lucide-check"></i> Download offline</li>
                    </ul>
                    <a href="/signup" class="btn-primary">Assinar Agora</a>
                </div>
                
                <div class="pricing-card featured">
                    <div class="pricing-tag">Mais vantajoso</div>
                    <div class="pricing-name">Anual</div>
                    <div class="pricing-price">R$ 29,90<span>/mês</span></div>
                    <div class="pricing-save">Economize R$ 240 por ano</div>
                    <ul class="pricing-features">
                        <li><i class="lucide-check"></i> Acesso a todos os criadores</li>
                        <li><i class="lucide-check"></i> Conteúdo em 4K Ultra HD</li>
                        <li><i class="lucide-check"></i> Sem anúncios</li>
                        <li><i class="lucide-check"></i> Download offline</li>
                        <li><i class="lucide-check"></i> Acesso prioritário a novos vídeos</li>
                        <li><i class="lucide-check"></i> Conteúdo exclusivo para assinantes anuais</li>
                    </ul>
                    <a href="/signup?plan=annual" class="btn-primary">Assinar com Desconto</a>
                </div>
            </div>
            
            <p class="satisfaction-guarantee">
                <i class="lucide-shield"></i> Satisfação garantida ou seu dinheiro de volta em até 7 dias
            </p>
        </div>
        
        <!-- Seção de depoimentos -->
        <div class="testimonials-section">
            <h2>O que dizem nossos assinantes</h2>
            <div class="testimonials">
                <div class="testimonial">
                    <div class="testimonial-rating">
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                    </div>
                    <p class="testimonial-text">"A melhor plataforma que já assinei. Os criadores são incríveis e o conteúdo é de altíssima qualidade. Vale cada centavo!"</p>
                    <p class="testimonial-author">Alexandre M., assinante VIP há 2 anos</p>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-rating">
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                    </div>
                    <p class="testimonial-text">"Depois que conheci o HotBoys, cancelei todas as outras assinaturas. A qualidade do conteúdo e dos criadores é incomparável."</p>
                    <p class="testimonial-author">Ricardo T., assinante VIP há 1 ano</p>
                </div>
                
                <div class="testimonial">
                    <div class="testimonial-rating">
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                        <i class="lucide-star"></i>
                    </div>
                    <p class="testimonial-text">"Os criadores exclusivos do HotBoys são simplesmente os melhores. Experimentei o plano mensal e logo mudei para o anual. Vale muito a pena!"</p>
                    <p class="testimonial-author">Marcos S., assinante VIP há 8 meses</p>
                </div>
            </div>
        </div>
        
        <!-- FAQ simplificado -->
        <div class="creators-faq">
            <h2>Perguntas Frequentes</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Como posso ter acesso a todos os criadores?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Para ter acesso completo a todos os criadores e seus conteúdos exclusivos, você precisa assinar um dos nossos planos VIP. Com a assinatura, você tem acesso ilimitado a todos os vídeos da plataforma.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Posso cancelar minha assinatura a qualquer momento?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sim, você pode cancelar sua assinatura quando quiser. Não há período de fidelidade. Seu acesso permanecerá ativo até o final do período pago. Oferecemos garantia de satisfação e reembolso em até 7 dias após a assinatura.</p>
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Com que frequência são adicionados novos vídeos?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Adicionamos novos vídeos diariamente e novos criadores todos os meses. Em média, mais de 20 novos vídeos exclusivos são disponibilizados por semana, garantindo que você sempre tenha conteúdo novo para assistir.</p>
                </div>
            </div>
        </div>
        
        <!-- Final CTA forte -->
        <div class="final-cta">
            <h2>Não perca mais tempo!</h2>
            <p>Junte-se aos milhares de assinantes satisfeitos e tenha acesso aos melhores criadores de conteúdo adulto do Brasil.</p>
            <a href="/signup" class="btn-primary cta-pulse">Começar Agora</a>
            <p class="final-note">Proteção de privacidade garantida. Sua cobrança aparecerá como "HB Digital Services" na fatura.</p>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .creators-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem;
    }
    
    /* Seção de introdução */
    .creators-intro {
        text-align: center;
        margin-bottom: 3rem;
    }
    
    .creators-intro h2 {
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        margin-bottom: 1rem;
        background: var(--gradient-hot);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    
    .creators-intro p {
        max-width: 800px;
        margin: 0 auto;
        color: var(--text-secondary);
        font-size: clamp(1rem, 2vw, 1.1rem);
        line-height: 1.6;
    }
    
    /* Criadores em destaque */
    .featured-creators {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 4rem;
    }
    
    .creator-card {
        background: var(--card-bg);
        border-radius: var(--border-radius-card);
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        text-align: center;
        cursor: pointer;
    }
    
    .creator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 51, 51, 0.2);
        border-color: rgba(255, 51, 51, 0.3);
    }
    
    .creator-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        margin: 2rem auto 1rem;
        background-size: cover;
        background-position: center;
        position: relative;
        border: 3px solid var(--hot-red);
        box-shadow: 0 0 20px rgba(255, 51, 51, 0.3);
    }
    
    .creator-badges {
        position: absolute;
        bottom: 0;
        right: 0;
        display: flex;
        gap: 4px;
    }
    
    .badge {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        border: 2px solid var(--dark-bg);
    }
    
    .badge.verified {
        background: #1DA1F2;
        color: white;
    }
    
    .badge.exclusive {
        background: #FFD700;
        color: black;
    }
    
    .badge.trending {
        background: #FF3333;
        color: white;
    }
    
    .badge.new {
        background: #7CFC00;
        color: black;
    }
    
    .creator-card h3 {
        margin: 0.5rem 0 0.2rem;
        font-size: 1.5rem;
    }
    
    .creator-role {
        color: var(--text-secondary);
        margin: 0 0 1.5rem;
        font-size: 1rem;
    }
    
    .creator-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        padding: 1rem;
        background: rgba(0, 0, 0, 0.2);
    }
    
    .stat {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    
    .stat i {
        color: var(--hot-red);
        margin-bottom: 0.3rem;
    }
    
    .stat-value {
        font-weight: 600;
        font-size: 1.1rem;
    }
    
    .stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .creator-tags {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.5rem;
        padding: 1.5rem 1rem;
    }
    
    .tag {
        background: rgba(255, 51, 51, 0.15);
        color: var(--text-primary);
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-size: 0.8rem;
    }
    
    .creator-preview {
        padding: 0 1rem 1.5rem;
    }
    
    .btn-locked {
        width: 100%;
        padding: 0.8rem;
        background: rgba(0, 0, 0, 0.3);
        color: var(--text-secondary);
        border: 1px dashed rgba(255, 51, 51, 0.5);
        border-radius: var(--border-radius-button);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .btn-locked:hover {
        background: rgba(255, 51, 51, 0.1);
        color: white;
    }
    
    /* Seção de estatísticas */
    .creators-stats-section {
        padding: 3rem 0;
        margin-bottom: 4rem;
        background: linear-gradient(145deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.05));
        border-radius: var(--border-radius-card);
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
    }
    
    .creator-stat-card {
        text-align: center;
    }
    
    .creator-stat-card .stat-number {
        font-size: 3rem;
        font-weight: 700;
        color: var(--hot-red);
        margin-bottom: 0.5rem;
    }
    
    .creator-stat-card .stat-label {
        font-size: 1.1rem;
        color: var(--text-secondary);
    }
    
    /* Seção de incentivo/CTA */
    .creators-cta {
        text-align: center;
        margin-bottom: 4rem;
    }
    
    .creators-cta h2 {
        font-size: clamp(1.5rem, 3vw, 2.2rem);
        margin-bottom: 1rem;
    }
    
    .creators-cta > p {
        max-width: 800px;
        margin: 0 auto 3rem;
        color: var(--text-secondary);
        font-size: clamp(1rem, 2vw, 1.1rem);
    }
    
    .pricing-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    
    .pricing-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: var(--border-radius-card);
        padding: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .pricing-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 51, 51, 0.2);
    }
    
    .pricing-card.featured {
        background: linear-gradient(145deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.05));
        border: 2px solid var(--hot-red);
        transform: scale(1.05);
    }
    
    .pricing-card.featured:hover {
        transform: scale(1.05) translateY(-5px);
    }
    
    .pricing-tag {
        position: absolute;
        top: -15px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--hot-red);
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 5px 15px rgba(255, 51, 51, 0.3);
    }
    
    .pricing-name {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
    }
    
    .pricing-price {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--hot-red);
        margin-bottom: 1rem;
    }
    
    .pricing-price span {
        font-size: 1rem;
        font-weight: normal;
        color: var(--text-secondary);
    }
    
    .pricing-save {
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem;
        border-radius: 5px;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    .pricing-features {
        list-style: none;
        margin: 0 0 2rem;
        padding: 0;
        text-align: left;
    }
    
    .pricing-features li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.8rem;
        color: var(--text-secondary);
    }
    
    .pricing-features li i {
        color: var(--hot-red);
    }
    
    .pricing-card .btn-primary {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        text-decoration: none;
    }
    
    .satisfaction-guarantee {
        color: var(--text-secondary);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }
    
    /* Seção de depoimentos */
    .testimonials-section {
        margin-bottom: 4rem;
    }
    
    .testimonials-section h2 {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .testimonials {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .testimonial {
        background: rgba(255, 255, 255, 0.05);
        border-radius: var(--border-radius-card);
        padding: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .testimonial:hover {
        transform: translateY(-5px);
        background: rgba(255, 51, 51, 0.05);
        border-color: rgba(255, 51, 51, 0.2);
    }
    
    .testimonial-rating {
        margin-bottom: 1rem;
        color: #FFD700;
    }
    
    .testimonial-text {
        font-style: italic;
        margin-bottom: 1rem;
        line-height: 1.6;
    }
    
    .testimonial-author {
        color: var(--text-secondary);
        font-size: 0.9rem;
        text-align: right;
    }
    
    /* FAQ simplificado */
    .creators-faq {
        margin-bottom: 4rem;
    }
    
    .creators-faq h2 {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .faq-item {
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .faq-question {
        padding: 1.2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
    }
    
    .faq-question h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 500;
    }
    
    .faq-question i {
        color: var(--hot-red);
        transition: transform 0.3s ease;
    }
    
    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 0 1.2rem;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .faq-item.active .faq-answer {
        padding: 0 1.2rem 1.2rem;
        max-height: 500px;
    }
    
    /* Final CTA */
    .final-cta {
        text-align: center;
        padding: 3rem;
        background: linear-gradient(145deg, rgba(255, 51, 51, 0.15), rgba(255, 26, 26, 0.1));
        border-radius: var(--border-radius-card);
        margin-bottom: 2rem;
    }
    
    .final-cta h2 {
        font-size: 2rem;
        margin-bottom: 1rem;
    }
    
    .final-cta p {
        max-width: 600px;
        margin: 0 auto 2rem;
        font-size: 1.1rem;
    }
    
    .cta-pulse {
        display: inline-block;
        padding: 1rem 2.5rem;
        font-size: 1.2rem;
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
    
    .final-note {
        margin-top: 1.5rem;
        font-size: 0.8rem;
        color: var(--text-secondary);
        opacity: 0.7;
    }
    
    /* Responsividade */
    @media (max-width: 992px) {
        .pricing-card.featured {
            transform: scale(1);
        }
        
        .pricing-card.featured:hover {
            transform: translateY(-5px);
        }
        
        .pricing-cards {
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
    }
    
    @media (max-width: 768px) {
        .final-cta {
            padding: 2rem 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .creator-stats {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // FAQ accordion functionality
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            
            question.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                // Close all items
                faqItems.forEach(faq => {
                    faq.classList.remove('active');
                });
                
                // If it wasn't active, open it
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });
        
        // Botões bloqueados redirecionam para assinatura
        const lockedButtons = document.querySelectorAll('.btn-locked');
        
        lockedButtons.forEach(button => {
            button.addEventListener('click', function() {
                window.location.href = '/signup';
            });
        });
        
        // Adicionar interatividade aos cards para melhorar a taxa de conversão
        const creatorCards = document.querySelectorAll('.creator-card');
        
        creatorCards.forEach(card => {
            // Efeito de hover mais pronunciado
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.boxShadow = '0 15px 30px rgba(255, 51, 51, 0.3)';
                
                // Destacar o botão de conteúdo bloqueado
                const lockedBtn = this.querySelector('.btn-locked');
                if (lockedBtn) {
                    lockedBtn.style.background = 'rgba(255, 51, 51, 0.2)';
                    lockedBtn.style.borderColor = 'rgba(255, 51, 51, 0.8)';
                    lockedBtn.style.color = 'white';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
                
                // Reverter destaque do botão
                const lockedBtn = this.querySelector('.btn-locked');
                if (lockedBtn) {
                    lockedBtn.style.background = '';
                    lockedBtn.style.borderColor = '';
                    lockedBtn.style.color = '';
                }
            });
            
            // Todo o card é clicável e redireciona para assinatura
            card.addEventListener('click', function(e) {
                // Não redirecionar se clicar em links internos
                if (e.target.tagName.toLowerCase() === 'a' || 
                    e.target.closest('a') || 
                    e.target.tagName.toLowerCase() === 'button' || 
                    e.target.closest('button')) {
                    return;
                }
                
                window.location.href = '/signup';
            });
        });
    });
</script>
@endpush