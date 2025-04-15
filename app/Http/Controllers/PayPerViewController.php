<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayPerViewController extends Controller
{
    public function index()
    {
        // Dados de exemplo para os vídeos pay-per-view
        $ppvItems = $this->getPpvItems();
        
        return view('pages.pay-per-view', [
            'ppvItems' => $ppvItems
        ]);
    }
    
    private function getPpvItems()
    {
        // Dados fictícios para demonstração
        return [
            [
                'id' => 1,
                'title' => 'Noite Quente em São Paulo',
                'thumbnail' => 'https://images.unsplash.com/photo-1566753323558-f4e0952af115?w=400&h=225&fit=crop',
                'duration' => '22:15',
                'category' => 'professional',
                'price' => 24.90,
                'views' => '12.4k',
                'rating' => 4.8,
                'creator' => [
                    'name' => 'Lucas Silva',
                    'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ],
            [
                'id' => 2,
                'title' => 'Primera Vez',
                'thumbnail' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=400&h=225&fit=crop',
                'duration' => '08:45',
                'category' => 'amateur',
                'price' => 12.90,
                'views' => '5.2k',
                'rating' => 4.5,
                'creator' => [
                    'name' => 'Pedro Alvarez',
                    'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=30&h=30&fit=crop',
                    'verified' => false
                ]
            ],
            [
                'id' => 3,
                'title' => 'Encontro Inesquecível no Rio',
                'thumbnail' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=400&h=225&fit=crop',
                'duration' => '45:20',
                'category' => 'exclusive',
                'price' => 39.90,
                'views' => '24.7k',
                'rating' => 4.9,
                'creator' => [
                    'name' => 'Bruno Costa',
                    'avatar' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ],
            [
                'id' => 4,
                'title' => 'Dominação Total',
                'thumbnail' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=400&h=225&fit=crop',
                'duration' => '18:30',
                'category' => 'fetish',
                'price' => 27.90,
                'views' => '18.3k',
                'rating' => 4.7,
                'creator' => [
                    'name' => 'Master Felipe',
                    'avatar' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ],
            [
                'id' => 5,
                'title' => 'Massagem Especial',
                'thumbnail' => 'https://images.unsplash.com/photo-1517999144091-3d9dca6d1e43?w=400&h=225&fit=crop',
                'duration' => '32:10',
                'category' => 'professional',
                'price' => 34.90,
                'views' => '32.1k',
                'rating' => 4.9,
                'creator' => [
                    'name' => 'André Martins',
                    'avatar' => 'https://images.unsplash.com/photo-1488161628813-04466f872be2?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ],
            [
                'id' => 6,
                'title' => 'Experiência na Praia',
                'thumbnail' => 'https://images.unsplash.com/photo-1501196354995-cbb51c65aaea?w=400&h=225&fit=crop',
                'duration' => '09:55',
                'category' => 'amateur',
                'price' => 14.90,
                'views' => '7.8k',
                'rating' => 4.3,
                'creator' => [
                    'name' => 'Gustavo Menezes',
                    'avatar' => 'https://images.unsplash.com/photo-1504257432389-52343af06ae3?w=30&h=30&fit=crop',
                    'verified' => false
                ]
            ],
            [
                'id' => 7,
                'title' => 'Fantasias Proibidas',
                'thumbnail' => 'https://images.unsplash.com/photo-1492288991661-058aa541ff43?w=400&h=225&fit=crop',
                'duration' => '28:45',
                'category' => 'fetish',
                'price' => 29.90,
                'views' => '15.6k',
                'rating' => 4.6,
                'creator' => [
                    'name' => 'Ricardo Alves',
                    'avatar' => 'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ],
            [
                'id' => 8,
                'title' => 'Noite de Verão',
                'thumbnail' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=225&fit=crop',
                'duration' => '35:10',
                'category' => 'exclusive',
                'price' => 44.90,
                'views' => '28.9k',
                'rating' => 4.9,
                'creator' => [
                    'name' => 'Gabriel Moreira',
                    'avatar' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?w=30&h=30&fit=crop',
                    'verified' => true
                ]
            ]
        ];
    }
}