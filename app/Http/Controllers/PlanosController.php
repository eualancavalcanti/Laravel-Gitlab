<?php

namespace App\Http\Controllers;

use App\Models\Plano; // Adicionado para usar o Model Plano
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Adicionando para usar o DB

class PlanosController extends Controller
{
    /**
     * Exibe a lista de planos disponíveis
     */
    public function index()
    {
        // Buscar todos os planos ativos usando o Model Plano
        $planos = Plano::where('status', 'ativo')
            ->orderBy('ordem', 'asc')
            ->get();
        
        // Separar os planos por tipo de pagamento
        $planosPix = $planos->where('tipo_pagamento', 'pix');
        $planosCartao = $planos->where('tipo_pagamento', 'cartao');
        
        // Passar os planos para a view
        return view('planos.index', compact('planos', 'planosPix', 'planosCartao'));
    }
    
    /**
     * Mostra a página de detalhes do plano e opção para assinar
     */
    public function assinar($codigo)
    {
        // Buscar o plano pelo código usando o Model Plano
        $plano = Plano::where('codigo', $codigo)
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
        // Buscar o plano pelo código usando o Model Plano
        $plano = Plano::where('codigo', $codigo)
            ->where('status', 'ativo')
            ->first();
        
        if (!$plano) {
            return redirect()->route('planos.index')->with('error', 'Plano não encontrado ou indisponível.');
        }
        
        // Assumindo que você tenha uma view 'pagamento.blade.php' ou similar
        // Se a view se chamar 'pagamento.index' ou estiver em um subdiretório, ajuste aqui.
        return view('pagamento', compact('plano'));
    }

    /**
     * Retorna os planos principais do HotBoys (mensal, semestral e anual)
     * com os melhores preços para cartão e PIX
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipais()
    {
        // Consulta modificada para destacar APENAS planos de 6 meses (180 dias) como populares
        $planos = DB::select("
            SELECT 
                p1.id,
                p1.nome,
                p1.descricao,
                p1.preco,
                p1.duracao_dias,
                p1.tipo_pagamento,
                CASE 
                    WHEN p1.duracao_dias = 180 THEN 1 
                    ELSE 0 
                END as popular,
                p1.status,
                p1.created_at,
                p1.updated_at
            FROM planos p1
            JOIN (
                SELECT duracao_dias, 
                       MIN(CASE WHEN tipo_pagamento = 'cartao' THEN id ELSE NULL END) as id_cartao,
                       MIN(CASE WHEN tipo_pagamento = 'pix' THEN id ELSE NULL END) as id_pix
                FROM planos
                WHERE duracao_dias IN (30, 180, 365) AND status = 'ativo'
                GROUP BY duracao_dias
            ) p2 ON p1.duracao_dias = p2.duracao_dias AND (p1.id = p2.id_cartao OR p1.id = p2.id_pix)
            ORDER BY p1.duracao_dias, p1.tipo_pagamento
        ");

        return response()->json($planos);
    }
}