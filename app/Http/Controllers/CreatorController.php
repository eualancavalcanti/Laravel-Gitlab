<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Creator;
use App\Models\Actor;
use App\Models\Content;
use App\Models\Pack;

class CreatorController extends Controller
{
    /**
     * Exibe o perfil de um criador/ator
     *
     * @param string $username
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        // Limpa o username do @ se estiver presente
        $username = ltrim($username, '@');
        
        // Busca tanto na tabela Creator quanto Actor
        $creator = Creator::where('username', $username)->first();
        
        // Se não encontrou como Creator, busca como Actor
        if (!$creator) {
            $actor = Actor::where('username', $username)->first();
            
            // Se encontrou como Actor, cria um objeto Creator com os dados do Actor
            if ($actor) {
                $creator = (object)[
                    'id' => $actor->id,
                    'name' => $actor->name,
                    'username' => $actor->username,
                    'profile_image' => $actor->image,
                    'banner_image' => $actor->banner_image ?? 'https://server2.hotboys.com.br/arquivos/banners/default_banner.jpg',
                    'description' => $actor->description ?? 'Perfil de ' . $actor->name . '. Conheça o conteúdo exclusivo deste ator!',
                    'is_verified' => $actor->verified ?? false,
                    'videos_count' => $actor->videos ?? 0,
                    'vip_count' => $actor->vip_videos ?? 0,
                    'photos_count' => $actor->photos ?? 0,
                    'visualizacao' => $actor->views ?? 0
                ];
            } else {
                // Se não encontrou em nenhuma tabela, cria dados Mock para demonstração
                // Na produção, isso seria substituído por uma página 404
                $creator = (object)[
                    'id' => 1,
                    'name' => ucfirst($username),
                    'username' => $username,
                    'profile_image' => 'https://server2.hotboys.com.br/arquivos/profiles/default_profile.jpg',
                    'banner_image' => 'https://server2.hotboys.com.br/arquivos/banners/default_banner.jpg',
                    'description' => 'Perfil de demonstração. Conteúdo exclusivo em breve!',
                    'is_verified' => false,
                    'videos_count' => 0,
                    'vip_count' => 0,
                    'photos_count' => 0,
                    'visualizacao' => 0
                ];
            }
        }
        
        // Busca conteúdo exclusivo (simulado para perfis que não existem na DB)
        $exclusiveContent = collect([]);
        $vipContent = collect([]);
        $packs = collect([]);
        
        // Se for um perfil real, busca o conteúdo 
        // Em produção, aqui seria feita a busca real no banco de dados
        if ($creator->id) {
            // Exemplo de conteúdo simulado
            $exclusiveContent = $this->getMockExclusiveContent();
            $vipContent = $this->getMockVIPContent();
            $packs = $this->getMockPacks();
            
            // Incrementar visualização se for um objeto real
            if (is_object($creator) && method_exists($creator, 'increment')) {
                $creator->increment('visualizacao');
            }
        }
        
        return view('creators.profile', compact(
            'creator',
            'exclusiveContent',
            'vipContent',
            'packs'
        ));
    }
    
    /**
     * Métodos auxiliares para gerar conteúdo simulado
     */
    private function getMockExclusiveContent()
    {
        return collect([
            (object)[
                'id' => 101,
                'title' => 'Noite Perfeita em SP',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250327235300_H0TB0Y5_17934_CAPA_01.jpg',
                'duration' => '34:21',
                'price' => 39.90,
                'likes_count' => 1245
            ],
            (object)[
                'id' => 102,
                'title' => 'Momento Especial na Praia',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250221165801_H0TB0Y5_36703_CAPA.png.00_26_04_20.Still001.jpg',
                'duration' => '28:15',
                'price' => 29.90,
                'likes_count' => 876
            ],
            (object)[
                'id' => 103,
                'title' => 'Experiência Intensa',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250406171324_H0TB0Y5_3702_2025-03-15%2016.07.01.00_16_53_20.Still002.jpg',
                'duration' => '42:50',
                'price' => 44.90,
                'likes_count' => 1530
            ],
            (object)[
                'id' => 104,
                'title' => 'Encontro Inesquecível',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250320221236_H0TB0Y5_16536_vitrine-desktop.jpg',
                'duration' => '22:30',
                'price' => 24.90,
                'likes_count' => 687
            ]
        ]);
    }
    
    private function getMockVIPContent()
    {
        return collect([
            (object)[
                'id' => 201,
                'title' => 'Sessão Privativa',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250411021737_H0TB0Y5_51202_capa.jpg',
                'duration' => '45:12',
                'likes_count' => 2134
            ],
            (object)[
                'id' => 202,
                'title' => 'Fantasias Exclusivas',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250406171324_H0TB0Y5_3702_2025-03-15%2016.07.01.00_16_53_20.Still002.jpg',
                'duration' => '38:45',
                'likes_count' => 1872
            ],
            (object)[
                'id' => 203,
                'title' => 'Momentos Quentes',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250228194910_H0TB0Y5_50215_capa_01.jpg',
                'duration' => '52:20',
                'likes_count' => 2567
            ],
            (object)[
                'id' => 204,
                'title' => 'Experiência Sensual',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250313235544_H0TB0Y5_78642_vitrine-desktop.jpg',
                'duration' => '31:15',
                'likes_count' => 1958
            ]
        ]);
    }
    
    private function getMockPacks()
    {
        return collect([
            (object)[
                'id' => 301,
                'title' => 'Pack de Verão 2025',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250313235544_H0TB0Y5_78642_vitrine-desktop.jpg',
                'items_count' => 32,
                'price' => 89.90,
                'likes_count' => 3245
            ],
            (object)[
                'id' => 302,
                'title' => 'Ensaio Especial',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250327235300_H0TB0Y5_31394_vitrine-desktop%20(2).jpg',
                'items_count' => 24,
                'price' => 64.90,
                'likes_count' => 2130
            ],
            (object)[
                'id' => 303,
                'title' => 'Melhores Momentos',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250411021737_H0TB0Y5_35565_vitrine-desktop.jpg',
                'items_count' => 45,
                'price' => 119.90,
                'likes_count' => 3867
            ],
            (object)[
                'id' => 304,
                'title' => 'Fotos Exclusivas',
                'thumbnail' => 'https://server2.hotboys.com.br/arquivos/20250411021737_H0TB0Y5_51202_capa.jpg',
                'items_count' => 18,
                'price' => 49.90,
                'likes_count' => 1756
            ]
        ]);
    }
}