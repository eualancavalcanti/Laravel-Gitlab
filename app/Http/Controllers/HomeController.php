<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Actor;
use App\Models\Creator;
use App\Models\HeroSlide;
use App\Models\Cenas;
use Illuminate\Support\Collection;

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
        
        // Buscar os demais dados para os carrosséis
        $trendingContent = Content::where('trending', true)->take(10)->get();
        $featuredActors = Actor::with('tags')->where('featured', true)->take(5)->get();
        $trendingCreators = Creator::where('trending', true)->take(4)->get();
        
        return view('home', compact('heroSlides', 'trendingContent', 'featuredActors', 'trendingCreators'));
    }
}