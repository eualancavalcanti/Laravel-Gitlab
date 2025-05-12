<!DOCTYPE html>
<html lang="pt-BR">
<head>    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HOTBOYS - Conteúdo premium adulto de alta qualidade. Acesse nossa plataforma com vídeos exclusivos e experiências únicas.">
    <meta name="theme-color" content="#FF3333">
    @if(config('app.env') != 'production')
    <meta name="environment" content="development">
    @endif
    <title>@yield('title', 'HOTBOYS - Conteúdo Premium')</title>
    
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
      <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/creator-profile.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vitrine-fix.css') }}">
    <link rel="stylesheet" href="{{ asset('css/migration-transition.css') }}">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    
    {{-- @stack('styles') --}}
</head>
<body>
    <!-- Navegação -->
    @include('components.navbar')
    
    <!-- Conteúdo principal -->
    @yield('content')
    
    <!-- Modal de Conteúdo -->
    @include('components.content-modal')
    
    <!-- Rodapé -->
    @include('partials.footer')
        <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>    <!-- Scripts de Migração (temporário) -->
    <script src="{{ asset('js/migrate-legacy-elements.js') }}"></script>    <script src="{{ asset('js/migration-console.js') }}"></script>
    <script src="{{ asset('js/debug-cards.js') }}"></script>
    <script src="{{ asset('js/migration-validator.js') }}"></script>
    <script src="{{ asset('js/performance-monitor.js') }}"></script>
    <script src="{{ asset('js/performance-dashboard.js') }}"></script>
    {{-- Descomente a linha abaixo durante o desenvolvimento para identificar classes que precisam de migração --}}
    {{-- <script src="{{ asset('js/class-analyzer.js') }}"></script> --}}
    
    <!-- Scripts Essenciais -->
    <script src="{{ asset('js/carousel-manager.js') }}"></script>
    <script src="{{ asset('js/complementary.js') }}"></script>
    
    <!-- Scripts de Modal -->
    <script src="{{ asset('js/unified-modal-handler.js') }}"></script> <!-- Nosso manipulador principal -->
    {{-- <script src="{{ asset('js/modal-manager.js') }}"></script> --}} <!-- Removido por causar conflito -->
    
    <!-- Scripts Removidos/Comentados que causavam conflito -->
    {{-- <script src="{{ asset('js/content-modal.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/subscription-modal-handler.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/card-click-handler.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/modal-fix.js') }}"></script> --}}    {{-- <script src="{{ asset('js/event-propagation-fix.js') }}"></script> --}}    {{-- <script src="{{ asset('js/modal-diagnostic.js') }}"></script> --}}
    <script src="/js/event-diagnostics.js"></script>
    <script src="{{ asset('js/link-fix.js') }}"></script>
    <script src="{{ asset('js/link-fix-hardcore.js') }}"></script>
    
    @stack('scripts')

</body>
</html>