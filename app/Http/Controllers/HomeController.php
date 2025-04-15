<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Actor;
use App\Models\Creator;
use App\Models\HeroSlide;

class HomeController extends Controller
{
    public function index()
    {
        // Buscar dados para os carrosséis
        $heroSlides = HeroSlide::where('active', true)->orderBy('order')->get();
        $trendingContent = Content::where('trending', true)->take(10)->get();
        $featuredActors = Actor::with('tags')->where('featured', true)->take(5)->get();
        $trendingCreators = Creator::where('trending', true)->take(4)->get();
        
        return view('home', compact('heroSlides', 'trendingContent', 'featuredActors', 'trendingCreators'));
    }
}