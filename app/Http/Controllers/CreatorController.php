<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Creator;
use App\Models\Content;
use App\Models\Pack;

class CreatorController extends Controller
{
    /**
     * Exibe o perfil de um criador
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        // Limpa o username do @ se estiver presente
        $username = ltrim($username, '@');
        
        // Busca dados do criador
        $creator = Creator::where('username', $username)
            ->where('status', 'Ativo')
            ->where('exibicao', 'Todos')
            ->firstOrFail();
        
        // Busca conteúdo exclusivo
        $exclusiveContent = Content::where('creator_id', $creator->id)
            ->where('type', 'exclusive')
            ->where('status', 'Ativo')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        // Busca conteúdo VIP
        $vipContent = Content::where('creator_id', $creator->id)
            ->where('type', 'vip')
            ->where('status', 'Ativo')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        // Busca packs
        $packs = Pack::where('creator_id', $creator->id)
            ->where('status', 'Ativo')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
            
        // Incrementa contagem de visualizações
        $creator->increment('visualizacao');
        
        return view('creators.profile', compact(
            'creator',
            'exclusiveContent',
            'vipContent',
            'packs'
        ));
    }
}