<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cenas extends Model
{
    protected $table = 'cenas';
    
    // Se necessário, definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'titulo', 'titulo_en', 'descricao', 'descricao_en', 'descricao_assine',
        // outros campos conforme necessário
    ];
}