namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cenas extends Model
{
    protected $table = 'cenas';
    
    // Definir os campos que podem ser preenchidos em massa
    protected $fillable = [
        'titulo', 'titulo_en', 'descricao', 'descricao_en', 'descricao_assine',
        'descricao_assine_en', 'descricao_content', 'video_code', 'video_code_en',
        'video2_code', 'teaser_code', 'teaser_code_en', 'amador_code',
        'cena_home', 'cena_lista', 'cena_video', 'cena_vitrine',
        'vitrine_destaque', 'vitrine_destaque_mobile', 'vitrine_slider',
        'cena_home_mobile', 'cena_lista_mobile', 'cena_video_mobile',
        'cena_vitrine_mobile', 'video_preview', 'video_preview_gif',
        'exibicao', 'audicoes', 'ordem', 'status', 'data_liberacao_conteudo',
        'cenas_serie', 'tag_principal', 'tempo_de_duracao', 'data',
        'visualizacao', 'ordem_api'
    ];
}

public function showCenas()
{
    // Buscar cenas ativas, ordenadas por ordem
    $cenas = Cenas::where('status', 'Ativo')
                ->orderBy('ordem', 'desc')
                ->take(10)
                ->get();
    
    // Buscar cenas em destaque para o carrossel principal
    $cenasDestaque = Cenas::where('status', 'Ativo')
                      ->where('vitrine_destaque', '!=', '')
                      ->orderBy('ordem_api', 'desc')
                      ->take(5)
                      ->get();
    
    // Retornar a view com os dados
    return view('cenas', compact('cenas', 'cenasDestaque'));
}