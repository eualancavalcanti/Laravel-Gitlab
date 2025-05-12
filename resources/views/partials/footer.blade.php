<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <div class="logo">
                <i class="lucide-flame" aria-hidden="true"></i>
                <span>HotBoys</span>
            </div>
            <p>A plataforma mais quente da net! Conteúdo adulto premium com experiências exclusivas.</p>
            <div class="social-links">
    <a href="#" class="social-btn" aria-label="Instagram">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
        </svg>
    </a>
    <a href="#" class="social-btn" aria-label="Twitter">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"></path>
        </svg>
    </a>
    <a href="#" class="social-btn" aria-label="TikTok">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"></path>
        </svg>
    </a>
</div>
        </div>
        <div class="footer-links">
            <div class="link-group">
                <h4>Navegação</h4>
                <a href="{{ route('home') }}">Início</a>
                <a href="{{ route('catalog') }}">Catálogo VIP</a>
                <a href="{{ route('pay-per-view.index') }}">Pay-per-view</a>
                <a href="{{ route('planos.index') }}">Planos</a>
                <a href="{{ route('creators') }}">Criadores</a>
                <a href="{{ route('news') }}">Novidades</a>
            </div>
            <div class="link-group">
                <h4>Suporte</h4>
                <a href="{{ route('contact') }}">Contato</a>
                <a href="{{ route('faq') }}">FAQ</a>
                <a href="{{ route('system-status') }}">Status do Sistema</a>
                <a href="{{ route('report-issue') }}">Reportar Problema</a>
            </div>
            <div class="link-group">
                <h4>Legal</h4>
                <a href="{{ route('terms') }}">Termos de Uso</a>
                <a href="{{ route('privacy') }}">Política de Privacidade</a>
                <a href="{{ route('cookies') }}">Cookies</a>
                <a href="{{ route('licenses') }}">Licenças</a>
                <a href="{{ route('dmca') }}">DMCA</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-info">
            <p>&copy; {{ date('Y') }} HotBoys. Todos os direitos reservados.</p>
            <div class="footer-badges">
                <span class="badge"><i class="lucide-shield-check" aria-hidden="true"></i> Site Seguro</span>
                <span class="badge"><i class="lucide-credit-card" aria-hidden="true"></i> Pagamento Seguro</span>
                <span class="badge"><i class="lucide-lock" aria-hidden="true"></i> Privacidade Garantida</span>
            </div>
        </div>
    </div>
</footer>