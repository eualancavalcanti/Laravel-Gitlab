<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Actor;
use App\Models\Creator;
use App\Models\HeroSlide;
use App\Models\VisitouAgora;
use App\Models\Cenas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Formata uma cena para o formato padrão dos carrosséis
     * 
     * @param object $cena A cena a ser formatada
     * @param string $remaining_time Tempo restante padrão ou especial (ex: 'Novo')
     * @param int $progress Progresso da visualização (0-100)
     * @return object Item formatado para o carrossel
     */
    private function formatCarouselItem($cena, $remaining_time = null, $progress = null)
    {
        $item = new \stdClass();
        $item->title = $cena->titulo;
        $item->video_id = $cena->id;
        
        // Lógica de fallback em cascata para imagens
        // Verificar todas as possibilidades de imagens na ordem de preferência
        $thumbnail_url = asset('images/placeholder-content.jpg'); // Valor padrão
        
        if (!empty($cena->cena_vitrine)) {
            $thumbnail_url = 'https://server2.hotboys.com.br/arquivos/' . $cena->cena_vitrine;
        } elseif (!empty($cena->cena_lista)) {
            $thumbnail_url = 'https://server2.hotboys.com.br/arquivos/' . $cena->cena_lista;
        } elseif (!empty($cena->cena_home)) {
            $thumbnail_url = 'https://server2.hotboys.com.br/arquivos/' . $cena->cena_home;
        } elseif (!empty($cena->vitrine_slider)) {
            $thumbnail_url = 'https://server2.hotboys.com.br/arquivos/' . $cena->vitrine_slider;
        }
        
        $item->thumbnail = $thumbnail_url;
        $item->thumbnail_type = $this->getImageType($cena);
        
        // Definir valores padrão caso não sejam fornecidos
        $item->remaining_time = $remaining_time ?? rand(10, 59) . ':' . rand(10, 59);
        $item->viewers = format_views($cena->visualizacao ?? 0);
        $item->progress = $progress ?? rand(10, 90);
        
        return $item;
    }
    
    /**
     * Determina qual tipo de imagem está sendo usado (para diagnóstico)
     */
    private function getImageType($cena)
    {
        if (!empty($cena->cena_vitrine)) return 'cena_vitrine';
        if (!empty($cena->cena_lista)) return 'cena_lista';
        if (!empty($cena->cena_home)) return 'cena_home';
        if (!empty($cena->vitrine_slider)) return 'vitrine_slider';
        return 'fallback';
    }

    /**
     * Formata um modelo para o padrão esperado pelo carrossel de atores
     * 
     * @param object $modelo O modelo a ser formatado
     * @return object Item formatado para o carrossel de atores
     */
    private function formatActor($modelo)
    {
        $actor = new \stdClass();
        $actor->id = $modelo->id;
        $actor->name = $modelo->nome;
        
        // Imagem do ator (com fallback)
        $imageUrl = asset('images/placeholder-actor.jpg'); // Valor padrão
        
        // Verificar qual campo de foto usar, em ordem de prioridade
        if (!empty($modelo->foto_principal)) {
            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $modelo->foto_principal;
        } elseif (!empty($modelo->modelo_perfil)) {
            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $modelo->modelo_perfil;
        } elseif (!empty($modelo->modelo_elenco)) {
            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $modelo->modelo_elenco;
        } elseif (!empty($modelo->modelo_home)) {
            $imageUrl = 'https://server2.hotboys.com.br/arquivos/' . $modelo->modelo_home;
        }
        
        $actor->image = $imageUrl;
        
        // Contagem de vídeos (buscar do associador_cenas)
        $videos_count = DB::table('associador_cenas')
            ->where('id_modelo', $modelo->id)
            ->count();
        
        $actor->videos_count = $videos_count;
        $actor->likes = format_views($modelo->visualizacao / 5); // Aproximação baseada em visualizações
        
        // Definir se é um modelo exclusivo
        $actor->exclusive = ($modelo->preferidos == 'Sim' || $modelo->exclusivos == 'Sim');
        
        // Adicionar contagem de vídeos VIP
        $vip_count = DB::table('associador_cenas')
            ->join('cenas', 'associador_cenas.id_cena', '=', 'cenas.id')
            ->where('associador_cenas.id_modelo', $modelo->id)
            ->where('cenas.exibicao', 'Vips')
            ->where('cenas.status', 'Ativo')
            ->count();
        $actor->vip_count = $vip_count;
        
        // Adicionar contagem de vídeos exclusivos
        $exclusive_count = DB::table('conteudos_individuais_atores')
            ->join('conteudos_individuais', 'conteudos_individuais_atores.id_conteudo', '=', 'conteudos_individuais.id')
            ->where('conteudos_individuais_atores.id_ator', $modelo->id)
            ->where('conteudos_individuais.status', 'Ativo')
            ->count();
        $actor->exclusive_count = $exclusive_count;
        
        return $actor;
    }

    public function index()
    {
        // Buscar as últimas cenas postadas (ativas)
        $latestCenas = Cenas::where('status', 'Ativo')
                      ->where('data_liberacao_conteudo', '<=', now()) // Garantir que o conteúdo já foi liberado
                      ->where(function($query) {
                          $query->whereNotNull('vitrine_destaque')
                                ->where('vitrine_destaque', '!=', '')
                                ->orWhereNotNull('cena_vitrine')
                                ->where('cena_vitrine', '!=', '');
                      }) // Garantir que tem pelo menos uma imagem de destaque
                      ->orderBy('data_liberacao_conteudo', 'desc') // Ordenar pela data de liberação, não pela data de criação
                      ->take(7)
                      ->get();
        
        // Converter as cenas para o formato esperado pelo carrossel
        $heroSlides = new Collection();
        
        foreach ($latestCenas as $cena) {
            $slide = new HeroSlide();
            $slide->title = $cena->titulo;
            $slide->description = $cena->descricao;
            $slide->date = $cena->data;
            
            // Lógica de fallback em cascata para imagens
            // Verificar todas as possibilidades de imagens na ordem de preferência
            if (!empty($cena->vitrine_destaque)) {
                $slide->image = $cena->vitrine_destaque;
                $slide->image_type = 'vitrine_destaque';
            } elseif (!empty($cena->cena_vitrine)) {
                $slide->image = $cena->cena_vitrine;
                $slide->image_type = 'cena_vitrine';
            } elseif (!empty($cena->vitrine_slider)) {
                $slide->image = $cena->vitrine_slider;
                $slide->image_type = 'vitrine_slider';
            } elseif (!empty($cena->cena_home)) {
                $slide->image = $cena->cena_home;
                $slide->image_type = 'cena_home';
            } elseif (!empty($cena->cena_lista)) {
                $slide->image = $cena->cena_lista;
                $slide->image_type = 'cena_lista';
            } else {
                $slide->image = '';
                $slide->image_type = 'none';
            }
            
            // Se encontramos uma imagem, definir URL completa
            if (!empty($slide->image)) {
                $slide->full_image_url = 'https://server2.hotboys.com.br/arquivos/' . $slide->image;
            } else {
                $slide->full_image_url = asset('images/hero/default.jpg');
            }
            
            $slide->cta_text = 'Assistir Agora';
            $slide->cta_link = '/cenas/' . $cena->id;
            $slide->active = true;
            $slide->order = $cena->ordem;
            $slide->video_id = $cena->id;
            
            $heroSlides->push($slide);
        }
        
        // Buscar dados da tabela visitou_agora (ou sua tabela espelho local)
        $visitantes = DB::table('visitou_agora')
            ->where('exibicao', 'Todos')
            ->groupBy('id_conteudo')
            ->orderBy('id', 'desc')
            ->skip(4)
            ->take(6)
            ->get();

        // Buscar as cenas correspondentes aos IDs de conteúdo
        $watchingItems = new Collection();
        foreach ($visitantes as $visitante) {
            $cena = Cenas::where('id', $visitante->id_conteudo)
                ->where('status', 'Ativo')
                ->where('data_liberacao_conteudo', '<=', now())
                ->first();
            
            if ($cena) {
                // Calcular o número de espectadores para este conteúdo
                $viewerCount = DB::table('visitou_agora')
                    ->where('id_conteudo', $cena->id)
                    ->count();
                
                // Formatar o número de espectadores
                $viewersFormatted = $viewerCount > 0 ? format_views($viewerCount) : format_views(rand(800, 2500));
                
                // Usar o método auxiliar para formatar o item
                $item = $this->formatCarouselItem($cena, '1:30:00', rand(10, 90));
                $item->viewers = $viewersFormatted; // Substituir com o valor específico
                
                $watchingItems->push($item);
            }
        }

        // Se não encontrou nenhum item ou a tabela estiver vazia,
        // podemos preencher com algumas cenas recentes
        if ($watchingItems->isEmpty()) {
            $fallbackCenas = Cenas::where('status', 'Ativo')
                        ->orderBy('id_produtor_creator', 'desc')
                        ->skip(7)  // Pular as que já estão no carrossel hero
                        ->take(6)
                        ->get();
            
            foreach ($fallbackCenas as $cena) {
                // Usar o método auxiliar para formatar o item
                $item = $this->formatCarouselItem($cena, '1:30:00', rand(10, 90));
                $watchingItems->push($item);
            }
        }
        
        // Buscar modelos ativos para featuredActors
        $modelosQuery = DB::table('modelos')
            ->where('status', 'Ativo')
            ->whereNotNull('foto_principal')  // Garantir que tenha foto de perfil
            ->where('foto_principal', '!=', '')  // Garantir que o campo não esteja vazio
            ->orderBy('id', 'desc')  // Ordenar pelo ID de forma decrescente (mais recentes primeiro)
            ->take(12)
            ->get();
            
        // Formatar os modelos para o formato esperado pelo carrossel de atores
        $featuredActors = new Collection();
        foreach ($modelosQuery as $modelo) {
            $formattedActor = $this->formatActor($modelo);
            $featuredActors->push($formattedActor);
        }
        
        // Consulta ilustrativa para "Clientes assistindo no momento"
        // Obtém as cenas com mais visualizações recentes
        $trendingContentResults = DB::table('cenas')
            ->where('status', 'Ativo')
            ->where('data_liberacao_conteudo', '<=', now()) // Apenas conteúdos já liberados
            ->orderBy('visualizacao', 'desc') // Ordenar por mais visualizados primeiro
            ->take(12)
            ->get();

        // Formatar os resultados para o carrossel
        $trendingContent = new Collection();
        foreach ($trendingContentResults as $cena) {
            // Usar o método auxiliar para formatar o item
            // Tempo aleatório para simular progresso de visualização
            $item = $this->formatCarouselItem($cena);
            $trendingContent->push($item);
        }

        // Consulta para "Últimas novidades" - pega os registros mais recentes
        $latestContentResults = DB::table('cenas')
            ->where('status', 'Ativo')
            ->where('data_liberacao_conteudo', '<=', now()) // Apenas conteúdos já liberados
            ->orderBy('data_liberacao_conteudo', 'desc') // Ordenar pela data de liberação
            ->take(12)
            ->get();

        // Formatar os resultados para o carrossel
        $latestContent = new Collection();
        foreach ($latestContentResults as $cena) {
            // Usar o método auxiliar para formatar o item
            // Conteúdo novo, sem progresso de visualização
            $item = $this->formatCarouselItem($cena, 'Novo', 0);
            $latestContent->push($item);
        }

        // Buscar modelos para trendingCreators - voltando para a consulta original que lista os últimos modelos
        $trendingCreators = Creator::where('status', 'Ativo')
            ->withBackgroundAndProfile() // Usa o scope para garantir que tenha foto de perfil e imagem de fundo
            ->orderBy('id_produtor_creator', 'desc') // Pega os mais recentes primeiro
            ->take(12) // Limita a 12 resultados
            ->get();

        return view('home', compact('heroSlides', 'trendingContent', 'featuredActors', 'trendingCreators', 'watchingItems', 'latestContent'));
    }
}