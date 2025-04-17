<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="HOTBOYS - Conteúdo premium adulto de alta qualidade. Acesse nossa plataforma com vídeos exclusivos e experiências únicas.">
    <meta name="theme-color" content="#FF3333">
    <title>@yield('title', 'HOTBOYSS - Conteúdo Premium')</title>
    
    <!-- Estilos -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/carousel-styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero-touch-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero-carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('css/content-modal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero-fix.css') }}">
    
    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    
    @stack('styles')
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
    
    <!-- Scripts -->
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/complementary.js') }}"></script>
    <script src="{{ asset('js/hero-touch-carousel.js') }}"></script>
    <script src="{{ asset('js/mobile-carousel.js') }}"></script>
    <script src="{{ asset('js/content-modal.js') }}"></script>
    <script src="{{ asset('js/hero-fix.js') }}"></script>
    <script src="{{ asset('js/video-modal.js') }}"></script>
    
    @stack('scripts')
</body>
</html>