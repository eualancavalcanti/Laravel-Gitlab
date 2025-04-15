<!-- resources/views/pages/dmca.blade.php -->
@extends('layouts.page')

@section('title', 'Política DMCA - HotBoys')

@section('page-title', 'Política DMCA')

@section('page-content')
    <p>Última atualização: {{ date('d/m/Y') }}</p>

    <h2>Política de Remoção de Conteúdo Protegido por Direitos Autorais</h2>
    <p>A HotBoys respeita os direitos de propriedade intelectual de terceiros e espera que os usuários de nossa plataforma façam o mesmo. De acordo com o Digital Millennium Copyright Act (DMCA) e legislações de direitos autorais aplicáveis, a HotBoys estabeleceu esta política para responder a notificações de alegada violação de direitos autorais.</p>

    <h2>Notificação de Violação de Direitos Autorais</h2>
    <p>Se você acredita que seu trabalho protegido por direitos autorais foi copiado e disponibilizado na plataforma HotBoys de uma maneira que constitui violação de direitos autorais, por favor forneça ao nosso Agente de Direitos Autorais as seguintes informações:</p>
    
    <ol>
        <li>Uma assinatura física ou eletrônica do proprietário dos direitos autorais ou da pessoa autorizada a agir em nome do proprietário;</li>
        <li>Identificação da obra protegida por direitos autorais que você alega ter sido violada;</li>
        <li>Identificação precisa do material que você alega estar violando direitos autorais e onde ele está localizado na plataforma HotBoys, incluindo URLs específicos;</li>
        <li>Seu nome, endereço, número de telefone e endereço de e-mail;</li>
        <li>Uma declaração de que você acredita de boa-fé que o uso do material da maneira reclamada não é autorizado pelo proprietário dos direitos autorais, seu agente ou pela lei; e</li>
        <li>Uma declaração, sob pena de perjúrio, de que as informações na sua notificação são precisas e que você é o proprietário dos direitos autorais ou está autorizado a agir em nome do proprietário.</li>
    </ol>

    <h2>Procedimento de Contra-Notificação</h2>
    <p>Se o material que você postou na HotBoys foi removido como resultado de uma notificação de violação de direitos autorais, você pode apresentar uma contra-notificação se acreditar que a remoção foi um erro ou identificação incorreta. Sua contra-notificação deve incluir:</p>
    
    <ol>
        <li>Sua assinatura física ou eletrônica;</li>
        <li>Identificação do material que foi removido e o local onde o material aparecia antes de ser removido;</li>
        <li>Uma declaração sob pena de perjúrio de que você acredita de boa-fé que o material foi removido ou desativado como resultado de erro ou identificação incorreta do material a ser removido ou desativado;</li>
        <li>Seu nome, endereço e número de telefone; e</li>
        <li>Uma declaração de que você consente à jurisdição do Tribunal Federal do distrito judicial em que seu endereço está localizado, ou se seu endereço estiver fora dos Estados Unidos, do distrito judicial onde a HotBoys está localizada, e que você aceitará citação da pessoa que forneceu a notificação original ou de um agente dessa pessoa.</li>
    </ol>

    <h2>Suspensão e Encerramento de Contas por Múltiplas Violações</h2>
    <p>A HotBoys adotou e implementou uma política que prevê o encerramento, em circunstâncias apropriadas, das contas de usuários que são infratores reincidentes. Se um usuário foi identificado como reincidente por ter recebido múltiplas notificações de violação de direitos autorais, a HotBoys pode, a seu critério, encerrar a conta do usuário.</p>

    <h2>Envio de Notificações DMCA</h2>
    <p>As notificações DMCA devem ser enviadas para nosso Agente de Direitos Autorais designado:</p>
    
    <div class="dmca-contact">
        <p><strong>E-mail:</strong> <a href="mailto:dmca@hotboys.com">dmca@hotboys.com</a></p>
        <p><strong>Endereço postal:</strong><br>
        HotBoys - Agente DMCA<br>
        Av. Paulista, 1000, 10º andar<br>
        São Paulo - SP, 01310-100<br>
        Brasil</p>
    </div>

    <p>Por favor, note que, de acordo com a Seção 512(f) do DMCA, qualquer pessoa que conscientemente deturpe materialmente que o material ou atividade esteja infringindo pode estar sujeita a responsabilidade.</p>

    <div class="dmca-form-container">
        <h2>Formulário de Reclamação DMCA</h2>
        <p>Você também pode usar o formulário abaixo para enviar uma reclamação de violação de direitos autorais:</p>
        
        <form class="dmca-form" id="dmca-form">
            <div class="form-group">
                <label for="complainant-name">Nome Completo*</label>
                <input type="text" id="complainant-name" name="complainant-name" required>
            </div>
            
            <div class="form-group">
                <label for="complainant-email">E-mail*</label>
                <input type="email" id="complainant-email" name="complainant-email" required>
            </div>
            
            <div class="form-group">
                <label for="complainant-address">Endereço*</label>
                <input type="text" id="complainant-address" name="complainant-address" required>
            </div>
            
            <div class="form-group">
                <label for="complainant-phone">Telefone*</label>
                <input type="tel" id="complainant-phone" name="complainant-phone" required>
            </div>
            
            <div class="form-group">
                <label for="work-description">Descrição da Obra Protegida por Direitos Autorais*</label>
                <textarea id="work-description" name="work-description" rows="3" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="infringing-url">URL do Material Infrator na Plataforma HotBoys*</label>
                <input type="url" id="infringing-url" name="infringing-url" required placeholder="https://hotboys.com/...">
            </div>
            
            <div class="form-group">
                <label for="good-faith">Declaração de Boa-fé*</label>
                <div class="checkbox-container">
                    <input type="checkbox" id="good-faith" name="good-faith" required>
                    <label for="good-faith">Declaro de boa-fé que o uso do material da maneira reclamada não é autorizado pelo proprietário dos direitos autorais, seu agente ou pela lei.</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="accuracy">Declaração de Precisão*</label>
                <div class="checkbox-container">
                    <input type="checkbox" id="accuracy" name="accuracy" required>
                    <label for="accuracy">Declaro, sob pena de perjúrio, que as informações nesta notificação são precisas e que sou o proprietário dos direitos autorais ou estou autorizado a agir em nome do proprietário.</label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="electronic-signature">Assinatura Eletrônica*</label>
                <input type="text" id="electronic-signature" name="electronic-signature" required placeholder="Digite seu nome completo como assinatura eletrônica">
            </div>
            
            <button type="submit" class="btn-primary">Enviar Reclamação DMCA</button>
        </form>
    </div>
