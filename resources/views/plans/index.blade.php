@extends('layouts.main')

@section('title', 'HotBoys - Planos Premium')

@section('meta')
<meta name="description" content="Escolha seu plano premium no HotBoys e tenha acesso ao melhor conteúdo adulto do Brasil">
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/plans-modern.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endsection

@section('content')
<div class="container">
    <!-- Container para montagem do React -->
    <div id="plans-react-root">
        <!-- Estado de carregamento inicial -->
        <div class="plans-container loading-state">
            <div class="plans-header">
                <h1 class="plans-title">Carregando <span>Planos</span>...</h1>
                <div class="loader-container">
                    <div class="pulse-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- React e dependências -->
<script src="https://unpkg.com/react@18/umd/react.production.min.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js" crossorigin></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/framer-motion@10.12.16/dist/framer-motion.umd.min.js" crossorigin></script>
<script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

<!-- Script do componente de planos -->
<script src="{{ asset('js/plans.js') }}" type="text/babel"></script>
@endsection