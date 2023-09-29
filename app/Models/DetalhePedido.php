<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalhePedido extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id','produto_id','quantidade','bairro_id', 'preco','total'];

    public function Pedido()
    {
        return $this->belongsTo(Tipo::class,"pedido_id");
    }
    public function Produto()
    {
        return $this->belongsTo(Tipo::class,"produto_id");
    }
    public function Bairro()
    {
        return $this->belongsTo(Tipo::class,"bairro_id");
    }
}
