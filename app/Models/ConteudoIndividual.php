<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConteudoIndividual extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'conteudos_individuais';

    /**
     * Indica se o modelo deve ser timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'destaque' => 'boolean',
        'status' => 'string',
        'data_liberacao_conteudo' => 'datetime',
        'habilitar_promocao' => 'boolean',
        'data_hora_validade_promocao' => 'datetime',
        'data_cadastro_produtor' => 'datetime',
        'deleted_at' => 'datetime',
        'bunny_processando_video_publico' => 'boolean',
        'bunny_processando_video_privado' => 'boolean',
        'avaliacao_pendente' => 'boolean',
        'conteudo_suspenso' => 'boolean',
        'cadastrante_recebe_comissao' => 'boolean',
    ];

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'id_produtor_creator',
        'id_categoria',
        'titulo',
        'descricao',
        'tempo_duracao_videos',
        'valor_cartao_credito',
        'valor_pagamento_internacional',
        'valor_pix',
        'habilitar_promocao',
        'valor_promocional_cartao_credito',
        'valor_promocional_pagamento_internacional',
        'valor_promocional_pix',
        'data_hora_validade_promocao',
        'destaque',
        'ordem',
        'status',
        'data_liberacao_conteudo',
        'ordem_listagem_hot',
        'arquivo_publico',
        'arquivo_privado',
        'arquivo_publico_iframe',
        'arquivo_privado_iframe',
        'arquivo_publico_id_bunny',
        'arquivo_privado_id_bunny',
        'bunny_processando_video_publico',
        'bunny_processando_video_privado',
        'avaliacao_pendente',
        'conteudo_suspenso',
        'motivo_suspensao_conteudo',
        'cadastrante_recebe_comissao',
        'checagem_conteudo_status',
        'checagem_conteudo_pendencias',
        'data_hora_ultima_alteracao_valor',
        'data_cadastro_produtor'
    ];

    /**
     * Obtém o produtor/creator associado a este conteúdo.
     */
    public function produtor()
    {
        return $this->belongsTo(Creator::class, 'id_produtor_creator');
    }

    /**
     * Obtém a categoria deste conteúdo individual.
     */
    public function categoria()
    {
        return $this->belongsTo(ConteudoIndividualCategoria::class, 'id_categoria');
    }

    /**
     * Obtém os atores/modelos associados a este conteúdo individual.
     */
    public function atores()
    {
        return $this->belongsToMany(
            Actor::class,
            'conteudos_individuais_atores',
            'id_conteudo',
            'id_ator'
        )->withPivot('recebe_comissao');
    }

    /**
     * Obtém a relação completa entre conteúdos e atores, incluindo as informações de comissão.
     */
    public function conteudosIndividuaisAtores()
    {
        return $this->hasMany(ConteudoIndividualAtor::class, 'id_conteudo');
    }

    /**
     * Verifica se o conteúdo está em destaque.
     *
     * @return bool
     */
    public function isDestaque()
    {
        return $this->destaque === 'Sim';
    }

    /**
     * Converte o valor enum 'Sim'/'Nao' para boolean na recuperação
     *
     * @param  string  $value
     * @return bool
     */
    public function getDestaqueAttribute($value)
    {
        return $value === 'Sim';
    }

    /**
     * Converte o valor boolean para enum 'Sim'/'Nao' no armazenamento
     *
     * @param  bool  $value
     * @return void
     */
    public function setDestaqueAttribute($value)
    {
        $this->attributes['destaque'] = $value ? 'Sim' : 'Nao';
    }

    /**
     * Converte o valor enum 'Sim'/'Não' para boolean na recuperação
     *
     * @param  string  $value
     * @return bool
     */
    public function getHabilitarPromocaoAttribute($value)
    {
        return $value === 'Sim';
    }

    /**
     * Converte o valor boolean para enum 'Sim'/'Não' no armazenamento
     *
     * @param  bool  $value
     * @return void
     */
    public function setHabilitarPromocaoAttribute($value)
    {
        $this->attributes['habilitar_promocao'] = $value ? 'Sim' : 'Não';
    }

    /**
     * Converte outros atributos enum 'Sim'/'Nao' para boolean
     */
    public function getBunnyProcessandoVideoPublicoAttribute($value)
    {
        return $value === 'Sim';
    }

    public function setBunnyProcessandoVideoPublicoAttribute($value)
    {
        $this->attributes['bunny_processando_video_publico'] = $value ? 'Sim' : 'Nao';
    }

    public function getBunnyProcessandoVideoPrivadoAttribute($value)
    {
        return $value === 'Sim';
    }

    public function setBunnyProcessandoVideoPrivadoAttribute($value)
    {
        $this->attributes['bunny_processando_video_privado'] = $value ? 'Sim' : 'Nao';
    }

    public function getAvaliacaoPendenteAttribute($value)
    {
        return $value === 'Sim';
    }

    public function setAvaliacaoPendenteAttribute($value)
    {
        $this->attributes['avaliacao_pendente'] = $value ? 'Sim' : 'Nao';
    }

    public function getConteudoSuspensoAttribute($value)
    {
        return $value === 'Sim';
    }

    public function setConteudoSuspensoAttribute($value)
    {
        $this->attributes['conteudo_suspenso'] = $value ? 'Sim' : 'Nao';
    }

    public function getCadastranteRecebeComissaoAttribute($value)
    {
        return $value === 'Sim';
    }

    public function setCadastranteRecebeComissaoAttribute($value)
    {
        $this->attributes['cadastrante_recebe_comissao'] = $value ? 'Sim' : 'Nao';
    }

    /**
     * Verifica se o conteúdo está ativo
     * 
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'Ativo';
    }

    /**
     * Escopo para conteúdos ativos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Ativo');
    }

    /**
     * Escopo para conteúdos em destaque
     */
    public function scopeDestaque($query)
    {
        return $query->where('destaque', 'Sim');
    }

    /**
     * Escopo para conteúdos liberados (data de liberação menor ou igual à data atual)
     */
    public function scopeLiberados($query)
    {
        return $query->where('data_liberacao_conteudo', '<=', now());
    }

    /**
     * Escopo para conteúdos em promoção
     */
    public function scopePromocao($query)
    {
        return $query->where('habilitar_promocao', 'Sim')
                    ->where(function($q) {
                        $q->whereNull('data_hora_validade_promocao')
                          ->orWhere('data_hora_validade_promocao', '>=', now());
                    });
    }
}