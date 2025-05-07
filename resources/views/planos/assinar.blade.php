@extends('layouts.app')

@section('title', 'Assinar Plano: ' . $plano->titulo)

@section('styles')
<link rel="stylesheet" href="{{ asset('css/plans-modern.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    .checkout-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background-color: var(--card-bg);
        border-radius: var(--border-radius);
        border: 1px solid var(--card-border);
        box-shadow: 0 10px 20px var(--card-shadow);
    }
    .checkout-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--card-border);
    }
    .checkout-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 5px;
    }
    .checkout-subtitle {
        font-size: 1.1rem;
        color: #aaa;
    }
    .plan-summary {
        background-color: var(--secondary-color);
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;
        border: 1px solid var(--card-border);
    }
    .plan-summary h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: #f5f5f5;
        margin-bottom: 15px;
    }
    .plan-details-list li {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid rgba(255,255,255,0.05);
        color: #ccc;
    }
    .plan-details-list li:last-child {
        border-bottom: none;
    }
    .plan-details-list strong {
        color: #f5f5f5;
    }
    .total-price {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    .payment-form .form-label {
        color: #ccc;
        margin-bottom: 8px;
        font-weight: 500;
    }
    .payment-form .form-control {
        background-color: var(--secondary-color);
        border: 1px solid var(--card-border);
        color: #f5f5f5;
        border-radius: 6px;
        padding: 10px 15px;
    }
    .payment-form .form-control:focus {
        background-color: var(--secondary-color);
        border-color: var(--primary-color);
        color: #f5f5f5;
        box-shadow: 0 0 0 0.2rem rgba(255,0,51,.25);
    }
    .payment-button {
        width: 100%;
        padding: 12px;
        font-size: 1.1rem;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <div class="checkout-header">
        <h1 class="checkout-title">Finalizar Assinatura</h1>
        <p class="checkout-subtitle">Você está a um passo de ter acesso completo!</p>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="plan-summary">
        <h4>Resumo do Plano: {{ $plano->titulo }}</h4>
        <ul class="plan-details-list list-unstyled">
            <li><span>Nome do Plano:</span> <strong>{{ $plano->nome }}</strong></li>
            <li><span>Duração:</span> <strong>{{ $plano->duracao_dias }} dias</strong></li>
            <li><span>Período:</span> <strong>{{ ucfirst($plano->periodo_recorrencia) }}</strong></li>
            <li><span>Tipo de Pagamento:</span> <strong>{{ ucfirst($plano->tipo_pagamento) }}</strong></li>
            <hr style="border-color: rgba(255,255,255,0.1);">
            <li>
                <span>Preço:</span> 
                @if($plano->promocao && $plano->preco_promocional < $plano->preco)
                    <strong class="total-price">R$ {{ number_format($plano->preco_promocional, 2, ',', '.') }}</strong>
                    <small style="text-decoration: line-through; color: #aaa;">R$ {{ number_format($plano->preco, 2, ',', '.') }}</small>
                @else
                    <strong class="total-price">R$ {{ number_format($plano->preco, 2, ',', '.') }}</strong>
                @endif
            </li>
        </ul>
    </div>

    <div class="payment-form">
        <h4 style="color: #f5f5f5; text-align:center; margin-bottom: 20px;">Informações de Pagamento</h4>
        <p class="text-center" style="color: #aaa; margin-bottom: 30px;">
            Para prosseguir com a assinatura do plano <strong style="color: var(--primary-color);">{{ $plano->titulo }}</strong>, 
            clique no botão abaixo para ser redirecionado ao nosso gateway de pagamento seguro.
        </p>
        
        <!-- Formulário de Pagamento (Exemplo) -->
        {{-- Aqui você integraria o formulário do seu gateway de pagamento ou um formulário para coletar dados de pagamento --}}
        {{-- Exemplo de botão para redirecionar para um gateway --}}
        <form action="{{ route('planos.pagamento', ['codigo' => $plano->codigo]) }}" method="GET">
            @csrf 
            {{-- Campos adicionais podem ser necessários dependendo da integração --}}
            <button type="submit" class="plan-button primary-button payment-button">
                <i class="fas fa-shield-alt"></i> Ir para Pagamento Seguro
            </button>
        </form>
        
        <p style="font-size: 0.85em; text-align: center; margin-top: 20px; color: #aaa;">
            <i class="fas fa-lock"></i> Todas as transações são seguras e criptografadas.
        </p>
    </div>

    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('planos.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar para Planos
        </a>
    </div>

</div>
@endsection

@push('scripts')
{{-- Scripts específicos para a página de assinatura, se necessário --}}
@endpush
