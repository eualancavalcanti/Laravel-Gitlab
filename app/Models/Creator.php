<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Creator extends Model
{
    // Tabela usada para mapear de nome_usuario para modelos
    protected $table = 'modelos';
    
    // Nome primário
    protected $primaryKey = 'id';
    
    // Mapeamento para os campos da tabela modelos
    protected $fillable = [
        'nome', 'nome_usuario', 'tipo_modelo', 'visualizacao', 'foto_principal', 
        'exclusivos', 'preferidos', 'status', 'descricao'
    ];
    
    // Mapeamento de nomes para compatibilidade com frontend
    protected $appends = [
        'name', 'username', 'role', 'followers', 'likes', 'image', 'verified', 
        'trending', 'profile_url'
    ];
    
    /**
     * Boot function para garantir que todos os criadores tenham username
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($creator) {
            if (empty($creator->nome_usuario)) {
                $creator->nome_usuario = '@' . strtolower(Str::slug($creator->nome));
            }
        });
        
        static::updating(function ($creator) {
            if (empty($creator->nome_usuario)) {
                $creator->nome_usuario = '@' . strtolower(Str::slug($creator->nome));
            }
        });
    }
    
    /**
     * Acessor para obter nome legível (compatibilidade com frontend)
     */
    public function getNameAttribute()
    {
        return $this->nome;
    }
    
    /**
     * Acessor para obter username sem @ (compatibilidade com frontend)
     */
    public function getUsernameAttribute()
    {
        return ltrim($this->nome_usuario, '@');
    }
    
    /**
     * Acessor para obter role (compatibilidade com frontend)
     */
    public function getRoleAttribute()
    {
        return $this->tipo_modelo ?? 'Modelo';
    }
    
    /**
     * Acessor para obter seguidores (compatibilidade com frontend)
     */
    public function getFollowersAttribute()
    {
        return number_format($this->visualizacao / 10) . 'K';
    }
    
    /**
     * Acessor para obter likes (compatibilidade com frontend)
     */
    public function getLikesAttribute()
    {
        return number_format($this->visualizacao / 5) . 'K';
    }
    
    /**
     * Acessor para obter caminho da imagem (compatibilidade com frontend)
     */
    public function getImageAttribute()
    {
        if (!empty($this->foto_principal)) {
            return 'https://server2.hotboys.com.br/arquivos/' . $this->foto_principal;
        }
        
        if (!empty($this->modelo_perfil)) {
            return 'https://server2.hotboys.com.br/arquivos/' . $this->modelo_perfil;
        }
        
        return 'https://server2.hotboys.com.br/arquivos/profiles/default_profile.jpg';
    }
    
    /**
     * Acessor para verificar se é verificado (compatibilidade com frontend)
     */
    public function getVerifiedAttribute()
    {
        return $this->exclusivos == 'Sim' || $this->preferidos == 'Sim';
    }
    
    /**
     * Acessor para verificar se é trending (compatibilidade com frontend)
     */
    public function getTrendingAttribute()
    {
        return $this->visualizacao > 50000;
    }
    
    /**
     * Acessor para obter o URL do perfil
     */
    public function getProfileUrlAttribute()
    {
        return route('creator.profile', ['username' => $this->username]);
    }
    
    /**
     * Relacionamento com cenas do modelo
     */
    public function cenas()
    {
        return $this->hasMany(Cena::class, 'modelo_id', 'id');
    }
    
    /**
     * Scope para buscar apenas modelos ativos
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Ativo');
    }
    
    /**
     * Scope para buscar modelos em destaque
     */
    public function scopeFeatured($query)
    {
        return $query->where('preferidos', 'Sim')
                     ->orWhere('exclusivos', 'Sim');
    }
    
    /**
     * Scope para buscar modelos populares
     */
    public function scopePopular($query)
    {
        return $query->orderBy('visualizacao', 'desc');
    }
    
    /**
     * Scope para buscar modelos recentes
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}