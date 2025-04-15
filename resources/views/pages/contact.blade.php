<!-- resources/views/pages/contact.blade.php -->
@extends('layouts.page')

@section('title', 'Contato - HotBoys')

@section('page-title', 'Entre em Contato')

@section('page-content')
    <div class="contact-container">
        <div class="contact-info">
            <div class="contact-description">
                <h2>Estamos aqui para ajudar</h2>
                <p>Nossa equipe está disponível 24 horas por dia, 7 dias por semana, para responder suas dúvidas e resolver quaisquer problemas que você possa encontrar.</p>
                
                <div class="contact-methods">
                    <div class="contact-method">
                        <i class="lucide-mail"></i>
                        <div>
                            <h3>E-mail</h3>
                            <p>suporte@hotboys.com</p>
                            <p>Resposta em até 24 horas</p>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <i class="lucide-message-circle"></i>
                        <div>
                            <h3>Chat ao Vivo</h3>
                            <p>Disponível das 9h às 21h</p>
                            <button class="btn-secondary btn-sm" id="start-chat">Iniciar Chat</button>
                        </div>
                    </div>
                    
                    <div class="contact-method">
                        <i class="lucide-phone"></i>
                        <div>
                            <h3>Telefone</h3>
                            <p>(11) 3456-7890</p>
                            <p>Segunda a sexta, 9h às 18h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="contact-form-container">
            <h2>Envie sua mensagem</h2>
            <form class="contact-form" id="contact-form">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="subject">Assunto</label>
                    <select id="subject" name="subject" required>
                        <option value="">Selecione um assunto</option>
                        <option value="account">Conta</option>
                        <option value="payment">Pagamento</option>
                        <option value="technical">Suporte Técnico</option>
                        <option value="content">Conteúdo</option>
                        <option value="partnership">Parcerias</option>
                        <option value="other">Outro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Mensagem</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-container">
                        <input type="checkbox" id="privacy" name="privacy" required>
                        <label for="privacy">Li e concordo com a <a href="{{ route('privacy') }}">Política de Privacidade</a></label>
                    </div>
                </div>
                
                <button type="submit" class="btn-primary">Enviar Mensagem</button>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .contact-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
    }
    
    .contact-info {
        display: flex;
        flex-direction: column;
    }
    
    .contact-description {
        margin-bottom: 2rem;
    }
    
    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .contact-method {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .contact-method:hover {
        background: rgba(255, 51, 51, 0.05);
        transform: translateY(-3px);
    }
    
    .contact-method i {
        color: var(--hot-red);
        font-size: 1.5rem;
        padding: 0.5rem;
        background: rgba(255, 51, 51, 0.1);
        border-radius: 50%;
    }
    
    .contact-method h3 {
        margin: 0 0 0.5rem;
        font-size: 1.1rem;
    }
    
    .contact-method p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    
    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .contact-form-container {
        background: rgba(255, 255, 255, 0.05);
        padding: 2rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .contact-form-container h2 {
        margin-top: 0;
        margin-bottom: 1.5rem;
    }
    
    .contact-form {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
    }
    
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .form-group label {
        font-weight: 500;
    }
    
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.8rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 5px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s ease;
    }
    
    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--hot-red);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.2);
    }
    
    .checkbox-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .checkbox-container input {
        width: 18px;
        height: 18px;
    }
    
    .checkbox-container label {
        font-size: 0.9rem;
        font-weight: normal;
    }
    
    @media (max-width: 992px) {
        .contact-container {
            grid-template-columns: 1fr;
        }
    }
    
    @media (max-width: 768px) {
        .contact-method {
            padding: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactForm = document.getElementById('contact-form');
        const startChatBtn = document.getElementById('start-chat');
        
        // Form submission
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.textContent;
            
            submitButton.disabled = true;
            submitButton.textContent = 'Enviando...';
            
            // Simulate API call
            setTimeout(() => {
                // Display success message
                const formContainer = document.querySelector('.contact-form-container');
                formContainer.innerHTML = `
                    <div class="success-message">
                        <i class="lucide-check-circle"></i>
                        <h2>Mensagem enviada com sucesso!</h2>
                        <p>Agradecemos seu contato. Nossa equipe responderá em breve para o e-mail fornecido.</p>
                    </div>
                `;
            }, 1500);
        });
        
        // Start chat button
        if (startChatBtn) {
            startChatBtn.addEventListener('click', function() {
                alert('Funcionalidade de chat em implementação. Por favor, utilize o formulário ou entre em contato por e-mail.');
            });
        }
    });
</script>
@endpush