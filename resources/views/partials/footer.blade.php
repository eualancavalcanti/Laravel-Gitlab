<footer>
    <div class="footer-content">
        <div class="footer-brand">
            <div class="logo">
                <i class="lucide-flame" aria-hidden="true"></i>
                <span>HotBoys</span>
            </div>
            <p>Sua plataforma premium de conteúdo adulto com experiências exclusivas.</p>
            <div class="social-links">
                <a href="#" class="social-btn" aria-label="Instagram"><i class="lucide-instagram" aria-hidden="true"></i></a>
                <a href="#" class="social-btn" aria-label="Twitter"><i class="lucide-twitter" aria-hidden="true"></i></a>
                <a href="#" class="social-btn" aria-label="Facebook"><i class="lucide-facebook" aria-hidden="true"></i></a>
            </div>
        </div>
        <div class="footer-links">
            <div class="link-group">
                <h4>Navegação</h4>
                <a href="{{ route('home') }}">Início</a>
                <a href="{{ route('catalog') }}">Catálogo VIP</a>
                <a href="{{ route('pay-per-view') }}">Pay-per-view</a>
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