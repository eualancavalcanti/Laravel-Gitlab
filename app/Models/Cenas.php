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
    
    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'data_liberacao_conteudo' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Obtém a data de liberação formatada
     *
     * @param string $format Formato da data (padrão d/m/Y H:i)
     * @return string
     */
    public function getDataLiberacaoFormatada($format = 'd/m/Y H:i')
    {
        if (!$this->data_liberacao_conteudo) {
            return '';
        }
        
        if (function_exists('format_date')) {
            return format_date($this->data_liberacao_conteudo, $format);
        }
        
        return $this->data_liberacao_conteudo->format($format);
    }
    
    /**
     * Escopo para cenas liberadas (data já passou)
     */
    public function scopeLiberadas($query)
    {
        return $query->where('data_liberacao_conteudo', '<=', now());
    }
}