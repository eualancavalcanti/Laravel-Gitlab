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
            
            // Se encontrou como Actor, cria um objeto com os dados do actor
            if ($actor) {
                $creator = (object)[
                    'id' => $actor->id,
                    'name' => $actor->name,
                    'username' => $actor->username,
                    'profile_image' => $actor->image,
                    'banner_image' => $actor->banner_image ?? 'https://server2.hotboys.com.br/arquivos/banners/default_banner.jpg',
                    'description' => $actor->description ?? 'Perfil de ' . $actor->name . '. Conheça o conteúdo exclusivo deste ator!',
                    'is_verified' => $actor->verified ?? false,
                    'exclusive_count' => $actor->videos ?? 0,
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
                'exclusive_count' => 0, // Será atualizado mais tarde
                'vip_count' => 0, // Será atualizado mais tarde
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
        $exclusiveContent = $this->getExclusiveContent($creator->id);
        $vipContent = $this->getVipContent($creator->id);
        $packs = $this->getModelPacks($creator->id);
        
        // Atualizar contadores com os valores reais baseados no conteúdo
        $creator->exclusive_count = $exclusiveContent->count();
        $creator->vip_count = $vipContent->count();
        
        // Determinar quais abas mostrar
        $showTabs = [
            'exclusive' => $exclusiveContent->count() > 0,
            'vip' => $vipContent->count() > 0,
            'packs' => $packs->count() > 0,
            'sobre' => true // A aba "Sobre" sempre é exibida
        ];
        
        // Definir aba ativa padrão (primeira aba disponível)
        $activeTab = 'sobre'; // Padrão para "Sobre" caso nenhuma outra esteja disponível
        
        if ($showTabs['exclusive']) {
            $activeTab = 'exclusive';
        } elseif ($showTabs['vip']) {
            $activeTab = 'vip';
        } elseif ($showTabs['packs']) {
            $activeTab = 'packs';
        }
        
        // Buscar modelos relacionados/sugeridos
        $relatedCreators = $this->getRelatedCreators($creator->id);
        
        return view('creators.profile', compact(
            'creator',
            'exclusiveContent',
            'vipContent',
            'packs',
            'relatedCreators',
            'showTabs',
            'activeTab'
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
     * Obter contagem de fotos do modelo
     */
    private function getPhotoCount($modelId)
    {
        // Implementação fictícia, substituir com a lógica real quando disponível
        return rand(10, 50);
    }

    /**
     * Obter conteúdo exclusivo do modelo
     */
    private function getExclusiveContent($modelId)
    {
        $query = DB::table('conteudos_individuais_atores')
            ->where('id_ator', $modelId)
            ->join('conteudos_individuais', 'conteudos_individuais_atores.id_conteudo', '=', 'conteudos_individuais.id')
            ->where('conteudos_individuais.status', 'Ativo')
            ->orderBy('conteudos_individuais.id', 'desc') // Ordenado por ID decrescente
            ->select(
                'conteudos_individuais.id',
                'conteudos_individuais.titulo',
                'conteudos_individuais.descricao',
                'conteudos_individuais.tempo_duracao_videos',
                'conteudos_individuais.valor_cartao_credito',
                'conteudos_individuais.arquivo_publico',
                'conteudos_individuais.arquivo_publico_iframe'
            );
            
        $content = $query->get();
            
        // Se não encontrou conteúdo, retorna uma coleção vazia
        if ($content->isEmpty()) {
            return collect([]);
        }
        
        // Formatar os resultados
        return $content->map(function($item) {
            // Gerar o URL da thumbnail 
            $thumbnail = 'https://server2.hotboys.com.br/arquivos/thumbnails/conteudo_' . $item->id . '.jpg';
            
            // Converter o tempo de duração para formato legível
            $duration = $item->tempo_duracao_videos ? $item->tempo_duracao_videos : '30:00';
            
            return (object)[
                'id' => $item->id,
                'title' => $item->titulo,
                'thumbnail' => $thumbnail,
                'duration' => $duration,
                'price' => floatval($item->valor_cartao_credito),
                'likes_count' => rand(500, 3000),
                'teaser_code' => $item->arquivo_publico_iframe
            ];
        });
    }

    /**
     * Obter conteúdo VIP do modelo (cenas da plataforma)
     */
    private function getVipContent($modelId)
    {
        $query = DB::table('associador_cenas')
            ->where('id_modelo', $modelId)
            ->join('cenas', 'associador_cenas.id_cena', '=', 'cenas.id')
            ->where('cenas.status', 'Ativo')
            ->orderBy('cenas.id', 'desc') // Ordenado por ID decrescente
            ->select(
                'cenas.id',
                'cenas.titulo',
                'cenas.descricao',
                'cenas.tempo_de_duracao',
                'cenas.cena_vitrine',
                'cenas.teaser_code'
            );
            
        $content = $query->get();
        
        // Se não encontrou conteúdo, retorna uma coleção vazia
        if ($content->isEmpty()) {
            return collect([]);
        }
        
        // Formatar os resultados
        return $content->map(function($item) {
            // Gerar o URL da thumbnail
            $thumbnail = 'https://server2.hotboys.com.br/arquivos/' . $item->cena_vitrine;
            
            return (object)[
                'id' => $item->id,
                'title' => $item->titulo,
                'thumbnail' => $thumbnail,
                'duration' => $item->tempo_de_duracao,
                'price' => null, // VIP não tem preço individual
                'likes_count' => rand(500, 3000),
                'teaser_code' => $item->teaser_code
            ];
        });
    }
    
    /**
     * Obter pacotes do modelo
     */
    private function getModelPacks($modelId)
    {
        // Implementação para buscar pacotes reais pode ser adicionada aqui
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
}