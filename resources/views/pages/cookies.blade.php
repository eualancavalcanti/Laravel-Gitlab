<!-- resources/views/pages/cookies.blade.php -->
@extends('layouts.page')

@section('title', 'Política de Cookies - HotBoys')

@section('page-title', 'Política de Cookies')

@section('page-content')
    <p>Última atualização: {{ date('d/m/Y') }}</p>

    <h2>O que são cookies?</h2>
    <p>Cookies são pequenos arquivos de texto que são armazenados no seu computador ou dispositivo móvel quando você visita um site. Eles permitem que o site lembre suas ações e preferências (como login, idioma, tamanho da fonte e outras preferências de exibição) por um período de tempo, para que você não precise inseri-las novamente quando voltar ao site ou navegar de uma página para outra.</p>

    <h2>Como usamos cookies</h2>
    <p>A plataforma HotBoys utiliza cookies por diversas razões. Alguns cookies são necessários por razões técnicas para que nosso site funcione, e nos referimos a eles como cookies "essenciais" ou "estritamente necessários". Outros cookies nos permitem rastrear e direcionar os interesses dos nossos usuários para melhorar a experiência em nosso site. Terceiros servem cookies através do nosso site para publicidade, análise e outras finalidades.</p>

    <h2>Tipos de cookies que usamos</h2>
    <p>Os tipos específicos de cookies servidos através do nosso site e a finalidade que eles desempenham são descritos abaixo:</p>

    <h3>Cookies essenciais</h3>
    <p>Esses cookies são estritamente necessários para fornecer serviços disponíveis através do nosso site e para usar alguns de seus recursos, como acesso a áreas seguras. Como esses cookies são estritamente necessários para entregar o site, você não pode recusá-los sem impactar o funcionamento do nosso site.</p>

    <h3>Cookies de desempenho e funcionalidade</h3>
    <p>Esses cookies são usados para melhorar o desempenho e funcionalidade do nosso site, mas não são essenciais para seu uso. No entanto, sem esses cookies, certas funcionalidades podem se tornar indisponíveis.</p>

    <h3>Cookies analíticos e de personalização</h3>
    <p>Estes cookies coletam informações que são usadas para nos ajudar a entender como nosso site é usado ou a eficácia de nossas campanhas de marketing, ou para nos ajudar a personalizar nosso site para você. Esses cookies nos permitem reconhecer e contar o número de visitantes e ver como os visitantes se movem pelo nosso site quando estão usando-o.</p>

    <h3>Cookies de publicidade</h3>
    <p>Estes cookies são usados para tornar as mensagens publicitárias mais relevantes para você. Eles desempenham funções como impedir que o mesmo anúncio reapareça continuamente, garantindo que os anúncios sejam exibidos corretamente e, em alguns casos, selecionando anúncios baseados em seus interesses.</p>

    <h3>Cookies de redes sociais</h3>
    <p>Estes cookies são definidos por uma série de serviços de redes sociais que adicionamos ao site para permitir que você compartilhe nosso conteúdo com seus amigos e redes. Eles são capazes de rastrear sua navegação em outros sites e criar um perfil de seus interesses. Isso pode impactar o conteúdo e mensagens que você vê em outros sites que visita.</p>

    <h2>Como gerenciar cookies</h2>
    <p>Você pode controlar e gerenciar cookies de várias maneiras. Tenha em mente que remover ou bloquear cookies pode impactar sua experiência de usuário e partes do nosso site podem não funcionar corretamente.</p>

    <h3>Configurações do navegador</h3>
    <p>A maioria dos navegadores permite que você veja quais cookies você tem e que exclua-os individualmente ou bloqueie cookies de sites específicos ou todos os sites. Esteja ciente de que, se você excluir todos os cookies, todas as suas preferências serão perdidas, incluindo a preferência de não usar cookies, já que isso requer que um cookie seja definido.</p>

    <h3>Ferramentas de terceiros</h3>
    <p>Você também pode encontrar informações sobre cookies e como gerenciá-los em sites como <a href="https://www.allaboutcookies.org/" target="_blank">www.allaboutcookies.org</a>.</p>

    <h3>Cookies específicos de terceiros</h3>
    <p>Para desativar os cookies do Google Analytics, você pode usar o Complemento do Navegador para Desativação do Google Analytics disponível <a href="https://tools.google.com/dlpage/gaoptout" target="_blank">aqui</a>.</p>

    <h2>Alterações em nossa política de cookies</h2>
    <p>Podemos atualizar esta Política de Cookies de tempos em tempos para refletir, por exemplo, mudanças nos cookies que usamos ou por outros motivos operacionais, legais ou regulamentares. Por favor, visite regularmente esta Política de Cookies para se manter informado sobre o uso de cookies e tecnologias relacionadas.</p>

    <h2>Contato</h2>
    <p>Se você tiver dúvidas sobre como usamos cookies ou outras tecnologias, por favor entre em contato conosco pelo e-mail: <a href="mailto:privacidade@hotboys.com">privacidade@hotboys.com</a>.</p>

    <div class="cookie-management">
        <h2>Configurações de Cookies</h2>
        <p>Você pode configurar suas preferências de cookies para o site HotBoys abaixo:</p>
        
        <div class="cookie-settings">
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <div>
                        <h3>Cookies Essenciais</h3>
                        <p>Necessários para o funcionamento básico do site.</p>
                    </div>
                    <div class="toggle disabled">
                        <input type="checkbox" id="essential-cookies" checked disabled>
                        <label for="essential-cookies"></label>
                    </div>
                </div>
                <p class="helper-text">Estes cookies não podem ser desativados, pois o site não funcionaria corretamente sem eles.</p>
            </div>
            
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <div>
                        <h3>Cookies de Desempenho</h3>
                        <p>Ajudam a entender como você interage com o site.</p>
                    </div>
                    <div class="toggle">
                        <input type="checkbox" id="performance-cookies" checked>
                        <label for="performance-cookies"></label>
                    </div>
                </div>
            </div>
            
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <div>
                        <h3>Cookies de Funcionalidade</h3>
                        <p>Permitem que o site lembre escolhas que você faz.</p>
                    </div>
                    <div class="toggle">
                        <input type="checkbox" id="functionality-cookies" checked>
                        <label for="functionality-cookies"></label>
                    </div>
                </div>
            </div>
            
            <div class="cookie-option">
                <div class="cookie-option-header">
                    <div>
                        <h3>Cookies de Publicidade</h3>
                        <p>Utilizados para exibir anúncios mais relevantes.</p>
                    </div>
                    <div class="toggle">
                        <input type="checkbox" id="advertising-cookies">
                        <label for="advertising-cookies"></label>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="cookie-actions">
            <button class="btn-secondary" id="reject-all">Rejeitar Todos</button>
            <button class="btn-primary" id="accept-selected">Salvar Preferências</button>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .cookie-management {
        margin-top: 3rem;
        padding: 2rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .cookie-settings {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin: 2rem 0;
    }
    
    .cookie-option {
        padding: 1.2rem;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }
    
    .cookie-option-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .cookie-option h3 {
        margin: 0 0 0.5rem;
        font-size: 1.1rem;
    }
    
    .cookie-option p {
        margin: 0;
        font-size: 0.9rem;
        color: var(--text-secondary);
    }
    
    .helper-text {
        font-size: 0.8rem !important;
        margin-top: 0.5rem !important;
        color: rgba(255, 255, 255, 0.5) !important;
    }
    
    .toggle {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }
    
    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle label {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(255, 255, 255, 0.2);
        transition: .4s;
        border-radius: 24px;
    }
    
    .toggle label:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    .toggle input:checked + label {
        background-color: var(--hot-red);
    }
    
    .toggle input:checked + label:before {
        transform: translateX(26px);
    }
    
    .toggle.disabled label {
        opacity: 0.6;
        cursor: not-allowed;
    }
    
    .cookie-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    
    @media (max-width: 768px) {
        .cookie-option-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .cookie-actions {
            flex-direction: column;
        }
        
        .cookie-actions button {
            width: 100%;
        }
    }
</style>
@endpush

<!-- resources/views/pages/cookies.blade.php (continuação) -->
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const rejectAllBtn = document.getElementById('reject-all');
        const acceptSelectedBtn = document.getElementById('accept-selected');
        const performanceCookies = document.getElementById('performance-cookies');
        const functionalityCookies = document.getElementById('functionality-cookies');
        const advertisingCookies = document.getElementById('advertising-cookies');
        
        // Reject all cookies except essential
        rejectAllBtn.addEventListener('click', function() {
            performanceCookies.checked = false;
            functionalityCookies.checked = false;
            advertisingCookies.checked = false;
            
            saveCookiePreferences();
        });
        
        // Save selected cookie preferences
        acceptSelectedBtn.addEventListener('click', function() {
            saveCookiePreferences();
        });
        
        function saveCookiePreferences() {
            // In a real implementation, this would save preferences to cookies
            // and potentially update tracking scripts on the page
            
            const preferences = {
                essential: true, // Always true
                performance: performanceCookies.checked,
                functionality: functionalityCookies.checked,
                advertising: advertisingCookies.checked
            };
            
            console.log('Cookie preferences saved:', preferences);
            
            // Show confirmation message
            const cookieActions = document.querySelector('.cookie-actions');
            const confirmationMsg = document.createElement('div');
            confirmationMsg.className = 'confirmation-message';
            confirmationMsg.innerHTML = '<i class="lucide-check-circle"></i> Suas preferências foram salvas.';
            
            // Remove any existing confirmation message
            const existingMsg = document.querySelector('.confirmation-message');
            if (existingMsg) {
                existingMsg.remove();
            }
            
            cookieActions.insertAdjacentElement('afterend', confirmationMsg);
            
            // Remove message after a few seconds
            setTimeout(() => {
                confirmationMsg.style.opacity = '0';
                setTimeout(() => {
                    confirmationMsg.remove();
                }, 500);
            }, 3000);
        }
    });
</script>
<style>
    .confirmation-message {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 0.8rem 1rem;
        background: rgba(0, 255, 0, 0.1);
        border-radius: 5px;
        color: #2ecc71;
        font-size: 0.9rem;
        transition: opacity 0.5s ease;
    }
</style>
@endpush