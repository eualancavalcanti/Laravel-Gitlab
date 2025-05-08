@extends('layouts.app')

@section('title', 'HOTBOYS - Conteúdo Premium')

@section('content')
    <!-- Hero Carrossel -->
    @include('components.hero-carousel', ['heroSlides' => $heroSlides])
    
    <!-- Carrossel de Conteúdo em Alta -->
    <div id="clientes-assistindo">
        @include('components.content-carousel', [
            'title' => 'Clientes assistindo no momento', 
            'watchingItems' => $trendingContent
        ])
    </div>
    
    <!-- Carrossel de Últimas Novidades -->
    @include('components.content-carousel', [
        'title' => 'Últimas novidades', 
        'watchingItems' => $latestContent
    ])
    
    <!-- Carrossel de Atores -->
    @include('components.actors-carousel', [
        'title' => 'Atores em Destaque', 
        'actors' => $featuredActors
    ])
    
    <!-- Criadores em Destaque -->
    @include('partials.trending-creators', ['creators' => $trendingCreators])
    
    <!-- Seção de Planos -->
    @include('partials.pricing-section')
@endsection