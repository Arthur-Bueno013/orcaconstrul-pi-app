<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'data', 'status', 'total'];

    public function detalhesPedido()
    {
        return $this->hasMany(DetalhePedido::class);
    }

    public function notasFiscais()
    {
        return $this->hasMany(NotaFiscal::class);
    }
}
