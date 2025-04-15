<!-- resources/views/layouts/page.blade.php -->
@extends('layouts.app')

@section('content')
<div class="page-container">
    <div class="page-header">
        <h1>@yield('page-title')</h1>
    </div>
    
    <div class="page-content">
        @yield('page-content')
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-container {
        max-width: 1200px;
        margin: 100px auto 60px;
        padding: 0 2rem;
    }
    
    .page-header {
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(255, 51, 51, 0.2);
        padding-bottom: 1rem;
    }
    
    .page-header h1 {
        font-size: clamp(1.8rem, 5vw, 2.5rem);
        background: var(--gradient-hot);
        background-clip: text;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: var(--shadow-neon);
    }
    
    .page-content {
        background: rgba(18, 18, 18, 0.7);
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .page-content h2 {
        font-size: clamp(1.4rem, 4vw, 1.8rem);
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: var(--hot-red);
    }
    
    .page-content p, .page-content li {
        color: var(--text-secondary);
        margin-bottom: 1rem;
        line-height: 1.7;
    }
    
    .page-content ul, .page-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .page-content a {
        color: var(--hot-red);
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .page-content a:hover {
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .page-container {
            margin: 80px auto 40px;
            padding: 0 1rem;
        }
        
        .page-content {
            padding: 1.5rem;
        }
    }
</style>
@endpush