@endsection

@push('styles')
<style>
    .dmca-contact {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 10px;
        margin: 2rem 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .dmca-form-container {
        margin-top: 3rem;
        background: rgba(255, 255, 255, 0.05);
        padding: 2rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .dmca-form {
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        margin-top: 1.5rem;
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
    .form-group textarea:focus {
        outline: none;
        border-color: var(--hot-red);
        background: rgba(255, 255, 255, 0.15);
        box-shadow: 0 0 10px rgba(255, 51, 51, 0.2);
    }
    
    .checkbox-container {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .checkbox-container input {
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
    }
    
    .checkbox-container label {
        font-size: 0.9rem;
        font-weight: normal;
        line-height: 1.4;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dmcaForm = document.getElementById('dmca-form');
        
        if (dmcaForm) {
            dmcaForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Simulate form submission
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.textContent;
                
                submitButton.disabled = true;
                submitButton.textContent = 'Enviando...';
                
                // Simulate API call
                setTimeout(() => {
                    // Replace form with success message
                    dmcaForm.innerHTML = `
                        <div class="success-message">
                            <i class="lucide-check-circle"></i>
                            <h3>Reclamação DMCA Enviada com Sucesso</h3>
                            <p>Sua reclamação DMCA foi recebida e será analisada por nossa equipe. Você receberá uma resposta no e-mail fornecido em até 2 dias úteis.</p>
                            <p>Número de referência: DMCA-${Math.floor(Math.random() * 100000)}</p>
                        </div>
                    `;
                }, 1500);
            });
        }
    });
</script>
<style>
    .success-message {
        text-align: center;
        padding: 2rem;
        background: rgba(0, 255, 0, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(0, 255, 0, 0.2);
    }
    
    .success-message i {
        font-size: 3rem;
        color: #2ecc71;
        margin-bottom: 1rem;
    }
    
    .success-message h3 {
        margin-bottom: 1rem;
    }
</style>
@endpush