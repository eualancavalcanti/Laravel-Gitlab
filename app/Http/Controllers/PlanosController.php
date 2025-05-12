<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanosController extends Controller
{
    /**
     * Exibe a lista de planos disponíveis
     */
    public function index()
    {
        // Buscar todos os planos ativos
        $planos = DB::table('planos')
            ->where('status', 'ativo')
            ->orderBy('ordem', 'asc')
            ->get();
        
        // Agrupar planos por período
        $planosPorPeriodo = [
            'anual' => $planos->where('periodo_recorrencia', 'anual'),
            'semestral' => $planos->where('periodo_recorrencia', 'semestral'),
            'trimestral' => $planos->where('periodo_recorrencia', 'trimestral'),
            'mensal' => $planos->where('periodo_recorrencia', 'mensal'),
        ];
        
        // Estatísticas para debug (remover em produção)
        $totalPlanos = $planos->count();
        $categorias = $planos->pluck('periodo_recorrencia')->unique()->count();
        
        $planosPorPeriodoCount = [
            'anual' => $planosPorPeriodo['anual']->count(),
            'semestral' => $planosPorPeriodo['semestral']->count(),
            'trimestral' => $planosPorPeriodo['trimestral']->count(),
            'mensal' => $planosPorPeriodo['mensal']->count(),
        ];
        
        $primeiroPlanoDB = $planos->first();
        
        return view('planos.index', compact('planos', 'planosPorPeriodo', 'totalPlanos', 'categorias', 'planosPorPeriodoCount', 'primeiroPlanoDB'));
    }
    
    /**
     * Mostra a página de detalhes do plano e opção para assinar
     */
    public function assinar($codigo)
    {
        // Buscar o plano pelo código
        $plano = DB::table('planos')
            ->where('codigo', $codigo)
            ->where('status', 'ativo')
            ->first();
        
        if (!$plano) {
            return redirect()->route('planos.index')->with('error', 'Plano não encontrado ou indisponível.');
        }
        
        return view('planos.assinar', compact('plano'));
    }
    
    /**
     * Exibe o formulário de pagamento para o plano escolhido
     */
    public function pagamento($codigo)
    {
        // Buscar o plano pelo código
        $plano = DB::table('planos')
            ->where('codigo', $codigo)
            ->where('status', 'ativo')
            ->first();
        
        if (!$plano) {
            return redirect()->route('planos.index')->with('error', 'Plano não encontrado ou indisponível.');
        }
        
        return view('pagamento', compact('plano'));
    }
}