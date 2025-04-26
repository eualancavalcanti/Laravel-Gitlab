// Em app/Models/VisitouAgora.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitouAgora extends Model
{
    protected $table = 'visitou_agora';
    
    public function cena()
    {
        return $this->belongsTo(Cenas::class, 'id_conteudo', 'id');
    }
}