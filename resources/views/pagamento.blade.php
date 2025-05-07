@extends('layouts.app')

@section('title', 'Pagamento para: ' . $plano->titulo)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/plans-modern.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .payment-page-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 30px;
        background-color: var(--card-bg);
        border-radius: var(--border-radius);
        border: 1px solid var(--card-border);
        box-shadow: 0 10px 20px var(--card-shadow);
        color: var(--text-color);
    }
    .payment-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--card-border);
    }
    .payment-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
    }
    .payment-subtitle {
        font-size: 1.1rem;
        color: #aaa;
        margin-bottom: 15px;
    }
    .plan-info-box {
        background-color: var(--secondary-color);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        border: 1px solid var(--card-border);
        text-align: center;
    }
    .plan-info-box p {
        margin-bottom: 5px;
        font-size: 1rem;
    }
    .plan-info-box strong {
        color: var(--primary-light);
    }
    .gateway-placeholder {
        border: 2px dashed var(--card-border);
        padding: 40px;
        text-align: center;
        border-radius: 8px;
        background-color: var(--secondary-color);
    }
    .gateway-placeholder i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    .gateway-placeholder p {
        font-size: 1.1rem;
        color: #ccc;
        margin-bottom: 0;
    }
    .support-text {
        text-align: center;
        margin-top: 30px;
        font-size: 0.9rem;
        color: #aaa;
    }
    .support-text a {
        color: var(--primary-light);
        text-decoration: none;
    }
    .support-text a:hover {
        text-decoration: underline;
    }
</style>
@endsection

@section('content')
<div class="payment-page-container">
    <div class="payment-header">
        <h1 class="payment-title">Processar Pagamento</h1>
        <p class="payment-subtitle">Você está assinando o plano:</p>
        <div class="plan-info-box">
            <p><strong>{{ $plano->titulo }}</strong></p>
            @if($plano->promocao && $plano->preco_promocional < $plano->preco)
                <p>Valor: <strong style="font-size: 1.2em;">R$ {{ number_format($plano->preco_promocional, 2, ',', '.') }}</strong> 
                (<span style="text-decoration: line-through; color: #aaa;">R$ {{ number_format($plano->preco, 2, ',', '.') }}</span>)
                </p>
            @else
                <p>Valor: <strong style="font-size: 1.2em;">R$ {{ number_format($plano->preco, 2, ',', '.') }}</strong></p>
            @endif
            <p>Duração: {{ $plano->duracao_dias }} dias</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Placeholder para a integração do Gateway de Pagamento --}}
    <div class="gateway-placeholder">
        <i class="fas fa-credit-card"></i>
        <p>Esta é a área onde o formulário ou a integração com o gateway de pagamento (ex: Stripe, PayPal, PagSeguro, MercadoPago) seria carregado.</p>
        <p style="font-size:0.9em; color:#aaa; margin-top:10px;">Por favor, configure seu gateway de pagamento para processar a transação.</p>
    </div>

    <div class="support-text">
        <p>Se encontrar qualquer problema durante o pagamento, por favor, <a href="{{ route('contact') }}">entre em contato com o suporte</a>.</p>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('planos.assinar', ['codigo' => $plano->codigo]) }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Detalhes da Assinatura
        </a>
    </div>

</div>
@endsection

@push('scripts')
{{-- Scripts específicos para a página de pagamento, se necessário (ex: SDK do gateway) --}}
@endpush
