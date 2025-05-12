<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanoController extends Controller
{
    /**
     * Retorna os planos principais do HotBoys (mensal, semestral e anual)
     * com os melhores preços para cartão e PIX
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPrincipais()
    {
        $planos = DB::select("
            SELECT p1.*
            FROM planos p1
            JOIN (
                SELECT duracao_dias, 
                       MIN(CASE WHEN tipo_pagamento = 'cartao' AND popular = 1 THEN id 
                                WHEN tipo_pagamento = 'cartao' THEN id ELSE NULL END) as id_cartao,
                       MIN(CASE WHEN tipo_pagamento = 'pix' AND popular = 1 THEN id
                                WHEN tipo_pagamento = 'pix' THEN id ELSE NULL END) as id_pix
                FROM planos
                WHERE duracao_dias IN (30, 180, 365) AND status = 'ativo'
                GROUP BY duracao_dias
            ) p2 ON p1.duracao_dias = p2.duracao_dias AND (p1.id = p2.id_cartao OR p1.id = p2.id_pix)
            ORDER BY p1.duracao_dias, p1.tipo_pagamento
        ");

        return response()->json($planos);
    }
    
    /**
     * Retorna a página de visualização de planos
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('plans.index');
    }
}