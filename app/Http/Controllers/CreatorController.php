<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Creator;
use App\Models\Actor;
use App\Models\Content;
use App\Models\Pack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        
        // Buscar modelo pelo nome de usuário
        $creator = DB::table('modelos')
            ->where(function($query) use ($username) {
                $query->where('nome_usuario', '@' . $username)
                    ->orWhere('nome_usuario', $username);
            })
            ->where('status', 'Ativo')
            ->first();
        
        // Se não encontrou como modelo, buscar por criadores ou atores em outras tabelas
        if (!$creator) {
            $actor = Actor::where('username', $username)->first();

            $imageUrl = $this->getModelImageUrl($creator);
            $backgroundImageUrl = null;
            
            // Verificar se existe imagem de fundo
            if (!empty($creator->imagem_background)) {
                // URL completa da API Creator
                $backgroundImageUrl = 'https://api.creator.hotboys.com.br/storage/perfis/' . $creator->imagem_background;
            } else {
                // URL padrão se não tiver imagem de fundo
                $backgroundImageUrl = 'https://server2.hotboys.com.br/arquivos/banners/default_banner.jpg';
            }
            
            
            // Se encontrou como Actor, cria um objeto com os dados do actor
            if ($actor) {
                $creator = (object)[
                    'id' => $creator->id,
                    'name' => $creator->nome,
                    'username' => $creator->nome_usuario ?? '@' . strtolower(str_replace(' ', '', $creator->nome)),
                    'profile_image' => $imageUrl,
                    'banner_image' => $backgroundImageUrl,
                    'description' => $creator->descricao ?? 'Perfil de ' . $creator->nome . '. Conheça o conteúdo exclusivo deste modelo!',
                    'is_verified' => $actor->verified ?? false,
                    'videos_count' => $actor->videos ?? 0,
                    'vip_count' => $actor->vip_videos ?? 0,
                    'photos_count' => $actor->photos ?? 0,
                    'visualizacao' => $actor->views ?? 0
                ];
            } else {
                // Se não encontrou em nenhuma tabela, retornar 404
                abort(404, 'Perfil não encontrado');
            }
        } else {
            // Processar dados do modelo da tabela 'modelos'
            $imageUrl = $this->getModelImageUrl($creator);
            $backgroundImageUrl = null;

            // Verificar se existe imagem de fundo
            if (!empty($creator->imagem_background)) {
                // URL completa da API Creator
                $backgroundImageUrl = 'https://api.creator.hotboys.com.br/storage/perfis/' . $creator->imagem_background;
            } else {
                // URL padrão se não tiver imagem de fundo
                $backgroundImageUrl = 'https://server2.hotboys.com.br/arquivos/banners/default_banner.jpg';
            }
            
            // Criar objeto Creator com dados do modelo
            $creator = (object)[
                'id' => $creator->id,
                'name' => $creator->nome,
                'username' => $creator->nome_usuario ?? '@' . strtolower(str_replace(' ', '', $creator->nome)),
                'profile_image' => $imageUrl,
                'banner_image' => $backgroundImageUrl,
                'description' => $creator->descricao ?? 'Perfil de ' . $creator->nome . '. Conheça o conteúdo exclusivo deste modelo!',
                'is_verified' => ($creator->preferidos == 'Sim' || $creator->exclusivos == 'Sim'),
                'videos_count' => $this->getVideoCount($creator->id),
                'vip_count' => $this->getVipVideoCount($creator->id),
                'photos_count' => $this->getPhotoCount($creator->id),
                'visualizacao' => $creator->visualizacao ?? 0,
                'tags' => $this->getModelTags($creator),
                'age' => $creator->idade ?? 'N/A',
                'height' => $creator->altura ?? 'N/A',
                'role' => $creator->tipo_modelo ?? 'Modelo',
                'star_rating' => $this->calculateStarRating($creator->visualizacao),
                'instagram' => null,
                'twitter' => null,
                'tiktok' => null
            ];
            
            // Incrementar visualização
            DB::table('modelos')->where('id', $creator->id)->increment('visualizacao');
        }
        
        // Buscar cenas relacionadas ao modelo
        $exclusiveContent = $this->getModelContent($creator->id, 'exclusive');
        $vipContent = $this->getModelContent($creator->id, 'vip');
        $packs = $this->getModelPacks($creator->id);
        
        // Se não houver conteúdo real, usar o conteúdo simulado para demonstração
        if ($exclusiveContent->isEmpty()) {
            $exclusiveContent = $this->getMockExclusiveContent();
        }
        
        if ($vipContent->isEmpty()) {
            $vipContent = $this->getMockVIPContent();
        }
        
        if ($packs->isEmpty()) {
            $packs = $this->getMockPacks();
        }
        
        // Buscar modelos relacionados/sugeridos
        $relatedCreators = $this->getRelatedCreators($creator->id);
        
        return view('creators.profile', compact(
            'creator',
            'exclusiveContent',
            'vipContent',
            'packs',
            'relatedCreators'
        ));
    }
    
    /**
     * Obter URL da imagem do modelo
     */
    private function getModelImageUrl($modelo)
    {
        $imagePriority = ['foto_principal', 'modelo_perfil', 'modelo_elenco', 'modelo_home'];
        
        foreach ($imagePriority as $field) {
            if (!empty($modelo->$field)) {
                // Verificar se a imagem já tem uma URL completa
                if (strpos($modelo->$field, 'http') === 0) {
                    return $modelo->$field;
                }
                
                // Verificar se é um nome de arquivo da nova convenção
                if (strpos($modelo->$field, '_H0TB0Y5_') !== false) {
                    return 'https://server2.hotboys.com.br/arquivos/' . $modelo->$field;
                }
                
                // Caso contrário, usar o nome do arquivo diretamente
                return 'https://server2.hotboys.com.br/arquivos/' . $modelo->$field;
            }
        }
        
        // Imagem padrão se nenhuma for encontrada
        return 'https://server2.hotboys.com.br/arquivos/profiles/default_profile.jpg';
    }
    
    /**
     * Obter tags/categorias do modelo
     */
    private function getModelTags($modelo)
    {
        $tags = [];
        
        if ($modelo->exclusivos == 'Sim') {
            $tags[] = 'Exclusivo';
        }
        
        if ($modelo->preferidos == 'Sim') {
            $tags[] = 'Destaque';
        }
        
        if (!empty($modelo->tag_principal)) {
            $tags[] = $modelo->tag_principal;
        }
        
        if ($modelo->visualizacao > 50000) {
            $tags[] = 'Popular';
        }
        
        if ($modelo->status_videochamada == 'Online') {
            $tags[] = 'Disponível';
        }
        
        // Adicionar tag baseada no tipo de modelo
        if (!empty($modelo->tipo_modelo)) {
            $tags[] = $modelo->tipo_modelo;
        }
        
        // Garantir que haja pelo menos uma tag
        if (empty($tags)) {
            $tags[] = 'Novo';
        }
        
        return $tags;
    }
    
    /**
     * Calcular avaliação em estrelas baseada em visualizações
     */
    private function calculateStarRating($views)
    {
        if ($views < 10000) {
            return 3.5;
        } elseif ($views < 50000) {
            return 4.0;
        } elseif ($views < 100000) {
            return 4.5;
        } else {
            return 5.0;
        }
    }
    
    /**
     * Obter contagem de vídeos do modelo
     */
    private function getVideoCount($modelId)
    {
        // Contar quantos vídeos estão associados a este modelo
        // através da tabela de relacionamento conteudos_individuais_atores
        return DB::table('conteudos_individuais_atores')
            ->where('id_ator', $modelId)
            ->join('conteudos_individuais', 'conteudos_individuais_atores.id_conteudo', '=', 'conteudos_individuais.id')
            ->where('conteudos_individuais.status', 'Ativo')
            ->count();
    }
        
      
    
    /**
     * Obter contagem de vídeos VIP do modelo
     */
    private function getVipVideoCount($modelId)
    {
        // Contar vídeos onde o modelo está vinculado
        // através da tabela de relacionamento conteudos_individuais_atores
        // e com destaque = 'Sim'
        return DB::table('conteudos_individuais_atores')
            ->where('id_ator', $modelId)
            ->join('conteudos_individuais', 'conteudos_individuais_atores.id_conteudo', '=', 'conteudos_individuais.id')
            ->where('conteudos_individuais.status', 'Ativo')
            ->where('conteudos_individuais.destaque', 'Sim')
            ->count();
    }
        
     
    
    /**
     * Obter contagem de fotos do modelo
     */
    private function getPhotoCount($modelId)
    {
        // Implementação fictícia, substituir com a lógica real quando disponível
        return rand(10, 50);
    }
    
    /**
     * Obter conteúdo do modelo
     */
    private function getModelContent($modelId, $type = 'exclusive')
    {
        // Consulta base: buscar conteúdos associados ao modelo
        $query = DB::table('conteudos_individuais_atores')
            ->where('id_ator', $modelId)
            ->join('conteudos_individuais', 'conteudos_individuais_atores.id_conteudo', '=', 'conteudos_individuais.id')
            ->where('conteudos_individuais.status', 'Ativo');
        
        // Filtrar por tipo (VIP ou normal)
        if ($type == 'vip') {
            $query->where('conteudos_individuais.destaque', 'Sim');
        } else {
            $query->where('conteudos_individuais.destaque', 'Nao');
        }
        
        $content = $query->orderBy('conteudos_individuais.data_liberacao_conteudo', 'desc')
            ->select(
                'conteudos_individuais.id',
                'conteudos_individuais.titulo',
                'conteudos_individuais.descricao',
                'conteudos_individuais.tempo_duracao_videos',
                'conteudos_individuais.valor_cartao_credito',
                'conteudos_individuais.arquivo_publico',
                'conteudos_individuais.arquivo_publico_iframe'
            )
            ->take(4)
            ->get();
        
        // Formatar os resultados
        return $content->map(function($item) use ($type) {
            // Gerar o URL da thumbnail (precisará ser ajustado conforme sua estrutura)
            $thumbnail = 'https://server2.hotboys.com.br/arquivos/thumbnails/conteudo_' . $item->id . '.jpg';
            
            // Converter o tempo de duração para formato legível
            $duration = $item->tempo_duracao_videos ? $item->tempo_duracao_videos : '30:00';
            
            return (object)[
                'id' => $item->id,
                'title' => $item->titulo,
                'thumbnail' => $thumbnail,
                'duration' => $duration,
                'price' => $type == 'exclusive' ? floatval($item->valor_cartao_credito) : null,
                'likes_count' => rand(500, 3000),
                'teaser_code' => $item->arquivo_publico_iframe
            ];
        });
    }
        
        
    /**
     * Obter pacotes do modelo
     */
    private function getModelPacks($modelId)
    {
        // Implementação fictícia, substituir com a lógica real
        return collect([]);
    }
    
    /**
     * Obter criadores relacionados
     */
    private function getRelatedCreators($currentModelId)
    {
        $relatedModels = DB::table('modelos')
            ->where('id', '!=', $currentModelId)
            ->where('status', 'Ativo')
            ->orderBy(DB::raw('RAND()'))
            ->take(4)
            ->get();
            
        return $relatedModels->map(function($model) {
            $imageUrl = $this->getModelImageUrl($model);
            
            return (object)[
                'id' => $model->id,
                'name' => $model->nome,
                'username' => $model->nome_usuario ?? '@' . strtolower(str_replace(' ', '', $model->nome)),
                'profile_image' => $imageUrl,
                'role' => $model->tipo_modelo ?? 'Modelo',
                'is_verified' => ($model->preferidos == 'Sim' || $model->exclusivos == 'Sim'),
                'followers' => number_format($model->visualizacao / 10) . 'K',
                'likes' => number_format($model->visualizacao / 5) . 'K'
            ];
        });
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