<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanosController extends Controller
{
    public function index()
    {
        // Buscar todos os planos ativos, ordenados pelo campo 'ordem'
        $planos = DB::table('planos')
            ->where('status', 'ativo')
            ->orderBy('ordem', 'asc')
            ->get();

        // Agrupar planos por período de recorrência para visualização mais organizada
        $planosPorPeriodo = [];
        foreach ($planos as $plano) {
            $periodo = $plano->periodo_recorrencia;
            if (!isset($planosPorPeriodo[$periodo])) {
                $planosPorPeriodo[$periodo] = [];
            }
            $planosPorPeriodo[$periodo][] = $plano;
        }

        // Definir vantagens de assinar
        $vantagens = [
            [
                'icone' => 'fa-lock',
                'titulo' => 'Acesso Exclusivo',
                'descricao' => 'Assista a todo nosso conteúdo premium sem restrições'
            ],
            [
                'icone' => 'fa-film',
                'titulo' => 'Conteúdo Ilimitado',
                'descricao' => 'Mais de 800 títulos disponíveis em nosso catálogo e novidades toda semana'
            ],
            [
                'icone' => 'fa-video',
                'titulo' => 'Qualidade 4K Ultra HD',
                'descricao' => 'Vídeos em altíssima definição para uma experiência imersiva'
            ],
            [
                'icone' => 'fa-mobile-alt',
                'titulo' => 'Assista onde quiser',
                'descricao' => 'Compatível com todos os dispositivos, incluindo smartphones e tablets'
            ],
            [
                'icone' => 'fa-download',
                'titulo' => 'Downloads',
                'descricao' => 'Baixe vídeos para assistir offline quando e onde quiser'
            ],
            [
                'icone' => 'fa-headset',
                'titulo' => 'Suporte 24/7',
                'descricao' => 'Atendimento personalizado para resolver qualquer problema'
            ],
        ];

        // Explicação dos tipos de pagamento
        $tiposPagamento = [
            'cartao' => [
                'icone' => 'fa-credit-card',
                'titulo' => 'Cartão de Crédito',
                'descricao' => 'Pagamento rápido e seguro com renovação automática.'
            ],
            'boleto' => [
                'icone' => 'fa-barcode',
                'titulo' => 'Boleto Bancário',
                'descricao' => 'Gere um boleto e pague em qualquer banco ou casa lotérica.'
            ],
            'pix' => [
                'icone' => 'fa-exchange-alt',
                'titulo' => 'PIX',
                'descricao' => 'Pagamento instantâneo disponível 24h por dia.'
            ],
            'transferencia' => [
                'icone' => 'fa-university',
                'titulo' => 'Transferência Bancária',
                'descricao' => 'Transferência direta para nossa conta corrente.'
            ],
        ];

        return view('planos', compact('planos', 'planosPorPeriodo', 'vantagens', 'tiposPagamento'));
    }

    public function assinar($codigo)
    {
        $plano = DB::table('planos')
            ->where('codigo', $codigo)
            ->where('status', 'ativo')
            ->first();

        if (!$plano) {
            return redirect()->route('planos.index')
                ->with('error', 'Plano não encontrado ou não disponível');
        }

        // Aqui você redirecionaria para o checkout ou página de pagamento
        // Por enquanto vamos apenas redirecionar com uma mensagem de exemplo
        return redirect()->route('planos.index')
            ->with('success', "Plano {$plano->titulo} selecionado. Redirecionando para pagamento...");
    }
}