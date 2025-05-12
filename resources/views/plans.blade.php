<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planos de Assinatura - Hot Boys BR</title>
    
    <!-- Fontes Google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- CSS Principal -->
    <link rel="stylesheet" href="{{ asset('css/plans.css') }}">
</head>
<body>
    <!-- Seção principal de planos -->
    <div class="plans-container">
        <!-- Cabeçalho com título e descrição -->
        <header class="plans-header">
            <h1 class="plans-title">Escolha seu Plano</h1>
            <p class="plans-subtitle">Acesso ilimitado ao conteúdo mais quente do Brasil. 
                Escolha o plano ideal para você e desfrute do melhor conteúdo adulto nacional.</p>
        </header>
        
        <!-- Sistema de abas para tipos de planos -->
        <div class="plans-tabs">
            <div class="tabs-header">
                <a href="#mensal" class="tab-link active" data-tab="mensal">Mensal</a>
                <a href="#trimestral" class="tab-link" data-tab="trimestral">Trimestral <span class="save-badge">-10%</span></a>
                <a href="#anual" class="tab-link" data-tab="anual">Anual <span class="save-badge">-25%</span></a>
            </div>
            
            <!-- Conteúdo das abas -->
            <div id="mensal" class="tab-content active">
                <div class="plans-grid">
                    <!-- Plano Básico -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">Básico</h3>
                            <div class="plan-price" data-price="29.90">
                                <span class="currency">R$</span>
                                <span class="price-value">29,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">Cobrado mensalmente</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>HD 720p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>1 tela por vez</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Downloads</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-credit-card"></i>Assinar Agora
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano Premium (Destacado) -->
                    <div class="plan-card featured">
                        <div class="plan-head">
                            <span class="plan-badge">Mais Popular</span>
                            <h3 class="plan-name">Premium</h3>
                            <div class="plan-price" data-price="49.90">
                                <span class="currency">R$</span>
                                <span class="price-value">49,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">Cobrado mensalmente</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Full HD 1080p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>2 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads para assistir offline</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button primary-button">
                                <i class="fas fa-crown"></i>Assinar Premium
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano VIP -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">VIP</h3>
                            <div class="plan-price" data-price="69.90">
                                <span class="currency">R$</span>
                                <span class="price-value">69,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">Cobrado mensalmente</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4K Ultra HD</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads ilimitados</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso antecipado a novos vídeos</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-gem"></i>Assinar VIP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Aba de planos trimestrais -->
            <div id="trimestral" class="tab-content">
                <div class="plans-grid">
                    <!-- Plano Básico Trimestral -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">Básico</h3>
                            <div class="plan-price" data-price="26.90">
                                <span class="currency">R$</span>
                                <span class="price-value">26,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 80,70 a cada 3 meses</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>HD 720p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>1 tela por vez</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Downloads</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-credit-card"></i>Assinar Agora
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano Premium Trimestral (Destacado) -->
                    <div class="plan-card featured">
                        <div class="plan-head">
                            <span class="plan-badge">Mais Popular</span>
                            <h3 class="plan-name">Premium</h3>
                            <div class="plan-price" data-price="44.90">
                                <span class="currency">R$</span>
                                <span class="price-value">44,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 134,70 a cada 3 meses</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Full HD 1080p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>2 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads para assistir offline</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button primary-button">
                                <i class="fas fa-crown"></i>Assinar Premium
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano VIP Trimestral -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">VIP</h3>
                            <div class="plan-price" data-price="62.90">
                                <span class="currency">R$</span>
                                <span class="price-value">62,90</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 188,70 a cada 3 meses</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4K Ultra HD</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads ilimitados</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso antecipado a novos vídeos</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-gem"></i>Assinar VIP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Aba de planos anuais -->
            <div id="anual" class="tab-content">
                <div class="plans-grid">
                    <!-- Plano Básico Anual -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">Básico</h3>
                            <div class="plan-price" data-price="22.40">
                                <span class="currency">R$</span>
                                <span class="price-value">22,40</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 268,80 por ano</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>HD 720p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>1 tela por vez</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item unavailable">
                                <i class="fas fa-times-circle"></i>
                                <span>Downloads</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-credit-card"></i>Assinar Agora
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano Premium Anual (Destacado) -->
                    <div class="plan-card featured">
                        <div class="plan-head">
                            <span class="plan-badge">Mais Popular</span>
                            <h3 class="plan-name">Premium</h3>
                            <div class="plan-price" data-price="37.40">
                                <span class="currency">R$</span>
                                <span class="price-value">37,40</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 448,80 por ano</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Full HD 1080p</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>2 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads para assistir offline</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>2 meses grátis</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button primary-button">
                                <i class="fas fa-crown"></i>Assinar Premium
                            </button>
                        </div>
                    </div>
                    
                    <!-- Plano VIP Anual -->
                    <div class="plan-card">
                        <div class="plan-head">
                            <h3 class="plan-name">VIP</h3>
                            <div class="plan-price" data-price="52.40">
                                <span class="currency">R$</span>
                                <span class="price-value">52,40</span>
                                <small>/mês</small>
                            </div>
                            <p class="plan-period">R$ 628,80 por ano</p>
                        </div>
                        <ul class="plan-features">
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a todo conteúdo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4K Ultra HD</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>4 telas por vez</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso a conteúdo exclusivo</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Downloads ilimitados</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Acesso antecipado a novos vídeos</span>
                            </li>
                            <li class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>3 meses grátis</span>
                            </li>
                        </ul>
                        <div class="plan-action">
                            <button class="plan-button secondary-button">
                                <i class="fas fa-gem"></i>Assinar VIP
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Call to Action -->
        <div class="plans-cta">
            <h2 class="cta-title">Comece a Assistir Hoje Mesmo</h2>
            <p class="cta-text">Tenha acesso ilimitado ao melhor conteúdo adulto do Brasil. Assine agora e comece a assistir imediatamente - cancele quando quiser!</p>
            <button class="cta-button">
                <i class="fas fa-play-circle"></i>Começar Agora
            </button>
        </div>
        
        <!-- Seção de Depoimentos -->
        <section class="testimonials">
            <h2 class="testimonials-title">O Que Dizem Nossos Assinantes</h2>
            <div class="testimonials-grid">
                <!-- Depoimento 1 -->
                <div class="testimonial-card">
                    <p class="testimonial-text">Melhor site adulto brasileiro que já assinei. A qualidade do conteúdo é incrível e vale cada centavo do plano premium.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('images/avatar1.jpg') }}" alt="Avatar">
                        </div>
                        <div class="author-info">
                            <h4>Carlos M.</h4>
                            <p>Assinante há 8 meses</p>
                        </div>
                    </div>
                </div>
                
                <!-- Depoimento 2 -->
                <div class="testimonial-card">
                    <p class="testimonial-text">O plano VIP é sensacional! Adoro poder baixar os vídeos para assistir quando estou offline. Muito satisfeito com o serviço.</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('images/avatar2.jpg') }}" alt="Avatar">
                        </div>
                        <div class="author-info">
                            <h4>Ricardo F.</h4>
                            <p>Assinante VIP há 1 ano</p>
                        </div>
                    </div>
                </div>
                
                <!-- Depoimento 3 -->
                <div class="testimonial-card">
                    <p class="testimonial-text">Assinei o plano anual e economizei muito. O suporte é excelente e o conteúdo é atualizado frequentemente. Recomendo!</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">
                            <img src="{{ asset('images/avatar3.jpg') }}" alt="Avatar">
                        </div>
                        <div class="author-info">
                            <h4>Alexandre D.</h4>
                            <p>Assinante Premium há 6 meses</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Seção de Perguntas Frequentes -->
        <section class="faq-section">
            <h2 class="faq-title">Perguntas Frequentes</h2>
            <div class="faq-container">
                <!-- Pergunta 1 -->
                <div class="faq-item">
                    <div class="faq-question">
                        Como funciona a assinatura?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Nossa assinatura é simples: você escolhe um plano, faz o pagamento e ganha acesso imediato a todo nosso conteúdo de acordo com o plano escolhido. Você pode cancelar a qualquer momento, sem taxas ou multas.
                    </div>
                </div>
                
                <!-- Pergunta 2 -->
                <div class="faq-item">
                    <div class="faq-question">
                        Posso mudar de plano depois?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Sim! Você pode fazer upgrade ou downgrade do seu plano a qualquer momento. As mudanças entram em vigor no próximo ciclo de cobrança, e calculamos proporcionalmente caso haja diferença de valor.
                    </div>
                </div>
                
                <!-- Pergunta 3 -->
                <div class="faq-item">
                    <div class="faq-question">
                        Quais formas de pagamento são aceitas?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Aceitamos cartões de crédito (Visa, Mastercard, American Express, Elo), boleto bancário, Pix e algumas carteiras digitais. Para planos anuais, também oferecemos a opção de parcelamento em até 12x no cartão.
                    </div>
                </div>
                
                <!-- Pergunta 4 -->
                <div class="faq-item">
                    <div class="faq-question">
                        Posso compartilhar minha conta?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        O compartilhamento de conta depende do seu plano. O plano Básico permite apenas 1 tela simultânea, o Premium permite 2 telas, e o VIP permite até 4 telas. Recomendamos usar seu plano de acordo com os termos de serviço.
                    </div>
                </div>
                
                <!-- Pergunta 5 -->
                <div class="faq-item">
                    <div class="faq-question">
                        Como funciona o download de vídeos?
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        Nos planos Premium e VIP, você pode baixar vídeos para assistir offline. Os vídeos baixados ficam disponíveis por 30 dias no aplicativo e são automaticamente removidos quando você cancela sua assinatura.
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    <!-- JavaScript -->
    <script src="{{ asset('js/plans.js') }}"></script>
</body>
</html>