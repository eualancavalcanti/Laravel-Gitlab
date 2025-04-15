<!-- resources/views/pages/faq.blade.php -->
@extends('layouts.page')

@section('title', 'Central de Ajuda - HotBoys')

@section('page-title', 'Central de Ajuda')

@section('page-content')
    <div class="faq-container">
        <div class="faq-search">
            <input type="text" id="faq-search-input" placeholder="Buscar pergunta ou palavra-chave">
            <button class="search-btn"><i class="lucide-search"></i></button>
        </div>
        
        <div class="faq-categories">
            <button class="faq-category active" data-category="all">Todas</button>
            <button class="faq-category" data-category="account">Conta</button>
            <button class="faq-category" data-category="payment">Pagamentos</button>
            <button class="faq-category" data-category="content">Conteúdo</button>
            <button class="faq-category" data-category="technical">Técnico</button>
        </div>
        
        <div class="faq-items">
            <div class="faq-item" data-category="account">
                <div class="faq-question">
                    <h3>Como criar uma conta no HotBoys?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Para criar uma conta no HotBoys, clique no botão "Entrar" no canto superior direito da tela, e em seguida selecione "Criar conta". Você precisará fornecer um e-mail válido, criar uma senha segura e confirmar que tem pelo menos 18 anos de idade.</p>
                </div>
            </div>
            
            <div class="faq-item" data-category="account">
                <div class="faq-question">
                    <h3>Esqueci minha senha. Como posso recuperá-la?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Na tela de login, clique em "Esqueceu sua senha?". Você receberá um e-mail com instruções para criar uma nova senha. Se não receber o e-mail, verifique sua pasta de spam ou entre em contato com nosso suporte.</p>
                </div>
            </div>
            
            <div class="faq-item" data-category="payment">
                <div class="faq-question">
                    <h3>Quais formas de pagamento são aceitas?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Aceitamos as seguintes formas de pagamento:</p>
                    <ul>
                        <li>Cartões de crédito (Visa, Mastercard, American Express)</li>
                        <li>Cartões de débito</li>
                        <li>PIX</li>
                        <li>Boleto bancário</li>
                        <li>Criptomoedas (Bitcoin, Ethereum)</li>
                    </ul>
                </div>
            </div>
            
            <div class="faq-item" data-category="payment">
                <div class="faq-question">
                    <h3>Como cancelar minha assinatura?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Para cancelar sua assinatura, acesse sua conta, vá em "Configurações", selecione "Assinatura" e clique em "Cancelar assinatura". Sua assinatura permanecerá ativa até o final do período pago. Não oferecemos reembolsos por períodos parciais de assinatura.</p>
                </div>
            </div>
            
            <div class="faq-item" data-category="content">
                <div class="faq-question">
                    <h3>Posso baixar os vídeos para assistir offline?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Sim, assinantes VIP podem baixar vídeos para assistir offline. Para fazer isso, basta clicar no ícone de download abaixo do vídeo. Os downloads ficam disponíveis por 30 dias no aplicativo HotBoys.</p>
                </div>
            </div>
            
            <div class="faq-item" data-category="content">
                <div class="faq-question">
                    <h3>Com que frequência novos conteúdos são adicionados?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Adicionamos novos conteúdos diariamente. Assinantes VIP têm acesso imediato a todo conteúdo novo assim que é publicado. Você pode verificar os lançamentos mais recentes na seção "Novidades" em nossa página inicial.</p>
                </div>
            </div>
            
            <div class="faq-item" data-category="technical">
                <div class="faq-question">
                    <h3>O streaming está lento. Como posso melhorar a qualidade do vídeo?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>Se você está enfrentando problemas de velocidade no streaming, tente as seguintes soluções:</p>
                    <ul>
                        <li>Verifique sua conexão com a internet</li>
                        <li>Reduza a qualidade do vídeo nas configurações do player</li>
                        <li>Feche outros programas ou guias que possam estar usando sua largura de banda</li>
                        <li>Tente usar uma conexão com fio em vez de Wi-Fi</li>
                        <li>Limpe o cache do seu navegador</li>
                    </ul>
                </div>
            </div>
            
            <div class="faq-item" data-category="technical">
                <div class="faq-question">
                    <h3>Em quais dispositivos posso acessar o HotBoys?</h3>
                    <i class="lucide-chevron-down"></i>
                </div>
                <div class="faq-answer">
                    <p>O HotBoys pode ser acessado em múltiplos dispositivos:</p>
                    <ul>
                        <li>Navegadores em computadores (Chrome, Firefox, Safari, Edge)</li>
                        <li>Aplicativo para smartphones e tablets (iOS e Android)</li>
                        <li>Smart TVs com navegador web</li>
                        <li>Consoles de videogame com navegador web</li>
                    </ul>
                    <p>Uma assinatura VIP permite o uso simultâneo em até 3 dispositivos diferentes.</p>
                </div>
            </div>
        </div>
        
        <div class="contact-support">
            <h2>Não encontrou o que procurava?</h2>
            <p>Nossa equipe de suporte está disponível 24/7 para ajudar com qualquer dúvida ou problema.</p>
            <a href="{{ route('contact') }}" class="btn-primary">Contatar Suporte</a>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .faq-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .faq-search {
        position: relative;
        margin-bottom: 2rem;
    }
    
    .faq-search input {
        width: 100%;
        padding: 1rem 3rem 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .faq-search input:focus {
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
    
    .faq-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }
    
    .faq-category {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .faq-category:hover {
        background: rgba(255, 51, 51, 0.2);
        color: white;
    }
    
    .faq-category.active {
        background: var(--hot-red);
        color: white;
    }
    
    .faq-item {
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .faq-item:hover {
        border-color: rgba(255, 51, 51, 0.3);
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
    
    .contact-support {
        margin-top: 3rem;
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(255, 51, 51, 0.1), rgba(255, 26, 26, 0.1));
        border-radius: 15px;
        border: 1px solid rgba(255, 51, 51, 0.2);
    }
    
    .contact-support h2 {
        margin-top: 0;
    }
    
    .contact-support .btn-primary {
        margin-top: 1rem;
        display: inline-block;
    }
    
    @media (max-width: 768px) {
        .faq-categories {
            overflow-x: auto;
            padding-bottom: 0.5rem;
            flex-wrap: nowrap;
            justify-content: start;
            -webkit-overflow-scrolling: touch;
        }
        
        .faq-category {
            white-space: nowrap;
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
        
        // Category filtering
        const categoryButtons = document.querySelectorAll('.faq-category');
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Update active button
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                
                const category = button.dataset.category;
                
                // Filter items
                faqItems.forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
        
        // Search functionality
        const searchInput = document.getElementById('faq-search-input');
        
        searchInput.addEventListener('input', () => {
            const searchTerm = searchInput.value.toLowerCase();
            
            if (searchTerm.length < 2) {
                // Reset display if search term is too short
                faqItems.forEach(item => {
                    item.style.display = 'block';
                });
                return;
            }
            
            faqItems.forEach(item => {
                const question = item.querySelector('h3').textContent.toLowerCase();
                const answer = item.querySelector('.faq-answer').textContent.toLowerCase();
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Reset category buttons
            categoryButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelector('[data-category="all"]').classList.add('active');
        });
    });
</script>
@endpush