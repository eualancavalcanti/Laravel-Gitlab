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
        
        // Dados de exemplo para testes (remover em produção)
        $creator = (object)[
            'id' => 1,
            'name' => 'Diego Martins',
            'username' => $username,
            'profile_image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300&h=300&fit=crop',
            'banner_image' => 'https://images.unsplash.com/photo-1566753323558-f4e0952af115?w=1920&h=600&fit=crop',
            'description' => 'Olá! Sou Diego, 28 anos, de São Paulo. Criando conteúdo exclusivo que você não encontrará em nenhum outro lugar. Adoro interagir com meus seguidores e estou sempre aberto a sugestões para novos conteúdos. Se você gosta do meu trabalho, considere se tornar um assinante para ter acesso a todo meu conteúdo premium e exclusivo!',
            'is_verified' => true,
            'videos_count' => 42,
            'vip_count' => 18,
            'photos_count' => 156,
            'visualizacao' => 25840
        ];
        
        // Dados de exemplo para conteúdo exclusivo (remover em produção)
        $exclusiveContent = collect([
            (object)[
                'id' => 101,
                'title' => 'Noite Perfeita em SP',
                'thumbnail' => 'https://images.unsplash.com/photo-1566753323558-f4e0952af115?w=400&h=225&fit=crop',
                'duration' => '34:21',
                'price' => 39.90,
                'likes_count' => 1245
            ],
            (object)[
                'id' => 102,
                'title' => 'Momento Especial na Praia',
                'thumbnail' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=400&h=225&fit=crop',
                'duration' => '28:15',
                'price' => 29.90,
                'likes_count' => 876
            ],
            (object)[
                'id' => 103,
                'title' => 'Experiência Intensa',
                'thumbnail' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=225&fit=crop',
                'duration' => '42:50',
                'price' => 44.90,
                'likes_count' => 1530
            ],
            (object)[
                'id' => 104,
                'title' => 'Encontro Inesquecível',
                'thumbnail' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=225&fit=crop',
                'duration' => '22:30',
                'price' => 24.90,
                'likes_count' => 687
            ]
        ]);
        
        // Dados de exemplo para conteúdo VIP (remover em produção)
        $vipContent = collect([
            (object)[
                'id' => 201,
                'title' => 'Sessão Privativa',
                'thumbnail' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=225&fit=crop',
                'duration' => '45:12',
                'likes_count' => 2134
            ],
            (object)[
                'id' => 202,
                'title' => 'Fantasias Exclusivas',
                'thumbnail' => 'https://images.unsplash.com/photo-1492288991661-058aa541ff43?w=400&h=225&fit=crop',
                'duration' => '38:45',
                'likes_count' => 1872
            ],
            (object)[
                'id' => 203,
                'title' => 'Momentos Quentes',
                'thumbnail' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=225&fit=crop',
                'duration' => '52:20',
                'likes_count' => 2567
            ],
            (object)[
                'id' => 204,
                'title' => 'Experiência Sensual',
                'thumbnail' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=225&fit=crop',
                'duration' => '31:15',
                'likes_count' => 1958
            ]
        ]);
        
        // Dados de exemplo para packs (remover em produção)
        $packs = collect([
            (object)[
                'id' => 301,
                'title' => 'Pack de Verão 2025',
                'thumbnail' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=400&h=225&fit=crop',
                'items_count' => 32,
                'price' => 89.90,
                'likes_count' => 3245
            ],
            (object)[
                'id' => 302,
                'title' => 'Ensaio Especial',
                'thumbnail' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=225&fit=crop',
                'items_count' => 24,
                'price' => 64.90,
                'likes_count' => 2130
            ],
            (object)[
                'id' => 303,
                'title' => 'Melhores Momentos',
                'thumbnail' => 'https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=400&h=225&fit=crop',
                'items_count' => 45,
                'price' => 119.90,
                'likes_count' => 3867
            ],
            (object)[
                'id' => 304,
                'title' => 'Fotos Exclusivas',
                'thumbnail' => 'https://images.unsplash.com/photo-1488161628813-04466f872be2?w=400&h=225&fit=crop',
                'items_count' => 18,
                'price' => 49.90,
                'likes_count' => 1756
            ]
        ]);
        
        // Comentado para testes - descomentar em produção
        /*
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
        */
        
        return view('creators.profile', compact(
            'creator',
            'exclusiveContent',
            'vipContent',
            'packs'
        ));
    }
}