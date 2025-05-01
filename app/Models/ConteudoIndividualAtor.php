<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConteudoIndividualAtor extends Model
{
    use HasFactory;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'conteudos_individuais_atores';

    /**
     * Indica se o modelo deve ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * As colunas que podem ser atribuídas em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id_conteudo',
        'id_ator',
        'recebe_comissao'
    ];

    /**
     * Os atributos que devem ser convertidos.
     *
     * @var array
     */
    protected $casts = [
        'recebe_comissao' => 'boolean',
    ];

    /**
     * Converte o valor enum 'Sim'/'Nao' para boolean na recuperação
     *
     * @param  string  $value
     * @return bool
     */
    public function getRecebeComissaoAttribute($value)
    {
        return $value === 'Sim';
    }

    /**
     * Converte o valor boolean para enum 'Sim'/'Nao' no armazenamento
     *
     * @param  bool  $value
     * @return void
     */
    public function setRecebeComissaoAttribute($value)
    {
        $this->attributes['recebe_comissao'] = $value ? 'Sim' : 'Nao';
    }

    /**
     * Obtém o conteúdo individual associado.
     */
    public function conteudoIndividual()
    {
        return $this->belongsTo(ConteudoIndividual::class, 'id_conteudo', 'id');
    }

    /**
     * Obtém o ator/modelo associado.
     */
    public function ator()
    {
        return $this->belongsTo(Actor::class, 'id_ator', 'id');
    }
}