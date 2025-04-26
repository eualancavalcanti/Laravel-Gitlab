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
    public function index()
    {
        // Buscar as últimas cenas postadas (ativas)
        $latestCenas = Cenas::where('status', 'Ativo')
                      ->orderBy('created_at', 'desc')
                      ->take(7)
                      ->get();
        
        // Converter as cenas para o formato esperado pelo carrossel
        $heroSlides = new Collection();
        
        foreach ($latestCenas as $cena) {
            $slide = new HeroSlide();
            $slide->title = $cena->titulo;
            $slide->description = $cena->descricao;
            $slide->date = $cena->data;
            $slide->image = $cena->cena_vitrine; 
            $slide->cta_text = 'Assistir Agora';
            $slide->cta_link = '/cenas/' . $cena->id;
            $slide->active = true;
            $slide->order = $cena->ordem;
            
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
                $item = new \stdClass();
                $item->title = $cena->titulo;
                $item->video_id = $cena->id;
                $item->thumbnail = 'https://server2.hotboys.com.br/arquivos/' . $cena->cena_vitrine;
                
                // Você pode calcular ou estimar esses valores com base em dados reais
                // Por exemplo, contar quantos registros existem para este conteúdo
                $viewerCount = DB::table('visitou_agora')
                    ->where('id_conteudo', $cena->id)
                    ->count();
                
                $item->viewers = $viewerCount > 0 ? $viewerCount : rand(800, 2500);
                
                // Você poderia ter uma tabela de 'progresso_visualizacao' para armazenar o progresso
                // Por enquanto, estamos usando valores aleatórios
                $item->remaining_time = '1:30:00';
                $item->progress = rand(10, 90);
                
                $watchingItems->push($item);
            }
        }

       // Se não encontrou nenhum item ou a tabela estiver vazia,
    // podemos preencher com algumas cenas recentes
    if ($watchingItems->isEmpty()) {
        $fallbackCenas = Cenas::where('status', 'Ativo')
                    ->orderBy('created_at', 'desc')
                    ->skip(7)  // Pular as que já estão no carrossel hero
                    ->take(6)
                    ->get();
        
        foreach ($fallbackCenas as $cena) {
            $item = new \stdClass();
            $item->title = $cena->titulo;
            $item->video_id = $cena->id;
            $item->thumbnail = 'https://server2.hotboys.com.br/arquivos/' . $cena->cena_vitrine;
            $item->remaining_time = '1:30:00';
            $item->viewers = rand(800, 2500);
            $item->progress = rand(10, 90);
            
            $watchingItems->push($item);
        }
    }
       
       
        $featuredActors = Actor::with('tags')->where('featured', true)->take(5)->get();
        $trendingCreators = Creator::where('trending', true)->take(4)->get();
        
        return view('home', compact('heroSlides', 'trendingContent', 'featuredActors', 'trendingCreators'));
    }
}