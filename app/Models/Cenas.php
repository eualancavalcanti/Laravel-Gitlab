<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cenas extends Model
{
    protected $table = 'cenas';
    protected $connection = 'c1hotboys_admin';
    
    protected $fillable = [
        'titulo', 'titulo_en', 'descricao', 'descricao_en', 'descricao_assine',
        'descricao_assine_en', 'descricao_content', 'video_code', 'video_code_en',
        // Outros campos conforme necessário
    ];
}