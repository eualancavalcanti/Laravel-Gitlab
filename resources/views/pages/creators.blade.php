<!-- resources/views/pages/creators.blade.php -->
@extends('layouts.page')

@section('title', 'Modelos - HotBoys')

@section('page-title', 'Modelos em Destaque')

@section('page-content')
    <div class="creators-container">
        <!-- Seção introdutória -->
        <div class="creators-intro">
            <h2>Os modelos mais desejados do Brasil</h2>
            <p>A HotBoys reúne os modelos mais sensuais e talentosos, oferecendo conteúdos exclusivos que você não encontrará em nenhum outro lugar. Conheça nossos destaques e tenha acesso ilimitado assinando nosso plano VIP.</p>
        </div>
        
        <!-- Modelos em Destaque -->
        <div class="featured-creators">
            @php
            // Buscar modelos do banco de dados
            $featuredModels = DB::table('modelos')
                ->where('status', 'Ativo')
                ->where(function($query) {
                    $query->where('preferidos', 'Sim')
                          ->orWhere('exclusivos', 'Sim');
                })
                ->orderBy('visualizacao', 'desc')
                ->take(6)
                ->get();
                
            // Se não houver modelos suficientes, buscar os mais visualizados
            if ($featuredModels->count() < 6) {
                $additionalModels = DB::table('modelos')
                    ->where('status', 'Ativo')
                    ->whereNotIn('id', $featuredModels->pluck('id')->toArray())
                    ->orderBy('visualizacao', 'desc')
                    ->take(6 - $featuredModels->count())
                    ->get();
                    
                $featuredModels = $featuredModels->merge($additionalModels);
            }
            @endphp

            @forelse($featuredModels as $model)
                <div class="creator-card">
                    @php
                    // Processar a imagem do modelo
                    $imageUrl = '';
                    $imageFields = ['foto_principal', 'modelo_perfil', 'modelo_elenco', 'modelo_home'];
                    
                    foreach ($imageFields as $field) {
                        if (!empty($model->$field)) {
                            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $model->$field;
                            break;
                        }
                    }
                    
                    if (empty($imageUrl)) {
                        $imageUrl = asset('images/profile-placeholder.jpg');
                    }
                    
                    // Gerar tags baseadas nos atributos do modelo
                    $tags = [];
                    
                    if ($model->exclusivos == 'Sim') {
                        $tags[] = 'Exclusivo';
                    }
                    
                    if ($model->preferidos == 'Sim') {
                        $tags[] = 'Destaque';
                    }
                    
                    if (!empty($model->tag_principal)) {
                        $tags[] = $model->tag_principal;
                    }
                    
                    if ($model->visualizacao > 50000) {
                        $tags[] = 'Popular';
                    }
                    
                    if ($model->tipo_modelo == 'Profissional') {
                        $tags[] = 'Profissional';
                    } elseif ($model->tipo_modelo == 'Amador') {
                        $tags[] = 'Amador';
                    }
                    
                    // Garantir que haja pelo menos uma tag
                    if (empty($tags)) {
                        $tags[] = 'Novo';
                    }
                    
                    // Calcular avaliação baseada em visualizações
                    $rating = 3.5;
                    if ($model->visualizacao > 10000) $rating = 4.0;
                    if ($model->visualizacao > 50000) $rating = 4.5;
                    if ($model->visualizacao > 100000) $rating = 4.9;
                    
                    // Calcular número de vídeos (simulado)
                    $videos = round($model->visualizacao / 3000) + 5;
                    if ($videos > 60) $videos = mt_rand(40, 60);
                    
                    // Formatar seguidores
                    $followers = number_format($model->visualizacao / 10, 1) . 'K';
                    
                    // Definir papel/função do modelo
                    $role = $model->tipo_modelo ?? 'Modelo';
                    if ($model->exclusivos == 'Sim') {
                        $role = 'Modelo Exclusivo';
                    }
                    
                    // Definir atributos para badges
                    $isVerified = ($model->preferidos == 'Sim' || $model->exclusivos == 'Sim');
                    $isExclusive = ($model->exclusivos == 'Sim');
                    $isTrending = ($model->visualizacao > 50000);
                    $isNew = (strtotime($model->created_at ?? '2025-01-01') > strtotime('2025-01-01'));
                    @endphp
                    
                    <div class="creator-image" style="background-image: url('{{ $imageUrl }}')">
                        <div class="creator-badges">
                            @if($isVerified)
                                <span class="badge verified">
                                    <i class="lucide-badge-check"></i>
                                </span>
                            @endif
                            
                            @if($isExclusive)
                                <span class="badge exclusive">
                                    <i class="lucide-crown"></i>
                                </span>
                            @endif
                            
                            @if($isTrending)
                                <span class="badge trending">
                                    <i class="lucide-trending-up"></i>
                                </span>
                            @endif
                            
                            @if($isNew)
                                <span class="badge new">
                                    <i class="lucide-sparkles"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                    <h3>{{ $model->nome }}</h3>
                    <p class="creator-role">{{ $role }}</p>
                    <div class="creator-stats">
                        <div class="stat">
                            <i class="lucide-video"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $videos }}</span>
                                <span class="stat-label">Vídeos</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-users"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $followers }}</span>
                                <span class="stat-label">Seguidores</span>
                            </div>
                        </div>
                        
                        <div class="stat">
                            <i class="lucide-star"></i>
                            <div class="stat-info">
                                <span class="stat-value">{{ $rating }}</span>
                                <span class="stat-label">Avaliação</span>
                            </div>
                        </div>
                    </div>
                    <div class="creator-tags">
                        @foreach($tags as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="creator-preview">
                        <a href="{{ url('/modelo/' . strtolower(str_replace(' ', '-', $model->nome))) }}" class="btn-primary">
                            <i class="lucide-eye"></i> Ver Perfil
                        </a>
                    </div>
                </div>
            @empty
                <div class="no-creators">
                    <p>Nenhum modelo encontrado. Volte em breve para novidades!</p>
                </div>
            @endforelse
        </div>
        
        <!-- Destaques e números -->
        <div class="creators-stats-section">
            <div class="stats-container">
                @php
                // Estatísticas reais do banco de dados
                $totalModels = DB::table('modelos')->where('status', 'Ativo')->count();
                $exclusiveModels = DB::table('modelos')->where('status', 'Ativo')->where('exclusivos', 'Sim')->count();
                $totalVideos = DB::table('cenas')->where('status', 'Ativo')->count();
                
                // Cálculo da classificação média
                $avgRating = DB::table('modelos')
                    ->where('status', 'Ativo')
                    ->avg('visualizacao');
                $avgRating = 3.5;
                if ($avgRating > 10000) $avgRating = 4.0;
                if ($avgRating > 50000) $avgRating = 4.5;
                if ($avgRating > 100000) $avgRating = 4.9;
                
                // Arredondamento para 1 casa decimal
                $avgRating = round($avgRating, 1);
                
                // Novos vídeos por semana (valor fixo para exibição)
                $newVideosPerWeek = 20;
                @endphp
                
                <div class="creator-stat-card">
                    <div class="stat-number">{{ $totalModels }}+</div>
                    <div class="stat-label">Modelos exclusivos</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">{{ $totalVideos }}+</div>
                    <div class="stat-label">Vídeos disponíveis</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">{{ $newVideosPerWeek }}+</div>
                    <div class="stat-label">Novos vídeos por semana</div>
                </div>
                
                <div class="creator-stat-card">
                    <div class="stat-number">{{ $avgRating }}</div>
                    <div class="stat-label">Avaliação média</div>
                </div>
            </div>
        </div>
        
        <!-- Seção de modelos novos -->
        <div class="new-creators-section">
            <h2>Novos Modelos</h2>
            <p>Conheça os modelos que acabaram de chegar na plataforma e explore conteúdos inéditos.</p>
            
            <div class="new-creators-grid">
                @php
                // Buscar modelos recentes
                $newModels = DB::table('modelos')
                    ->where('status', 'Ativo')
                    ->orderBy('id', 'desc')
                    ->take(4)
                    ->get();
                @endphp
                
                @foreach($newModels as $model)
                    @php
                    // Processar a imagem do modelo
                    $imageUrl = '';
                    $imageFields = ['foto_principal', 'modelo_perfil', 'modelo_elenco', 'modelo_home'];
                    
                    foreach ($imageFields as $field) {
                        if (!empty($model->$field)) {
                            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $model->$field;
                            break;
                        }
                    }
                    
                    if (empty($imageUrl)) {
                        $imageUrl = asset('images/profile-placeholder.jpg');
                    }
                    
                    // Definir papel/função do modelo
                    $role = $model->tipo_modelo ?? 'Modelo';
                    @endphp
                    
                    <div class="new-creator-card">
    <div class="new-creator-image">
    @php
  $fileName = basename(parse_url($imageUrl, PHP_URL_PATH));
@endphp

<picture>
  <source
    srcset="{{ url('img/'.$fileName) }}"
    type="image/webp">
  <img
    src="{{ url('img/'.$fileName) }}"
    loading="lazy"
    alt="{{ $model->nome }}"
    width="300"
    height="300"/>
</picture>


        <div class="new-badge">NOVO</div>
    </div>
    <div class="new-creator-info">
        <h3>{{ $model->nome }}</h3>
        <p class="creator-role">{{ $role }}</p>
        <a
            href="{{ url('/modelo/' . Str::slug($model->nome)) }}"
            class="btn-outline">
            Ver Perfil
        </a>
    </div>
</div>
                @endforeach
            </div>
        </div>
        
        <!-- Seção de incentivo -->
        <div class="creators-cta">
            <h2>Tenha acesso a todos os modelos e seus conteúdos</h2>
            <p>Assine agora o HotBoys VIP e desfrute de acesso ilimitado a todos os vídeos e modelos exclusivos da plataforma. Novos conteúdos são adicionados diariamente!</p>
            
            <div class="pricing-cards">
                <div class="pricing-card">
                    <div class="pricing-name">Mensal</div>
                    <div class="pricing-price">R$ 49,90<span>/mês</span></div>
                    <ul class="pricing-features">
                        <li><i class="lucide-check"></i> Acesso a todos os modelos</li>
                        <li><i class="lucide-check"></i> Conteúdo em 4K Ultra HD</li>
                        <li><i class="lucide-check"></i> Sem anúncios</li>
                        <li><i class="lucide-check"></i> Download offline</li>
                    </ul>
                    <a href="{{ url('/signup') }}" class="btn-primary">Assinar Agora</a>
                </div>
                
                <div class="pricing-card featured">
                    <div class="pricing-tag">Mais vantajoso</div>
                    <div class="pricing-name">Anual</div>
                    <div class="pricing-price">R$ 29,90<span>/mês</span></div>
                    <div class="pricing-save">Economize R$ 240 por ano</div>
                    <ul class="pricing-features">
                        <li><i class="lucide-check"></i> Acesso a todos os modelos</li>
                        <li><i class="lucide-check"></i> Conteúdo em 4K Ultra HD</li>
                        <li><i class="lucide-check"></i> Sem anúncios</li>
                        <li><i class="lucide-check"></i> Download offline</li>
                        <li><i class="lucide-check"></i> Acesso prioritário a novos vídeos</li>
                        <li><i class="lucide-check"></i> Conteúdo exclusivo para assinantes anuais</li>
                    </ul>
                    <a href="{{ url('/signup?plan=annual') }}" class="btn-primary">Assinar com Desconto</a>
                </div>
            </div>
            
            <p class="satisfaction-guarantee">
                <i class="lucide-shield"></i> Satisfação garantida ou seu dinheiro de volta em até 7 dias
            </p>
        </div>
        
        <!-- Seção de modelos mais populares -->
        <div class="popular-creators-section">
            <h2>Modelos Mais Populares</h2>
            <p>Os modelos mais vistos e desejados da plataforma.</p>
            
            <div class="popular-creators-grid">
                @php
                // Buscar modelos mais populares
                $popularModels = DB::table('modelos')
                    ->where('status', 'Ativo')
                    ->orderBy('visualizacao', 'desc')
                    ->take(8)
                    ->get();
                @endphp
                
                @foreach($popularModels as $model)
                    @php
                    // Processar a imagem do modelo
                    $imageUrl = '';
                    $imageFields = ['foto_principal', 'modelo_perfil', 'modelo_elenco', 'modelo_home'];
                    
                    foreach ($imageFields as $field) {
                        if (!empty($model->$field)) {
                            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $model->$field;
                            break;
                        }
                    }
                    
                    if (empty($imageUrl)) {
                        $imageUrl = asset('images/profile-placeholder.jpg');
                    }
                    @endphp
                    
                    <div class="popular-creator-item">
                        <a href="{{ url('/modelo/' . strtolower(str_replace(' ', '-', $model->nome))) }}" class="popular-creator-link">
                            <div class="popular-creator-image" style="background-image: url('{{ $imageUrl }}')"></div>
                            <div class="popular-creator-overlay">
                                <h4>{{ $model->nome }}</h4>
                                <span class="views-count">{{ number_format($model->visualizacao) }} visualizações</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div class="view-all-link">
                <a href="{{ url('/modelos') }}" class="btn-outline">Ver Todos os Modelos</a>
            </div>
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
                    <p class="testimonial-text">"A melhor plataforma que já assinei. Os modelos são incríveis e o conteúdo é de altíssima qualidade. Vale cada centavo!"</p>
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
                    <p class="testimonial-text">"Depois que conheci o HotBoys, cancelei todas as outras assinaturas. A qualidade do conteúdo e dos modelos é incomparável."</p>
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
                    <p class="testimonial-text">"Os modelos exclusivos do HotBoys são simplesmente os melhores. Experimentei o plano mensal e logo mudei para o anual. Vale muito a pena!"</p>
                    <p class="testimonial-author">Marcos S., assinante VIP há 8 meses</p>
                </div>
            </div>
        </div>
        
        <!-- FAQ simplificado -->
        <div class="creators-faq">
            <h2>Perguntas Frequentes</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    <h3>Como posso ter acesso a todos os modelos?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Para ter acesso completo a todos os modelos e seus conteúdos exclusivos, você precisa assinar um dos nossos planos VIP. Com a assinatura, você tem acesso ilimitado a todos os vídeos da plataforma.</p>
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
                    <p>Adicionamos novos vídeos diariamente e novos modelos todos os meses. Em média, mais de 20 novos vídeos exclusivos são disponibilizados por semana, garantindo que você sempre tenha conteúdo novo para assistir.</p>
                </div>
            </div>
        </div>
        
        <!-- Final CTA forte -->
        <div class="final-cta">
            <h2>Não perca mais tempo!</h2>
            <p>Junte-se aos milhares de assinantes satisfeitos e tenha acesso aos melhores modelos do Brasil.</p>
            <a href="{{ url('/signup') }}" class="btn-primary cta-pulse">Começar Agora</a>
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
    
    .creator-preview .btn-primary {
        width: 100%;
        padding: 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    /* Seção de novos modelos */
    .new-creators-section {
        margin-bottom: 4rem;
        text-align: center;
    }
    
    .new-creators-section h2 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        margin-bottom: 1rem;
    }
    
    .new-creators-section > p {
        max-width: 800px;
        margin: 0 auto 2rem;
        color: var(--text-secondary);
    }
    
    .new-creators-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .new-creator-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: var(--border-radius-card);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .new-creator-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(255, 51, 51, 0.2);
    }
    
    .new-creator-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }
    
    .new-creator-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .new-creator-card:hover .new-creator-image img {
        transform: scale(1.05);
    }
    
    .new-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: var(--hot-red);
        color: white;
        padding: 0.3rem 0.8rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    
    .new-creator-info {
        padding: 1.5rem;
        text-align: center;
    }
    
    .new-creator-info h3 {
        margin: 0 0 0.5rem;
        font-size: 1.3rem;
    }
    
    .new-creator-info .creator-role {
        margin-bottom: 1rem;
    }
    
    .btn-outline {
        display: inline-block;
        padding: 0.7rem 1.5rem;
        border: 2px solid var(--hot-red);
        color: var(--hot-red);
        background: transparent;
        border-radius: var(--border-radius-button);
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .btn-outline:hover {
        background: var(--hot-red);
        color: white;
    }
    
    /* Seção de modelos populares */
    .popular-creators-section {
        margin-bottom: 4rem;
        text-align: center;
    }
    
    .popular-creators-section h2 {
        font-size: clamp(1.5rem, 3vw, 2rem);
        margin-bottom: 1rem;
    }
    
    .popular-creators-section > p {
        max-width: 800px;
        margin: 0 auto 2rem;
        color: var(--text-secondary);
    }
    
    .popular-creators-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .popular-creator-item {
        position: relative;
        border-radius: var(--border-radius-card);
        overflow: hidden;
        transition: all 0.3s ease;
        aspect-ratio: 3/4;
    }
    
    .popular-creator-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(255, 51, 51, 0.3);
    }
    
    .popular-creator-link {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: var(--text-primary);
    }
    
    .popular-creator-image {
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        transition: transform 0.5s ease;
    }
    
    .popular-creator-item:hover .popular-creator-image {
        transform: scale(1.1);
    }
    
    .popular-creator-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
        text-align: left;
    }
    
    .popular-creator-overlay h4 {
        margin: 0 0 0.3rem;
        font-size: 1rem;
    }
    
    .views-count {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .view-all-link {
        margin-top: 2rem;
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
        
        .popular-creators-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
    }
    
    @media (max-width: 768px) {
        .final-cta {
            padding: 2rem 1rem;
        }
        
        .new-creator-image {
            height: 200px;
        }
    }
    
    @media (max-width: 576px) {
        .creator-stats {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .popular-creators-grid {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
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
        
        // Adicionar interatividade aos cards para melhorar a taxa de conversão
        const creatorCards = document.querySelectorAll('.creator-card');
        
        creatorCards.forEach(card => {
            // Efeito de hover mais pronunciado
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.02)';
                this.style.boxShadow = '0 15px 30px rgba(255, 51, 51, 0.3)';
                
                // Destacar o botão do perfil
                const profileBtn = this.querySelector('.btn-primary');
                if (profileBtn) {
                    profileBtn.style.background = 'var(--hot-red-bright)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = '';
                this.style.boxShadow = '';
                
                // Reverter destaque do botão
                const profileBtn = this.querySelector('.btn-primary');
                if (profileBtn) {
                    profileBtn.style.background = '';
                }
            });
        });
        
        // Inicializar o primeiro FAQ item como ativo
        if (faqItems.length > 0) {
            faqItems[0].classList.add('active');
        }
    });
</script>
@endpush