<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssociadorCena extends Model
{
    /**
     * Nome da tabela associada ao modelo
     */
    protected $table = 'associador_cenas';

    /**
     * Indica se as colunas created_at e updated_at devem ser utilizadas
     */
    public $timestamps = false;

    /**
     * Relacionamento com o modelo/ator
     */
    public function modelo()
    {
        return $this->belongsTo(Creator::class, 'id_modelo', 'id');
    }

    /**
     * Relacionamento com a cena
     */
    public function cena()
    {
        return $this->belongsTo(Cenas::class, 'id_cena', 'id');
    }
}